<?php


namespace App\Models;

use App\Helpers\Traits\SearchableScope;
use App\Helpers\Traits\SearchableTrait;
use Kra8\Snowflake\HasShortflakePrimary;

/**
 * @mixin IdeHelperModel
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    use HasShortflakePrimary, SearchableTrait, SearchableScope;

    protected $keyType = 'string';
    public $incrementing = false;

}
