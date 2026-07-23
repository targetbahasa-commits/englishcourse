<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CampReview;
use Illuminate\Http\Request;

class CampReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = CampReview::with(['camp', 'student'])->orderByDesc('tanggal_review');
        
        if ($request->filled('camp_id')) {
            $query->where('camp_id', $request->camp_id);
        }

        $reviews = $query->paginate(20)->withQueryString();
        $camps = \App\Models\Camp::all();

        return view('admin.camp-management.reviews.index', compact('reviews', 'camps'));
    }

    public function destroy(CampReview $campReview)
    {
        $campReview->delete();
        return redirect()->route('admin.camp-reviews.index')->with('success', 'Review berhasil dihapus.');
    }
}
