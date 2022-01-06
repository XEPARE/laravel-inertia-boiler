<?php


namespace App\Policies;


use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

abstract class AbstractPolicy
{

    use HandlesAuthorization;

    public $key;

    public function viewAny(User $user)
    {
        return $user->can("$this->key.read");
    }

    public function view(User $user)
    {
        return $user->can("$this->key.show");
    }

    public function create(User $user)
    {
        return $user->can("$this->key.create");
    }

    public function update(User $user)
    {
        return $user->can("$this->key.update");
    }

    public function delete(User $user)
    {
        return $user->can("$this->key.delete");
    }

}
