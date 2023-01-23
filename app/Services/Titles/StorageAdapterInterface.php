<?php

namespace App\Services\Titles;

interface StorageAdapterInterface
{
    public function getTitles(): array;
}
