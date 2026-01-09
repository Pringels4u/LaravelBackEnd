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

    /**
     * Show the form to create a new FAQ item (admin only)
     */
    public function create()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $categories = Category::orderBy('name')->get();

        return view('admin.faq.create', compact('categories'));
    }

    /**
     * Store a new FAQ item (admin only)
     */
    public function store(Request $request)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $data = $request->validate([
            'category_id' => 'nullable|exists:categories,id|required_without:new_category',
            'new_category' => 'nullable|string|required_without:category_id|max:255',
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        // Zorg dat er een category_id is: maak een nieuwe categorie aan indien nodig
        if (empty($data['category_id']) && !empty($data['new_category'])) {
            $category = Category::create(['name' => $data['new_category']]);
            $categoryId = $category->id;
        } else {
            $categoryId = $data['category_id'];
        }

        Category::findOrFail($categoryId)->faqItems()->create([
            'question' => $data['question'],
            'answer' => $data['answer'],
        ]);

        return redirect()->route('faq.index')->with('success', 'FAQ toegevoegd.');
    }

    /**
     * Show the form for editing an existing FAQ item (admin only)
     */
    public function edit(\App\Models\FaqItem $faq)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $categories = Category::orderBy('name')->get();

        return view('admin.faq.edit', ['faqItem' => $faq, 'categories' => $categories]);
    }

    /**
     * Update an existing FAQ item (admin only)
     */
    public function update(Request $request, \App\Models\FaqItem $faq)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $data = $request->validate([
            'category_id' => 'nullable|exists:categories,id|required_without:new_category',
            'new_category' => 'nullable|string|required_without:category_id|max:255',
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        if (empty($data['category_id']) && !empty($data['new_category'])) {
            $category = Category::create(['name' => $data['new_category']]);
            $categoryId = $category->id;
        } else {
            $categoryId = $data['category_id'];
        }

        $faq->update([
            'category_id' => $categoryId,
            'question' => $data['question'],
            'answer' => $data['answer'],
        ]);

        return redirect()->route('faq.index')->with('success', 'FAQ bijgewerkt.');
    }

    /**
     * Remove the specified FAQ item (admin only)
     */
    public function destroy(\App\Models\FaqItem $faq)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(403);
        }

        $faq->delete();

        return redirect()->route('faq.index')->with('success', 'FAQ verwijderd.');
    }
}
