<?php

namespace App\Http\Controllers\Admin;

use App\Application\ToeflMockup\ListMockupResults;
use App\Http\Controllers\Controller;

class ToeflMockupResultController extends Controller
{
    public function __construct(
        private readonly ListMockupResults $listMockupResults
    ) {}

    public function index()
    {
        $results = $this->listMockupResults->execute(15);
        return view('admin.toefl-mockup-results.index', compact('results'));
    }
}
