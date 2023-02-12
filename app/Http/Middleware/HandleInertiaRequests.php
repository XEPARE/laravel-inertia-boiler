<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Laravel\Jetstream\Jetstream;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        $payload = parent::share($request);

        /** Adding team-featured stuff */
        if (Jetstream::hasTeamFeatures()) {
            $payload = array_merge($payload, [
                'user.current_team_role' => function () use ($request) {
                    if (!$request->user() || $request->user()->currentTeam === null) {
                        return [];
                    }
                    return $request->user()->getTeamRole();
                },
            ]);
        }


        return $payload;
    }
}
