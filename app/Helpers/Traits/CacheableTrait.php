<?php


namespace App\Helpers\Traits;


use Illuminate\Support\Str;

trait CacheableTrait
{

    public function cacheKey($suffix = 'model', $foreignKey = 'id'): string
    {
        return sprintf('%s:%s:%s', Str::slug(class_basename($this)), $this->{$foreignKey}, $suffix);
    }

}
