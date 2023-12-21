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
use App\Repositories\SeatTypeRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class HallService
{
    public function __construct(
        private readonly TheatreRepositoryInterface $theatreRepository,
        private readonly HallRepositoryInterface    $hallRepository,
        private readonly SeatRepository             $seatRepository,
        private readonly SeatTypeRepository         $seatTypeRepository,
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
        $seatTypes = $this->seatTypeRepository->getSeatTypesByHallId($theatreId);

        return compact('seatTypes');
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
                    $posX = $place['posX'];
                    $posY = $place['posY'];

                    $this->seatRepository->createSeat(
                        hall: $hall,
                        seatsTypeId: $seatTypeId,
                        rowNumber: $rowNumber,
                        seatNumber: $seatNumber,
                        positionX: $posX,
                        positionY: $posY
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
     * @param int $hallId
     * @return Hall
     */
    public function getHall(int $hallId): Hall
    {
        return $this->hallRepository->getHallByIdOrFail($hallId);
    }

    /**
     * Retrieves the contents of the room for editing.
     * Retrieves information about seats in the hall, including seat numbers, seat types, coordinates and other data.
     *
     * @param EditHallDTO $dto
     * @return array
     */
    public function getHallContent(EditHallDTO $dto): array
    {
        $hall = $this->hallRepository->getHallByIdOrFail($dto->getHallId(), ['seats.seatType']);
        $seats = $hall->seats;
        $dataSeats = [];

        foreach ($seats as $seat) {
            $dataSeats[$seat->row][$seat->id] = [
                'number' => $seat->number,
                'seatsTypeName' => $seat->seatType->name,
                'seatsTypeId' => $seat->seatType->id,
                'posX' => $seat->position_x,
                'posY' => $seat->position_y,
            ];
        }

        return compact('dataSeats');
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

            $existingSeatIds = [];

            foreach ($dto->getRows() as $rowNumber => $row) {
                foreach ($row as $place) {
                    if (isset($place['seatId'])) {
                        $existingSeatIds[] = $place['seatId'];

                        $this->seatRepository->updateSeat(
                            seatId: $place['seatId'],
                            seatsTypeId: $place['seatsTypeId'],
                            hallId: $hall->id,
                            rowNumber: $rowNumber,
                            seatNumber: $place['seatNumber'],
                            positionX: $place['posX'],
                            positionY: $place['posY'],
                        );
                    } else {
                        $newSeat = $this->seatRepository->createSeat(
                            hall: $hall,
                            seatsTypeId: $place['seatsTypeId'],
                            rowNumber: $rowNumber,
                            seatNumber: $place['seatNumber'],
                            positionX: $place['posX'],
                            positionY: $place['posY'],
                        );
                        $existingSeatIds[] = $newSeat->id;
                    }
                }
            }

            $existingSeatIds = array_map('intval', $existingSeatIds);
            $this->seatRepository->deleteSeatsNotInList(
                hallId: $hall->id,
                seatIdsList: $existingSeatIds
            );

            DB::commit();
        } catch (\Throwable $exception) {
            DB::rollBack();

            Log::error("Failed to create hall: {$exception->getMessage()}");

            throw $exception;
        }

        return $hall;
    }
}
