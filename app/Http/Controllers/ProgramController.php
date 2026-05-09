<?php

namespace App\Http\Controllers;

use App\Application\Program\CreateProgram;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function __construct(
        private readonly CreateProgram $createProgram,
    ) {
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'color'       => 'required|string',
            'icon'        => 'nullable|string',
            'access_key'  => 'nullable|string|max:255',
        ]);

        $this->createProgram->handle($request->only([
            'name', 'description', 'color', 'icon', 'access_key',
        ]));

        return redirect()->back()->with('success', 'Program created successfully.');
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()->back()->with('success', 'Program deleted successfully.');
    }
}
