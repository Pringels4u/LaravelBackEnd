<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class AdminCreateNewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_news_item()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $data = [
            'title' => 'Nieuw kamp aankondiging',
            'content' => 'We organiseren dit jaar een super leuk weekendkamp!',
            'published_at' => now()->toDateString(),
        ];

        $this->actingAs($admin)
            ->post(route('admin.news.store'), $data)
            ->assertRedirect(route('news.index'));

        $this->assertDatabaseHas('news_items', [
            'title' => 'Nieuw kamp aankondiging',
            'content' => 'We organiseren dit jaar een super leuk weekendkamp!',
        ]);
    }
}
