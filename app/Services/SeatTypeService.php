<?php

namespace App\Services;

use App\DTO\SeatTypes\CreateSeatTypeDTO;
use App\DTO\SeatTypes\DeleteSeatTypeDTO;
use App\DTO\SeatTypes\UpdateSeatTypeDTO;
use App\Models\SeatType;
use App\Repositories\Interfaces\SeatTypeRepositoryInterface;
use Illuminate\Support\Collection;

class SeatTypeService
{
    public function __construct(
        private readonly SeatTypeRepositoryInterface $seatTypeRepository
    )
    {
    }

    /**
     * Creates a theater seat type based on the passed DTO data.
     *
     * @param CreateSeatTypeDTO $dto
     * @return SeatType
     */
    public function createSeatTypeByTheatre(CreateSeatTypeDTO $dto): SeatType
    {
        return $this->seatTypeRepository->createSeatTypeForTheatre(dto: $dto);
    }

    /**
     * Deletes a seat type after checking whether seats of this type are associated with the hall.
     *
     * @param DeleteSeatTypeDTO $dto
     * @return void
     * @throws \Exception
     */
    public function deleteSeatTypeWithCheck(DeleteSeatTypeDTO $dto): void
    {
        if ($this->seatTypeRepository->hasSeatsOfType(seatTypeId: $dto->getSeatTypeId())) {
            throw new \Exception('невозможно удалить тип мест, который уже используется');
        }

        $this->seatTypeRepository->deleteSeatType(seatTypeId: $dto->getSeatTypeId());
    }

    /**
     *  Update the seat type based on the provided data transfer object (DTO).
     *
     * @param UpdateSeatTypeDTO $dto
     * @return SeatType
     * @throws \Throwable
     */
    public function updateSeatType(UpdateSeatTypeDTO $dto): SeatType
    {
        $seatType = $this->seatTypeRepository->getSeatTypeByIdOrFail(seatTypeId: $dto->getSeatTypeId());

        return $this->seatTypeRepository->updateInfoBySeatType(seatType: $seatType, dto: $dto);
    }

    /**
     * @param int $theatreId
     * @return Collection
     */
    public function getSeatsTypeToHall(int $theatreId): Collection
    {
        return $this->seatTypeRepository->getSeatTypesByHallId($theatreId);
    }
}
