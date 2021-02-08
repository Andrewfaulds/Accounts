<?php

namespace App\Http\Controllers;

use App\Events\UserCreatedEvent;
use App\Events\UserDeletedEvent;
use App\Events\UserUpdatedEvent;
use App\Http\Requests\Users\Destroy;
use App\Http\Requests\Users\Index;
use App\Http\Requests\Users\Show;
use App\Http\Requests\Users\Store;
use App\Http\Requests\Users\Update;
use App\Models\User;
use App\Http\Resources\UserCollection as ResourceCollection;
use App\Http\Resources\UserResource as Resource;


class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\Users\Index $request
     *
     * @return ResourceCollection
     */
    public function index(Index $request)
    : ResourceCollection
    {
        $users = User::paginate();

        return (new ResourceCollection($users));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Users\Store $request
     *
     * @return Resource
     */
    public function store(Store $request)
    : Resource
    {
        $validated = $request->validated();

        $user = new User([
            'name'  => $validated['name'],
            'email' => $validated['email'],
        ]);

        $user->save();

        UserCreatedEvent::dispatch($user);

        return (new Resource($user));
    }

    /**
     * Show an existing resource in storage.
     *
     * @param \App\Http\Requests\Users\Show $request
     * @param \App\Models\User              $user
     *
     * @return Resource
     */
    public function show(Show $request, User $user)
    : Resource
    {
        return (new Resource($user));
    }

    /**
     * Update an existing resource in storage.
     *
     * @param \App\Http\Requests\Users\Update $request
     * @param \App\Models\User                $user
     *
     * @return Resource
     */
    public function update(Update $request, User $user)
    : Resource
    {
        $validated = $request->validated();

        $user->update([
            'name'  => $validated['name'] ?? $user->name,
            'email' => $validated['email'] ?? $user->email,
        ]);

        UserUpdatedEvent::dispatch($user);

        return (new Resource($user));
    }

    /**
     * Delete an existing resource in storage.
     *
     * @param \App\Http\Requests\Users\Destroy $request
     * @param \App\Models\User                 $user
     *
     */
    public function destroy(Destroy $request, User $user)
    : \Illuminate\Http\Response
    {
        $userId = $user->id;

        $user->delete();

        UserDeletedEvent::dispatch($userId);

        return response()->noContent();
    }
}
