<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Zorg dat deze bovenin staat!
use Illuminate\Support\Facades\Storage;

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

    /**
     * Show the form for editing the specified resource (admin only).
     */
    public function edit(NewsItem $news)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403);
        }

        // pass the model to the view under the expected variable name
        return view('admin.news.edit', ['newsItem' => $news]);
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

    /**
     * Update the specified news item (admin only).
     */
    public function update(Request $request, NewsItem $news)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'published_at' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Afbeelding vervangen indien aanwezig
        if ($request->hasFile('image')) {
            // Verwijder oude afbeelding indien aanwezig
            if ($news->image) {
                Storage::disk('public')->delete($news->image);
            }

            $validated['image'] = $request->file('image')->store('news', 'public');
        }

        $news->update($validated);

        return redirect()->route('news.show', $news)->with('success', 'Bericht bijgewerkt.');
    }

    /**
     * Remove the specified news item from storage (admin only).
     */
    public function destroy(NewsItem $news)
    {
        if (!Auth::check() || !Auth::user()->is_admin) {
            abort(403);
        }

        // Verwijder gekoppelde afbeelding
        if ($news->image) {
            Storage::disk('public')->delete($news->image);
        }

        $news->delete();

        return redirect()->route('news.index')->with('success', 'Bericht verwijderd.');
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
