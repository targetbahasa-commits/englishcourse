<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InternPermissionController extends Controller
{
    /**
     * Update the permissions for a specific intern.
     */
    public function update(Request $request, \App\Models\User $user)
    {
        if ($user->role !== 'intern') {
            abort(400, 'User is not an intern.');
        }

        $validated = $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'string'
        ]);

        $permissions = $validated['permissions'] ?? [];

        // Delete existing permissions
        $user->internPermissions()->delete();

        // Create new permissions
        $insertData = [];
        foreach ($permissions as $permission) {
            $insertData[] = [
                'user_id' => $user->id,
                'permission' => $permission,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($insertData)) {
            $user->internPermissions()->insert($insertData);
        }

        return redirect()->back()->with('success', 'Intern permissions updated successfully.');
    }
}
