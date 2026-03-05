<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassPeriodController extends Controller
{
    public function index()
    {
        return view('admin.class-periods.index');
    }

    public function store(Request $request)
    {
        //
    }

    public function updateStatus(Request $request, $period)
    {
        //
    }
}
