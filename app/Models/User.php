<?php

namespace App\Models;

use App\Enums\StatusEnum;
use App\Helpers\Traits\CacheableTrait;
use App\Helpers\Traits\SearchableScope;
use App\Helpers\Traits\SearchableTrait;
use App\Models\Traits\User\PermissionTrait;
use App\Models\Traits\User\IsTeamMemberTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kra8\Snowflake\HasShortflakePrimary;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable /*implements MustVerifyEmail*/
{

    use HasShortflakePrimary;
    use HasApiTokens;
    use HasFactory;
    use HasPermissions;
    use HasProfilePhoto;
    use HasRoles;
    use HasTeams;
    use TwoFactorAuthenticatable;
    use Notifiable;
//    use \Illuminate\Auth\MustVerifyEmail;
    use SearchableTrait;
    use SearchableScope;
    use CacheableTrait;
    use PermissionTrait;
    use IsTeamMemberTrait;

    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password', 'firstname', 'lastname', 'country', 'language', 'postcode', 'street', 'number',
        'profile_photo_path', 'sex', 'city', 'state', 'permissions', 'roles',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'state' => StatusEnum::class,
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

}
