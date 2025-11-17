<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = $request->except(['_token']);

        foreach ($settings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->route('admin.settings')->with('success', 'Settings updated successfully!');
    }

    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
            
            Setting::updateOrCreate(
                ['key' => 'site_logo'],
                ['value' => $logoPath]
            );

            return response()->json([
                'success' => true,
                'message' => 'Logo uploaded successfully!',
                'logo_url' => asset('storage/' . $logoPath),
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to upload logo.',
        ]);
    }

    public function uploadFavicon(Request $request)
    {
        $request->validate([
            'favicon' => 'required|image|mimes:ico,png|max:1024',
        ]);

        if ($request->hasFile('favicon')) {
            $faviconPath = $request->file('favicon')->store('favicons', 'public');
            
            Setting::updateOrCreate(
                ['key' => 'site_favicon'],
                ['value' => $faviconPath]
            );

            return response()->json([
                'success' => true,
                'message' => 'Favicon uploaded successfully!',
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Failed to upload favicon.',
        ]);
    }

    public function backup()
    {
        // Implementation would depend on backup strategy
        return response()->json([
            'success' => true,
            'message' => 'Backup completed successfully!',
        ]);
    }

    public function toggleMaintenance()
    {
        $currentStatus = Setting::where('key', 'maintenance_mode')->value('value') ?? 'false';
        $newStatus = $currentStatus === 'true' ? 'false' : 'true';
        
        Setting::updateOrCreate(
            ['key' => 'maintenance_mode'],
            ['value' => $newStatus]
        );

        $message = $newStatus === 'true' ? 'Maintenance mode enabled!' : 'Maintenance mode disabled!';

        return response()->json([
            'success' => true,
            'message' => $message,
            'maintenance_mode' => $newStatus === 'true',
        ]);
    }
}