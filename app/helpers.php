<?php

function user(): \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable|null
{
    return auth()->user();
}

function translations($locale)
{
    $path = resource_path("lang/$locale.json");
    if (!file_exists($path)) {
        return [];
    }
    return json_decode(file_get_contents($path), true);
}

function flash($message, $error = false)
{
    return back()->with('flash', [
        'bannerStyle' => $error ? 'danger' : 'success',
        'banner' => $message,
    ]);
}

function flashRedirect($name, $message, $error = false)
{
    return redirect($name)->with('flash', [
        'bannerStyle' => $error ? 'danger' : 'success',
        'banner' => $message,
    ]);
}
