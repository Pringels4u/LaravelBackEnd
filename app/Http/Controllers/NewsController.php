<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;
use Illuminate\Http\Request;

class NewsController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            // Check of de route die wordt opgevraagd begint met 'admin.'
            if (str_contains($request->route()->getName(), 'admin.')) {
                if (!auth()->check() || !auth()->user()->is_admin) {
                    abort(403, 'Toegang geweigerd: Je bent geen admin.');
                }
            }
            return $next($request);
        });
    }

    /**
     * De publieke overzichtspagina
     */
    public function index()
    {
        $newsItems = NewsItem::orderBy('published_at', 'desc')->get();
        return view('news.index', compact('newsItems'));
    }


    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'published_at' => 'required|date',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('news', 'public');
            $validated['image'] = $path;
        }

        NewsItem::create($validated);

        return redirect()->route('news.index')->with('status', 'Bericht succesvol geplaatst!');
    }

    /**
     * De publieke detailpagina
     */
    public function show(NewsItem $newsItem)
    {
        return view('news.show', compact('newsItem'));
    }
}
