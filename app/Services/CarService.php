<?php

namespace App\Services;

use App\DTO\Request\CreateCarDTO;
use App\DTO\Request\PaginationDTO;
use App\Models\Car;
use App\Repositories\Interfaces\CarRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CarService
{
    private CarRepositoryInterface $repository;

    public function __construct(CarRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createCar(CreateCarDTO $request): Car
    {
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'photo_url' => $request->photo_url,
            'contacts' => $request->contacts,
            'options' => $request->options,
        ];

        return $this->repository->save($data);
    }

    public function getCar(int $id): ?Car
    {
        return $this->repository->findById($id);
    }

    public function getCars(PaginationDTO $pagination): LengthAwarePaginator
    {
        $query = $this->repository->getQuery();

        if ($pagination->sort) {
            $direction = str_starts_with($pagination->sort, '-') ? 'desc' : 'asc';
            $field = ltrim($pagination->sort, '-');

            $query->orderBy($field, $direction);
        }

        return $query->paginate(
            $pagination->pageSize,
            ['*'],
            'page',
            $pagination->page
        );
    }
}
