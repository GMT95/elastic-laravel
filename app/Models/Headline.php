<?php

namespace App\Models;

use App\Articles\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class Headline extends Model
{
    use HasFactory, Searchable;

    public static function getDistinctCategories(): Collection
    {
        if(Cache::has('distinct_category')) {
            return Cache::get('distinct_category');
        }

        $distinctCategory = self::query()
                            ->select('category')
                            ->distinct()
                            ->get()
                            ->pluck('category');

        Cache::forever('distinct_category', $distinctCategory);
        
        return $distinctCategory;
    }
}
