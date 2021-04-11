<?php

namespace App\Ship\Interfaces\Actions;


use Illuminate\Support\Collection;

interface BaseActionInterface
{
    public function event();

    public function eventArguments() : array;

    public function models() : Collection;

    public function repositoryMap() : array;
}