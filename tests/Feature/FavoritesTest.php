<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\NewsItem;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_toggle_favorite_on_news_item()
    {
        $user = User::factory()->create();

        $news = NewsItem::create([
            'title' => 'Test News',
            'content' => 'Content',
            'image' => null,
        ]);

        $this->actingAs($user)
            ->post(route('news.favorite.toggle', $news))
            ->assertRedirect();

        $this->assertDatabaseHas('news_user', [
            'user_id' => $user->id,
            'news_item_id' => $news->id,
        ]);

        // Toggle again to remove
        $this->actingAs($user)
            ->post(route('news.favorite.toggle', $news))
            ->assertRedirect();

        $this->assertDatabaseMissing('news_user', [
            'user_id' => $user->id,
            'news_item_id' => $news->id,
        ]);
    }
}
