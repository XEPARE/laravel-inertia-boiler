<?php

namespace App\Models\Traits\User;

trait IsTeamMemberTrait
{

    /**
     * Returns the current role of the user in the current team.
     *
     * @return \Laravel\Jetstream\OwnerRole|\Laravel\Jetstream\Role|null
     */
    public function getTeamRole(): \Laravel\Jetstream\Role|\Laravel\Jetstream\OwnerRole|null
    {
        return $this->teamRole($this->currentTeam);
    }

}