<?php


namespace App\Ship\Interfaces\Repositories;

interface BaseRepositoryInterface
{
    public function fill($model, array $modelData);

    public function isDirty($model);

    public function persist($model);
}