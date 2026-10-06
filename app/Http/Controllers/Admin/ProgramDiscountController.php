<?php

namespace App\Http\Controllers\Admin;

use App\Application\ProgramDiscount\ManageProgramDiscounts;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProgramDiscountStoreRequest;
use App\Http\Requests\Admin\ProgramDiscountUpdateRequest;
use App\Models\Program;
use App\Models\ProgramDiscount;

class ProgramDiscountController extends Controller
{
    public function __construct(
        private readonly ManageProgramDiscounts $manageProgramDiscounts
    ) {}

    public function index(Program $program)
    {
        $discounts = $this->manageProgramDiscounts->listForProgram($program);
        return view('admin.programs.discounts', compact('program', 'discounts'));
    }

    public function store(ProgramDiscountStoreRequest $request, Program $program)
    {
        $data = $request->validated();

        $discount = $this->manageProgramDiscounts->create($program, $data, $request);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'discount' => $discount]);
        }

        return back()->with('success', 'Diskon berhasil ditambahkan!');
    }

    public function update(ProgramDiscountUpdateRequest $request, Program $program, ProgramDiscount $discount)
    {
        // Toggle active or full update
        if ($request->has('toggle_active')) {
            $discount = $this->manageProgramDiscounts->toggleActive($discount);

            if ($request->wantsJson()) {
                return response()->json(['success' => true, 'discount' => $discount]);
            }

            return back()->with('success', 'Status diskon diperbarui.');
        }

        $data = $request->validated();

        $discount = $this->manageProgramDiscounts->update($discount, $data, $request);

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'discount' => $discount]);
        }

        return back()->with('success', 'Diskon berhasil diperbarui!');
    }

    public function destroy(Program $program, ProgramDiscount $discount)
    {
        $this->manageProgramDiscounts->delete($discount);

        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Diskon berhasil dihapus.');
    }
}
