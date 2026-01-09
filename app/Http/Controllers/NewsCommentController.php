<?php

namespace App\Http\Controllers;

use App\Models\NewsItem;
use App\Models\NewsComment;
use Illuminate\Http\Request;

class NewsCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Store a new comment for a news item.
     */
    public function store(Request $request, NewsItem $newsItem)
    {
        $data = $request->validate([
            'content' => 'required|string|min:2|max:2000',
        ]);

        $comment = new NewsComment();
        $comment->news_item_id = $newsItem->id;
        $comment->user_id = $request->user()->id;
        $comment->content = $data['content'];
        $comment->save();

        return redirect()->route('news.show', $newsItem)->with('success', 'Reactie geplaatst.');
    }
}
