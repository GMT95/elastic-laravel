<?php

namespace App\Articles;

use Illuminate\Pagination\LengthAwarePaginator;

interface SearchRepository
{
    public function search(array $searchParams): LengthAwarePaginator;
}
