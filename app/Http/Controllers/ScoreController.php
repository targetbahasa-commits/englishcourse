<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\Score\ManageScores;

class ScoreController extends Controller
{
    public function __construct(private readonly ManageScores $manageScores)
    {
    }

    public function index()
    {
        $request = request();

        $results = $this->manageScores->listScores($request->query(), 20);

        $programs = $this->manageScores->getProgramOptions();

        $stats = $this->manageScores->getScoreMetrics();

        return view('admin.scores.index', compact('results', 'programs', 'stats'));
    }
}
