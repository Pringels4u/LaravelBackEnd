<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AdminUsersTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_admin_toggle_route()
    {
        $normal = User::factory()->create(['is_admin' => false]);
        $target = User::factory()->create(['is_admin' => false]);

        $this->actingAs($normal)
            ->post(route('admin.users.toggleAdmin', $target))
            ->assertRedirect('/');

        $this->assertDatabaseHas('users', [
            'id' => $target->id,
            'is_admin' => 0,
        ]);
    }

    public function test_admin_can_toggle_other_user_admin_flag()
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $target = User::factory()->create(['is_admin' => false]);

        $this->actingAs($admin)
            ->post(route('admin.users.toggleAdmin', $target))
            ->assertRedirect();

        $this->assertDatabaseHas('users', [
            'id' => $target->id,
            'is_admin' => 1,
        ]);
    }
}
