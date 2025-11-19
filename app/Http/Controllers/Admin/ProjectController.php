<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        // Include trashed projects if requested
        $query = $request->boolean('show_deleted') ?
            Project::withTrashed()->with(['category', 'media']) :
            Project::with(['category', 'media']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title_ar', 'like', "%{$search}%")
                  ->orWhere('title_en', 'like', "%{$search}%")
                  ->orWhere('description_ar', 'like', "%{$search}%")
                  ->orWhere('description_en', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Featured filter
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'true');
        }

        // Urgent filter
        if ($request->filled('urgent')) {
            $query->where('is_urgent', $request->urgent === 'true');
        }

        // Sorting
        $sortBy = $request->get('sort', 'created_at');
        $sortOrder = $request->get('order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $projects = $query->paginate(15);
        $categories = Category::where('is_active', true)->get();

        return view('admin.projects.index', compact('projects', 'categories'));
    }

    public function show($id)
    {
        $project = Project::withTrashed()->with(['category', 'donations.user', 'beneficiaries'])->findOrFail($id);
        
        // Load media explicitly
        $projectImages = $project->getMedia('images');
        
        $stats = [
            'total_donations' => $project->donations->count(),
            'unique_donors' => $project->donations->unique('user_id')->count(),
            'average_donation' => $project->donations->avg('amount'),
            'completion_percentage' => $project->progress_percentage,
            'days_left' => $project->days_left,
        ];

        return view('admin.projects.show', compact('project', 'stats', 'projectImages'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:projects',
            'target_amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,paused,completed,closed',
            'location_country' => 'nullable|string|max:255',
            'location_region' => 'nullable|string|max:255',
            'location_city' => 'nullable|string|max:255',
            'expected_beneficiaries_count' => 'required|integer|min:0',
            'expected_impact_ar' => 'nullable|string',
            'expected_impact_en' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_featured' => 'boolean',
            'is_urgent' => 'boolean',
            'display_order' => 'integer|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title_en']);

            // Ensure uniqueness
            $originalSlug = $validated['slug'];
            $counter = 1;
            while (Project::where('slug', $validated['slug'])->exists()) {
                $validated['slug'] = $originalSlug . '-' . $counter;
                $counter++;
            }
        }

        $project = Project::create($validated);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $project->addMedia($image)->toMediaCollection('images');
            }
        }

        return redirect()->route('admin.projects.show', $project->id)
            ->with('success', 'Project created successfully!');
    }

    public function edit($id)
    {
        $project = Project::withTrashed()->findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $project = Project::withTrashed()->findOrFail($id);

        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'required|string',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('projects')->ignore($project->id)],
            'target_amount' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:active,paused,completed,closed',
            'location_country' => 'nullable|string|max:255',
            'location_region' => 'nullable|string|max:255',
            'location_city' => 'nullable|string|max:255',
            'expected_beneficiaries_count' => 'required|integer|min:0',
            'actual_beneficiaries_count' => 'integer|min:0',
            'expected_impact_ar' => 'nullable|string',
            'expected_impact_en' => 'nullable|string',
            'achieved_impact_ar' => 'nullable|string',
            'achieved_impact_en' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_featured' => 'boolean',
            'is_urgent' => 'boolean',
            'display_order' => 'integer|min:0',
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $project->addMedia($image)->toMediaCollection('images');
            }
        }

        $project->update($validated);

        return redirect()->route('admin.projects.show', $project->id)
            ->with('success', 'Project updated successfully!');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully!');
    }

    public function toggleFeatured(Project $project)
    {
        $project->update(['is_featured' => !$project->is_featured]);

        $status = $project->is_featured ? 'featured' : 'unfeatured';
        return response()->json([
            'success' => true,
            'message' => "Project {$status} successfully!",
            'is_featured' => $project->is_featured,
        ]);
    }

    public function toggleUrgent(Project $project)
    {
        $project->update(['is_urgent' => !$project->is_urgent]);

        $status = $project->is_urgent ? 'marked as urgent' : 'unmarked as urgent';
        return response()->json([
            'success' => true,
            'message' => "Project {$status} successfully!",
            'is_urgent' => $project->is_urgent,
        ]);
    }

    public function uploadImages(Request $request, Project $project)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $uploadedCount = 0;
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $project->addMedia($image)->toMediaCollection('images');
                $uploadedCount++;
            }
        }

        return response()->json([
            'success' => true,
            'message' => "{$uploadedCount} images uploaded successfully!",
        ]);
    }

    public function deleteMedia(Project $project, $mediaId)
    {
        $media = $project->getMedia('images')->find($mediaId);

        if ($media) {
            $media->delete();
            return response()->json([
                'success' => true,
                'message' => 'Image deleted successfully!',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Image not found!',
        ], 404);
    }

    public function restore($id)
    {
        $project = Project::withTrashed()->findOrFail($id);
        $project->restore();

        return response()->json([
            'success' => true,
            'message' => 'Project restored successfully!',
        ]);
    }

    public function forceDelete($id)
    {
        $project = Project::withTrashed()->findOrFail($id);

        // Delete all associated media files
        $project->clearMediaCollection('images');

        // Force delete the project
        $project->forceDelete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project permanently deleted!');
    }
}
