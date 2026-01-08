<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Zorg dat deze bovenin staat!

class NewsController extends Controller
{
    public function index()
    {
        $newsItems = NewsItem::orderBy('published_at', 'desc')->get();

        $favoriteIds = [];
        if (auth()->check()) {
            $favoriteIds = auth()->user()->favorites()->pluck('news_item_id')->toArray();
        }

        return view('news.index', compact('newsItems', 'favoriteIds'));
    }

    public function create()
    {
        // Handmatige admin check
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403);
        }

        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        // Handmatige admin check
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'published_at' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        NewsItem::create($validated);

        return redirect()->route('news.index')->with('success', 'Bericht geplaatst!');
    }

    public function show(NewsItem $newsItem)
    {
        $isFavorited = false;
        if (auth()->check()) {
            $isFavorited = auth()->user()->favorites()->where('news_item_id', $newsItem->id)->exists();
        }

        return view('news.show', compact('newsItem', 'isFavorited'));
    }
}
