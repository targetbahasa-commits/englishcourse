<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramDiscount;
use Illuminate\Http\Request;

class ProgramDiscountController extends Controller
{
    public function index(Program $program)
    {
        $discounts = $program->discounts()->latest()->get();
        return view('admin.programs.discounts', compact('program', 'discounts'));
    }

    public function store(Request $request, Program $program)
    {
        $data = $request->validate([
            'type'           => 'required|in:guest,new_user,student,referral,holiday,region',
            'label'          => 'required|string|max:255',
            'discount_type'  => 'required|in:percentage,fixed_idr',
            'discount_value' => 'required|integer|min:1',
            'is_active'      => 'nullable|boolean',
            // Conditional conditions
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'regions'        => 'nullable|string',
        ]);

        $conditions = null;
        if ($data['type'] === 'holiday' && !empty($data['start_date'])) {
            $conditions = [
                'start_date' => $data['start_date'],
                'end_date'   => $data['end_date'] ?? $data['start_date'],
            ];
        } elseif ($data['type'] === 'region' && !empty($data['regions'])) {
            $regions = array_map('trim', explode(',', $data['regions']));
            $conditions = ['regions' => array_filter($regions)];
        }

        $program->discounts()->create([
            'type'           => $data['type'],
            'label'          => $data['label'],
            'discount_type'  => $data['discount_type'],
            'discount_value' => $data['discount_value'],
            'conditions'     => $conditions,
            'is_active'      => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Diskon berhasil ditambahkan!');
    }

    public function update(Request $request, Program $program, ProgramDiscount $discount)
    {
        // Toggle active or full update
        if ($request->has('toggle_active')) {
            $discount->update(['is_active' => !$discount->is_active]);
            return back()->with('success', 'Status diskon diperbarui.');
        }

        $data = $request->validate([
            'label'          => 'required|string|max:255',
            'discount_type'  => 'required|in:percentage,fixed_idr',
            'discount_value' => 'required|integer|min:1',
            'is_active'      => 'nullable|boolean',
            'start_date'     => 'nullable|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'regions'        => 'nullable|string',
        ]);

        $conditions = $discount->conditions;
        if ($discount->type === 'holiday' && !empty($data['start_date'])) {
            $conditions = [
                'start_date' => $data['start_date'],
                'end_date'   => $data['end_date'] ?? $data['start_date'],
            ];
        } elseif ($discount->type === 'region' && !empty($data['regions'])) {
            $regions = array_map('trim', explode(',', $data['regions']));
            $conditions = ['regions' => array_filter($regions)];
        }

        $discount->update([
            'label'          => $data['label'],
            'discount_type'  => $data['discount_type'],
            'discount_value' => $data['discount_value'],
            'conditions'     => $conditions,
            'is_active'      => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'Diskon berhasil diperbarui!');
    }

    public function destroy(Program $program, ProgramDiscount $discount)
    {
        $discount->delete();
        return back()->with('success', 'Diskon berhasil dihapus.');
    }
}
