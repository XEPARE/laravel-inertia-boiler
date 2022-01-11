<?php


namespace App\Models;


use App\Helpers\Traits\SearchableScope;
use App\Helpers\Traits\SearchableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kra8\Snowflake\HasSnowflakePrimary;

/**
 * @mixin IdeHelperModel
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory, HasSnowflakePrimary, SearchableTrait, SearchableScope;

    protected $keyType = 'string';
    public $incrementing = false;

    public function getIdAttribute()
    {
        return (string) $this->id;
    }

}
