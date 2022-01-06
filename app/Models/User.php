<?php

namespace App\Models;

use App\Helpers\Traits\CacheableTrait;
use App\Helpers\Traits\SearchableScope;
use App\Helpers\Traits\SearchableTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Kra8\Snowflake\HasSnowflakePrimary;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable /*implements MustVerifyEmail*/
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
//    use \Illuminate\Auth\MustVerifyEmail;
    use HasFactory;
    use HasSnowflakePrimary;
    use SearchableTrait;
    use SearchableScope;
    use HasRoles;
    use HasPermissions;
    use CacheableTrait;

    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password', 'firstname', 'lastname', 'country', 'language', 'postcode', 'street', 'number',
        'profile_photo_path', 'sex', 'city', 'state',
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
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function permissionsToArray(): \Illuminate\Database\Eloquent\Collection|array|\Illuminate\Support\Collection
    {
        return ($this->hasRole(Role::SUPER_ADMIN) ? Permission::all() : $this->getAllPermissions())->mapWithKeys(fn($permission) => [$permission['name'] => true]);
    }

}
