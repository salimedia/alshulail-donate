<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured active projects with media
        $projects = Project::with('category')
            ->where('status', 'active')
            ->where('is_featured', true)
            ->orderBy('display_order')
            ->limit(6)
            ->get();

        // Load media for each project
        $projects->each(function($project) {
            $project->projectImages = $project->getMedia('images');
        });

        return view('home', compact('projects'));
    }
}
