<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->paginate(20);
        return view('admin.pages.index', compact('pages'));
    }

    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'content_ar' => 'required|string',
            'content_en' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:pages',
            'is_published' => 'boolean',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title_en']);
        }

        Page::create($validated);
        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully!');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'content_ar' => 'required|string',
            'content_en' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'is_published' => 'boolean',
        ]);

        $page->update($validated);
        return redirect()->route('admin.pages.show', $page)->with('success', 'Page updated successfully!');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page deleted successfully!');
    }

    public function togglePublished(Page $page)
    {
        $page->update(['is_published' => !$page->is_published]);
        
        $status = $page->is_published ? 'published' : 'unpublished';
        return response()->json([
            'success' => true,
            'message' => "Page {$status} successfully!",
            'is_published' => $page->is_published,
        ]);
    }
}