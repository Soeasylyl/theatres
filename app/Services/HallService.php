<?php

namespace App\Services;

use App\DTO\Halls\CreateHallDTO;
use App\DTO\Halls\DeleteHallDTO;
use App\DTO\Halls\EditHallDTO;
use App\DTO\Halls\UpdateHallDTO;
use App\Models\Hall;
use App\Repositories\Interfaces\HallRepositoryInterface;
use App\Repositories\Interfaces\TheatreRepositoryInterface;
use App\Repositories\SeatRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class HallService
{
    public function __construct(
        private readonly TheatreRepositoryInterface $theatreRepository,
        private readonly HallRepositoryInterface $hallRepository,
        private readonly SeatRepository $seatRepository,
    )
    {
    }

    /**
     * Retrieve data needed for creating a new hall within the specified theatre.
     *
     * @param int $theatreId
     * @return array
     */
    public function getDataForCreate(int $theatreId): array
    {
        $theatre = $this->theatreRepository->getTheatreByIdOrFail(theatreId: $theatreId, relations: ['seatTypes']);
        $seatTypes = $theatre->seatTypes;
        $numberRow = 0;

        return compact('seatTypes', 'numberRow');
    }

    /**
     * Create a new hall along with seats and associated media files in a transactional manner.
     *
     * @param CreateHallDTO $dto
     * @return Hall
     * @throws \Throwable
     */
    public function createHall(CreateHallDTO $dto): Hall
    {
        $theatre = $this->theatreRepository->getTheatreByIdOrFail(theatreId: $dto->getTheatreId());

        try {
            DB::beginTransaction();

            $hall = $this->hallRepository->createHall(theatre: $theatre, dto: $dto);

            if ($dto->getHallImages() !== null) {
                $hall->saveMultipleFiles(
                    mediaFiles: $dto->getHallImages(),
                    collectionName: 'halls'
                );
            }

            foreach ($dto->getRows() as $rowNumber => $row) {
                foreach ($row as $place) {
                    $seatNumber = $place['seatNumber'];
                    $seatTypeId = $place['seatsTypeId'];

                    $this->seatRepository->createSeat(
                        hall: $hall,
                        seatsTypeId: $seatTypeId,
                        rowNumber: $rowNumber,
                        seatNumber: $seatNumber
                    );
                }
            }

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();

            Log::error("Failed to create hall: {$exception->getMessage()}");

            throw $exception;
        }

        return $hall;
    }

    /**
     * Delete a hall based on the provided DTO.
     *
     * @param DeleteHallDTO $dto
     * @return void
     */
    public function deleteHall(DeleteHallDTO $dto): void
    {
        $hall = $this->hallRepository->getHallByIdOrFail($dto->getHallId());
        $hall->delete();
    }

    /**
     * Receives data for editing the hall.
     *
     * @param EditHallDTO $dto
     * @return array
     */
    public function getDataHall(EditHallDTO $dto): array
    {
        $hall = $this->hallRepository->getHallByIdOrFail($dto->getHallId(), ['seats.seatType']);
        $seats = $hall->seats;
        $dataSeats = [];

        foreach ($seats as $seat) {
            $dataSeats[$seat->row][$seat->id] = [$seat->number => $seat->seatType];
        }

        $theatre = $this->theatreRepository->getTheatreByIdOrFail($dto->getTheatreId(), ['seatTypes']);
        $seatsTypes = $theatre->seatTypes;

        return compact('dataSeats', 'seatsTypes', 'hall');
    }

    /**
     * @param UpdateHallDTO $dto
     * @return Hall
     * @throws \Throwable
     */
    public function updateHall(UpdateHallDTO $dto): Hall
    {
        $hall = $this->hallRepository->getHallByIdOrFail($dto->getHallId());

        try {
            DB::beginTransaction();

            if ($dto->getHallImages() !== null) {
                $hall->deleteMedia('halls');
                $hall->saveMultipleFiles(
                    mediaFiles: $dto->getHallImages(),
                    collectionName: 'halls'
                );
            }

            $hall->seats()->delete();

            $seats = [];
            foreach ($dto->getRows() as $rowNumber => $row) {
                foreach ($row as $place) {
                    $seats[] = [
                        'seat_type_id' => $place['seatsTypeId'],
                        'row' => $rowNumber,
                        'number' => $place['seatNumber'],
                        'position_x' => rand(0, 100),
                        'position_y' => rand(0, 100),
                    ];
                }
            }

            $hall->seats()->createMany($seats);

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();

            Log::error("Failed to create hall: {$exception->getMessage()}");

            throw $exception;
        }

        return $hall;
    }
}
