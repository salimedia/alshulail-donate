<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured active projects
        $projects = Project::with('category')
            ->where('status', 'active')
            ->where('is_featured', true)
            ->orderBy('display_order')
            ->limit(6)
            ->get();

        return view('home', compact('projects'));
    }
}
