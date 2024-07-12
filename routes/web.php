<?php

use Illuminate\Support\Facades\Route;
use Auth0\Laravel\Facade\Auth0;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/private', function () {
    dump(auth()->user());
    return response('Welcome! You are logged in.');
})->middleware('auth');

Route::get('/scope', function () {
    // In the Settings tab of the API, it should have the following RBAC Settings Enabled
    // Enable RBAC
    // Add Permissions in the Access Token
    // In the Permissions Tab
    // Add read:messages in the lit of permissions
    // Add the API permission to the user either directly or via role
    return response('You have the `read:messages` permissions, and can therefore access this resource.');
})->middleware('auth')->can('read:messages');


Route::get('/', function () {
    if (!auth()->check()) {
        return response('You are not logged in.');
    }

    $user = auth()->user();
    $name = $user->name ?? 'User';
    $email = $user->email ?? '';

    return response("Hello {$name}! Your email address is {$email}.");
});

Route::get('/colors', function () {
    // Go to the Auth0 system API
    // In the Machine to Machine Applications tab, authorize the app
    // Add the folloiwng permissions
    // read:users
    // update:users
    $endpoint = Auth0::management()->users();

    $colors = ['red', 'blue', 'green', 'black', 'white', 'yellow', 'purple', 'orange', 'pink', 'brown'];

    $endpoint->update(
        id: auth()->id(),
        body: [
            'user_metadata' => [
                'color' => $colors[random_int(0, count($colors) - 1)]
            ]
        ]
    );

    $metadata = $endpoint->get(auth()->id());
    $metadata = Auth0::json($metadata);

    $color = $metadata['user_metadata']['color'] ?? 'unknown';
    $name = auth()->user()->name;

    return response("Hello {$name}! Your favorite color is {$color}.");
})->middleware('auth');
