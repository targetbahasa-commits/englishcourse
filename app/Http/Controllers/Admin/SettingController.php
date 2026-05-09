<?php

namespace App\Http\Controllers\Admin;

use App\Application\Setting\ManageSettings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct(
        private readonly ManageSettings $useCase
    ) {}

    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = $this->useCase->getAll();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings in bulk.
     */
    public function update(Request $request)
    {
        $data = $request->except(['_token', '_method']);

        $this->useCase->bulkUpdate($data);

        return back()->with('success', 'Settings updated successfully.');
    }
}
