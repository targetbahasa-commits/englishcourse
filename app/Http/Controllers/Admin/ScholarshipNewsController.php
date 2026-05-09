<?php

namespace App\Http\Controllers\Admin;

use App\Application\Scholarship\ManageScholarshipNews;
use App\Http\Controllers\Controller;
use App\Models\ScholarshipNews;
use Illuminate\Http\Request;

class ScholarshipNewsController extends Controller
{
    public function __construct(
        private readonly ManageScholarshipNews $useCase
    ) {}

    public function index()
    {
        $news = $this->useCase->listAll(15);
        return view('admin.scholarship-news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.scholarship-news.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'summary'      => 'nullable|string|max:1000',
            'url'          => 'nullable|url|max:500',
            'published_at' => 'required|date',
            'is_active'    => 'boolean',
        ]);

        $this->useCase->create([
            'title'        => $request->title,
            'summary'      => $request->summary,
            'url'          => $request->url,
            'published_at' => $request->published_at,
            'is_active'    => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.scholarship-news.index')
            ->with('success', 'News article created successfully.');
    }

    public function edit(ScholarshipNews $scholarshipNews)
    {
        return view('admin.scholarship-news.edit', compact('scholarshipNews'));
    }

    public function update(Request $request, ScholarshipNews $scholarshipNews)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'summary'      => 'nullable|string|max:1000',
            'url'          => 'nullable|url|max:500',
            'published_at' => 'required|date',
            'is_active'    => 'boolean',
        ]);

        $this->useCase->update($scholarshipNews, [
            'title'        => $request->title,
            'summary'      => $request->summary,
            'url'          => $request->url,
            'published_at' => $request->published_at,
            'is_active'    => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.scholarship-news.index')
            ->with('success', 'News article updated successfully.');
    }

    public function destroy(ScholarshipNews $scholarshipNews)
    {
        $this->useCase->delete($scholarshipNews);
        return redirect()->route('admin.scholarship-news.index')
            ->with('success', 'News article deleted.');
    }
}
