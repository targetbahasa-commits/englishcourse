<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesAssignmentAccess;

class IeltsMockupController extends Controller
{
    use HandlesAssignmentAccess;

    public function __construct()
    {
        $this->registerAssignmentAccessMiddleware();
    }

    public function reading()
    {
        return view('assignments.ielts.mockup.reading');
    }

    public function writing()
    {
        return view('assignments.ielts.mockup.writing');
    }

    public function speaking()
    {
        return view('assignments.ielts.mockup.speaking');
    }
}