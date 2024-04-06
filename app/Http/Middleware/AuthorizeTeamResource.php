<?php

namespace App\Http\Middleware;

use App\Models\Model;
use Closure;
use Illuminate\Http\Request;

class AuthorizeTeamResource
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param string $model
     * @param string $relation
     * @param string $routeModelName
     * @param string $ability
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $model = Model::class, string $relation = 'services', string $routeModelName = 'service', string $ability = 'read')
    {
        $team = user()->currentTeam;

        /** Load relation if not loaded */
        if ($team->relationLoaded($relation))
            $team->load($relation);

        $routeModel = $request->route($routeModelName);
        if (!$team->{$relation}->contains('id', '=', $routeModel->id))
            abort(403);

        if (!user()->hasTeamPermission($team, $ability))
            abort(403);

        return $next($request);
    }
}
