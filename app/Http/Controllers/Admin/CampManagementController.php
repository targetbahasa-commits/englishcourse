<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Camp;
use App\Models\CampRoom;
use App\Models\CampReview;
use Illuminate\Http\Request;

class CampManagementController extends Controller
{
    public function index()
    {
        $totalCamps = Camp::count();
        $rooms = CampRoom::withCount('users')->get();
        
        $totalRooms = $rooms->count();
        $availableRooms = $rooms->where('status', 'Tersedia')->count();
        
        $totalKapasitas = $rooms->sum('kapasitas_per_kamar');
        $totalPenghuni = $rooms->sum('users_count');
        $sisaKuota = max(0, $totalKapasitas - $totalPenghuni);
        
        $potensiPendapatan = $rooms->reduce(function ($carry, $room) {
            $sisaKamar = max(0, $room->kapasitas_per_kamar - $room->users_count);
            return $carry + ($sisaKamar * $room->harga_per_orang);
        }, 0);

        // Camp kosong: camp yang punya kamar tapi total penghuninya 0
        $campsWithRoomStats = Camp::with(['rooms' => function ($query) {
            $query->withCount('users');
        }])->get()->map(function ($camp) {
            $camp->total_penghuni = $camp->rooms->sum('users_count');
            $camp->total_kapasitas = $camp->rooms->sum('kapasitas_per_kamar');
            return $camp;
        });
        
        $campsKosong = $campsWithRoomStats->filter(function ($camp) {
            return $camp->rooms->count() > 0 && $camp->total_penghuni == 0;
        });

        // Top Camps by composite score
        $campsWithReviews = Camp::with('reviews')->whereHas('reviews')->get()->map(function ($camp) {
            $avgKebersihan = $camp->reviews->avg('tingkat_kebersihan');
            $avgFasilitas = $camp->reviews->avg('kualitas_fasilitas');
            $camp->composite_score = ($avgKebersihan + $avgFasilitas) / 2;
            $camp->avg_kebersihan = $avgKebersihan;
            $camp->avg_fasilitas = $avgFasilitas;
            return $camp;
        })->sortByDesc('composite_score')->take(5);

        return view('admin.camp-management.index', compact(
            'totalCamps', 'totalRooms', 'availableRooms', 
            'totalKapasitas', 'totalPenghuni', 'sisaKuota', 'potensiPendapatan',
            'campsKosong', 'campsWithReviews'
        ));
    }
}
