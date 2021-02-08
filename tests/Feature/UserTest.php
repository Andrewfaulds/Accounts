<?php

namespace Tests\Feature;

use App\Events\UserCreatedEvent;
use App\Events\UserUpdatedEvent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * Test creates a user with correct data and triggers an event.
     *
     * @test
     *
     * @return void
     * @throws \Exception
     */
    public function creates_a_user_with_correct_data()
    {
        $attributes = [
            "name"  => "example name",
            "email" => "name@company.com",
        ];

        $this->expectsEvents(UserCreatedEvent::class);

        $response = $this->json('POST', '/api/users', $attributes);

        $response->assertStatus(201);

        $content = $response->json()['data'];

        $user = User::all()
                    ->find($content['id']);

        $this->assertNotNull($user);
        $this->assertEquals($attributes['name'], $user->name);
        $this->assertEquals($attributes['email'], $user->email);
    }

    /**
     * Test fails to create a user with incorrect data and does not trigger an event.
     *
     * @test
     *
     * @return void
     * @throws \Exception
     */
    public function fails_to_creates_a_user_with_incorrect_data()
    {
        $attributes = [
            "name"  => "example name",
            "email" => "name",
        ];

        $this->doesntExpectEvents(UserCreatedEvent::class);

        $response = $this->json('POST', '/api/users', $attributes);

        $response->assertStatus(422);
    }

    /**
     * Test updates an existing user with correct data and triggers an event.
     *
     * @test
     *
     * @return void
     * @throws \Exception
     */
    public function updates_an_existing_user_with_correct_data()
    {
        $initialUser = new User([
            "name"  => "initial name",
            "email" => "initial@email.com",
        ]);

        $initialUser->save();

        $attributes = [
            "name"  => "example name",
            "email" => "name@company.com",
        ];

        $this->expectsEvents(UserUpdatedEvent::class);

        $response = $this->json('PUT', '/api/users/' .$initialUser->id, $attributes);

        $response->assertStatus(200);

        $content = $response->json()['data'];

        $user = User::all()
                    ->find($content['id']);

        $this->assertNotNull($user);
        $this->assertEquals($attributes['name'], $user->name);
        $this->assertEquals($attributes['email'], $user->email);
        $this->assertNotEquals($initialUser->name, $user->name);
        $this->assertNotEquals($initialUser->email, $user->email);
    }

    /**
     * Test fails to update a user with incorrect data and does not trigger an event.
     *
     * @test
     *
     * @return void
     * @throws \Exception
     */
    public function fails_to_update_a_user_with_incorrect_data()
    {
        $initialUser = new User([
            "name"  => "initial name",
            "email" => "initial@email.com",
        ]);

        $initialUser->save();

        $attributes = [
            "name"  => "example name",
            "email" => "name",
        ];

        $this->doesntExpectEvents(UserUpdatedEvent::class);

        $response = $this->json('PUT', '/api/users/'.$initialUser->id , $attributes);

        $response->assertStatus(422);
    }
}
