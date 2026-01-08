<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;
use Illuminate\Http\Request;

class NewsFavoriteController extends Controller
{
    /** Toggle favourite for the authenticated user. */
    public function toggle(Request $request, NewsItem $newsItem)
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if ($user->favorites()->where('news_item_id', $newsItem->id)->exists()) {
            $user->favorites()->detach($newsItem->id);
            $message = 'Verwijderd uit favorieten.';
        } else {
            $user->favorites()->attach($newsItem->id);
            $message = 'Toegevoegd aan favorieten.';
        }

        return back()->with('success', $message);
    }
}
