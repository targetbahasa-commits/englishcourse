<?php

namespace App\Repositories\Eloquent;

use App\Models\FreeTestSubmission;
use App\Repositories\Contracts\LeadRepositoryInterface;
use Carbon\Carbon;

class LeadRepository implements LeadRepositoryInterface
{
    private function applyFilters($query, array $filters = [])
    {
        // 1. Status Follow-Up Filter
        if (!empty($filters['status'])) {
            $query->where('follow_up_status', $filters['status']);
        }

        // 2. Keyword Search
        if (!empty($filters['search'])) {
            $search = trim($filters['search']);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('whatsapp_number', 'like', "%{$search}%");
            });
        }

        // 3. Date Presets & Date Ranges
        $datePreset = $filters['date_preset'] ?? null;
        $dateFrom = $filters['date_from'] ?? null;
        $dateTo = $filters['date_to'] ?? null;

        if ($datePreset) {
            if ($datePreset === 'today') {
                $query->whereDate('created_at', Carbon::today());
            } elseif ($datePreset === 'yesterday') {
                $query->whereDate('created_at', Carbon::yesterday());
            } elseif ($datePreset === '7_days') {
                $query->where('created_at', '>=', Carbon::now()->subDays(7)->startOfDay());
            } elseif ($datePreset === '30_days') {
                $query->where('created_at', '>=', Carbon::now()->subDays(30)->startOfDay());
            } elseif ($datePreset === 'this_month') {
                $query->whereMonth('created_at', Carbon::now()->month)
                      ->whereYear('created_at', Carbon::now()->year);
            }
        } else {
            if (!empty($dateFrom)) {
                $query->where('created_at', '>=', Carbon::parse($dateFrom)->startOfDay());
            }
            if (!empty($dateTo)) {
                $query->where('created_at', '<=', Carbon::parse($dateTo)->endOfDay());
            }
        }

        // 4. Test Category / Program Filter
        if (!empty($filters['test_category'])) {
            $cat = strtolower($filters['test_category']);
            if ($cat === 'grammar') {
                $query->where(function($q) {
                    $q->where('test_type', 'like', 'grammar%');
                });
            } elseif ($cat === 'ielts') {
                $query->where(function($q) {
                    $q->where('test_type', 'like', 'ielts%')
                      ->orWhereIn('test_type', ['writing_t1', 'writing_t2', 'speaking']);
                });
            } elseif ($cat === 'toefl_itp') {
                $query->where(function($q) {
                    $q->where('test_type', 'like', '%toefl%')
                      ->where('test_type', 'not like', '%ibt%');
                });
            } elseif ($cat === 'toefl_ibt') {
                $query->where(function($q) {
                    $q->where('test_type', 'like', '%ibt%');
                });
            } elseif ($cat === 'pte') {
                $query->where('test_type', 'like', 'pte%');
            } elseif ($cat === 'cambridge') {
                $query->where('test_type', 'like', 'cambridge%');
            }
        }

        // 5. CEFR Level Filter
        if (!empty($filters['cefr_level'])) {
            $cefr = strtoupper($filters['cefr_level']);
            if ($cefr === 'C2') {
                $query->where(function($q) {
                    $q->where('estimated_band_score', '>=', 8.0)
                      ->orWhere('estimated_band_score', '>=', 90);
                });
            } elseif ($cefr === 'C1') {
                $query->where(function($q) {
                    $q->whereBetween('estimated_band_score', [7.0, 7.5])
                      ->orWhereBetween('estimated_band_score', [80, 89]);
                });
            } elseif ($cefr === 'B2') {
                $query->where(function($q) {
                    $q->whereBetween('estimated_band_score', [5.5, 6.5])
                      ->orWhereBetween('estimated_band_score', [65, 79]);
                });
            } elseif ($cefr === 'B1') {
                $query->where(function($q) {
                    $q->whereBetween('estimated_band_score', [4.0, 5.0])
                      ->orWhereBetween('estimated_band_score', [50, 64]);
                });
            } elseif ($cefr === 'A2') {
                $query->where(function($q) {
                    $q->whereBetween('estimated_band_score', [3.0, 3.5])
                      ->orWhereBetween('estimated_band_score', [35, 49]);
                });
            } elseif ($cefr === 'A1') {
                $query->where(function($q) {
                    $q->where('estimated_band_score', '<', 3.0)
                      ->orWhere(function($sq) {
                          $sq->where('estimated_band_score', '<', 35)->where('estimated_band_score', '>', 0);
                      });
                });
            }
        }

        // 6. AI Evaluation Status Filter
        if (!empty($filters['eval_status'])) {
            $ev = $filters['eval_status'];
            if ($ev === 'completed') {
                $query->where(function($q) {
                    $q->where('evaluation_status', 'completed')
                      ->orWhereNotNull('estimated_band_score');
                });
            } elseif ($ev === 'failed') {
                $query->where('evaluation_status', 'failed');
            } elseif ($ev === 'pending') {
                $query->whereNull('estimated_band_score')
                      ->where(function($q) {
                          $q->whereNull('evaluation_status')
                            ->orWhere('evaluation_status', 'pending');
                      });
            }
        }

        return $query;
    }

    public function getPaginatedLeads(array $filters = [], int $perPage = 15)
    {
        $query = FreeTestSubmission::query()->orderBy('created_at', 'desc');
        $query = $this->applyFilters($query, $filters);
        return $query->paginate($perPage);
    }

    public function getFilteredCount(array $filters = [], ?string $status = null): int
    {
        $query = FreeTestSubmission::query();
        if ($status !== null) {
            $filters['status'] = $status;
        }
        $query = $this->applyFilters($query, $filters);
        return $query->count();
    }

    public function countAll(): int
    {
        return FreeTestSubmission::count();
    }

    public function countByStatus(string $status): int
    {
        return FreeTestSubmission::where('follow_up_status', $status)->count();
    }

    public function updateStatus(int $id, string $status): bool
    {
        return FreeTestSubmission::where('id', $id)->update([
            'follow_up_status' => $status,
            'updated_at' => now(),
        ]) > 0;
    }
}
