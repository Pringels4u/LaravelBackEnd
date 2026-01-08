<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        // We halen alle categorieën op, inclusief de bijbehorende faqItems (Eager Loading)
        $categories = Category::with('faqItems')->get();

        // We sturen deze data naar de view
        return view('faq.index', compact('categories'));
    }
}
