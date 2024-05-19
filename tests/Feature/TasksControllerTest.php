<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Task;
use App\User;

class TasksControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = factory(User::class)->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_creates_a_task()
    {
        $data = [
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph,
            'observation' => $this->faker->sentence,
            'status' => 'pending'
        ];

        $response = $this->postJson('/tasks', $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', [
            'title' => $data['title'],
            'body' => $data['body'],
            'observation' => $data['observation'],
            'status' => $data['status'],
            'user_id' => $this->user->id
        ]);
    }

    /** @test */
    public function it_fetches_tasks()
    {
        factory(Task::class, 3)->create(['user_id' => $this->user->id]);

        $response = $this->getJson('/tasks');

        $response->assertStatus(200);
        $response->assertJsonCount(3, 'tasks');
    }

    /** @test */
    public function it_updates_a_task()
    {
        $task = factory(Task::class)->create(['user_id' => $this->user->id]);
        $data = [
            'title' => 'Updated Title',
            'body' => 'Updated body content',
            'observation' => 'Updated observation',
            'status' => 'completed'
        ];

        $response = $this->putJson("/tasks/{$task->id}", $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'title' => $data['title'],
            'body' => $data['body'],
            'observation' => $data['observation'],
            'status' => $data['status']
        ]);
    }

    /** @test */
    public function it_deletes_a_task()
    {
        $task = factory(Task::class)->create(['user_id' => $this->user->id]);

        $response = $this->deleteJson("/tasks/{$task->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
