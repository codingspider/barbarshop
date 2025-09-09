<?php

namespace App\Http\Controllers\Admin;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ApplicationSettingController extends Controller
{
    public function index(){
        return view('admin.setting');
    }

    public function update(Request $request)
    {
        // Validate inputs
        $request->validate([
            'site_name'    => 'required|string|max:255',
            'logo'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon'      => 'nullable|image|mimes:ico,png|max:1024',
        ]);

        try {
            $settings = Setting::firstOrNew([]);

            // Update text fields
            $settings->site_name   = $request->site_name;

            // Handle logo upload
            if ($request->hasFile('logo')) {
                if ($settings->logo) {
                    Storage::delete($settings->logo);
                }
                $settings->logo = uploadPublicImage($request->file('logo'), 'logo');
            }

            // Handle favicon upload
            if ($request->hasFile('favicon')) {
                if ($settings->favicon) {
                    Storage::delete($settings->favicon);
                }
                $settings->favicon = uploadPublicImage($request->file('favicon'), 'favicon');
            }

            $settings->save();

            // Update .env values if needed (example: SITE_NAME)
            if($request->site_name){
                $this->setEnvValue('APP_NAME', $request->site_name);
            }

            return redirect()->back()->with('success', 'Settings updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update settings: ' . $e->getMessage());
        }
    }

    /**
     * Update or add key in .env file
     */
    protected function setEnvValue($key, $value)
    {
        $envPath = base_path('.env');

        if (file_exists($envPath)) {
            $content = file_get_contents($envPath);

            // Wrap value in double quotes
            $value = '"' . str_replace('"', '\"', $value) . '"';

            if (strpos($content, $key) !== false) {
                // Replace existing key
                $content = preg_replace("/^{$key}=.*$/m", "{$key}={$value}", $content);
            } else {
                // Append new key
                $content .= "\n{$key}={$value}";
            }

            file_put_contents($envPath, $content);
        }
    }
}
