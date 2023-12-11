<?php

namespace App\Services;

use App\DTO\Halls\CreateHallDTO;
use App\DTO\Halls\DeleteHallDTO;
use App\DTO\Halls\EditHallDTO;
use App\DTO\Halls\RenderSeatsDTO;
use App\DTO\Halls\UpdateHallDTO;
use App\Models\Hall;
use App\Repositories\Interfaces\HallRepositoryInterface;
use App\Repositories\Interfaces\TheatreRepositoryInterface;
use App\Repositories\SeatRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class HallService
{
    /**
     * Retrieve data needed for creating a new hall within the specified theatre.
     *
     * @param int $theatreId
     * @return array
     */
    public function getDataForCreate(int $theatreId): array
    {
        $theatreRepository = app(TheatreRepositoryInterface::class);

        $theatre = $theatreRepository->getTheatreByIdOrFail(theatreId: $theatreId, relations: ['seatTypes']);
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
        $theatreRepository = app(TheatreRepositoryInterface::class);
        $hallRepository = app(HallRepositoryInterface::class);
        $seatRepository = app(SeatRepository::class);

        try {
            DB::beginTransaction();
            $theatre = $theatreRepository->getTheatreByIdOrFail(theatreId: $dto->getTheatresId());
            $hall = $hallRepository->createHall(theatre: $theatre, dto: $dto);

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

                    $seatRepository->createSeat(
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
        $hallRepository = app(HallRepositoryInterface::class);

        $hall = $hallRepository->getHallByIdOrFail($dto->getHallId());
        $hall->deleteMedia('halls');
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
        $hallRepository = app(HallRepositoryInterface::class);
        $theatreRepository = app(TheatreRepositoryInterface::class);

        $hall = $hallRepository->getHallByIdOrFail($dto->getHallId(), ['seats.seatType']);
        $seats = $hall->seats;
        $dataSeats = [];

        foreach ($seats as $seat) {
            $dataSeats[$seat->row][$seat->id] = [$seat->number => $seat->seatType->id];
        }

        $theatre = $theatreRepository->getTheatreByIdOrFail($dto->getTheatresId(), ['seatTypes']);
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
        $hallRepository = app(HallRepositoryInterface::class);
        $seatRepository = app(SeatRepository::class);

        try {
            DB::beginTransaction();
            $hall = $hallRepository->getHallByIdOrFail($dto->getHallId());

            if ($dto->getHallImages() !== null) {
                $hall->saveMultipleFiles(
                    mediaFiles: $dto->getHallImages(),
                    collectionName: 'halls'
                );
            }

            $hall->seats()->delete();

            foreach ($dto->getRows() as $rowNumber => $row) {
                foreach ($row as $place) {
                    $seatNumber = $place['seatNumber'];
                    $seatTypeId = $place['seatsTypeId'];

                    $seatRepository->createSeat(
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
     * Render the HTML template for seats based on the provided data.
     *
     * @param RenderSeatsDTO $dto
     * @return string
     */
    public function renderTemplate(RenderSeatsDTO $dto): string
    {
        return view($dto->getHtmlContent(), [
            'seatTypeId' => $dto->getSeatsTypeId(),
            'countSeats' => $dto->getCountSeats(),
            'numberRow' => $dto->getNumberRow(),
        ])->render();
    }
}
