<?php

namespace App\Application\Payment;

use App\Domain\Payment\Repositories\PaymentRepository;
use Illuminate\Http\Request;

class AdminPaymentQuery
{
    public function __construct(
        private readonly PaymentRepository $repository,
    ) {}
    public function getFilters(Request $request): array
    {
        $request->validate([
            'q'               => ['nullable', 'string', 'max:120'],
            'status'          => ['nullable', 'in:all,pending,paid,failed,cancelled,expired,refunded'],
            'channel'         => ['nullable', 'in:all,bank_transfer,cash'],
            'proof'           => ['nullable', 'in:all,yes,no'],
            'settlement'      => ['nullable', 'in:all,underpaid,exact,overpaid'],
            'variance'        => ['nullable', 'in:all,negative,zero,positive'],
            'override'        => ['nullable', 'in:all,yes,no'],
            'trend_threshold' => ['nullable', 'numeric', 'min:1', 'max:100'],
            'trend_period'    => ['nullable', 'in:daily,monthly,yearly'],
            'date_from'       => ['nullable', 'date'],
            'date_to'         => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        return [
            'q'               => trim((string) $request->query('q', '')),
            'status'          => (string) $request->query('status', 'pending'),
            'channel'         => (string) $request->query('channel', 'all'),
            'proof'           => (string) $request->query('proof', 'all'),
            'settlement'      => (string) $request->query('settlement', 'all'),
            'variance'        => (string) $request->query('variance', 'all'),
            'override'        => (string) $request->query('override', 'all'),
            'trend_threshold' => (string) $request->query('trend_threshold', '10'),
            'trend_period'    => (string) $request->query('trend_period', 'daily'),
            'date_from'       => (string) $request->query('date_from', ''),
            'date_to'         => (string) $request->query('date_to', ''),
        ];
    }

    public function build(array $filters, bool $withRelations = true): mixed
    {
        return $this->repository->buildQuery($filters, $withRelations);
    }

    public function buildTrendStats(array $filters, string $period = 'daily'): array
    {
        $trendFilters = array_merge($filters, [
            'date_from' => '',
            'date_to'   => '',
        ]);
        $netAmountExpr = 'CASE WHEN (amount - discount_amount) < 0 THEN 0 ELSE (amount - discount_amount) END';
        $period = in_array($period, ['daily', 'monthly', 'yearly'], true) ? $period : 'daily';

        if ($period === 'monthly') {
            $trendStart = now()->subMonths(11)->startOfMonth();
            $trendEnd = now()->endOfMonth();
            $trendRows = $this->build($trendFilters, false)
                ->whereBetween('created_at', [$trendStart, $trendEnd])
                ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as period_key")
                ->selectRaw('COUNT(*) as total_invoices')
                ->selectRaw('COALESCE(SUM(' . $netAmountExpr . '), 0) as total_net_amount')
                ->selectRaw('COALESCE(SUM(COALESCE(paid_amount, 0)), 0) as total_paid_amount')
                ->selectRaw('COALESCE(SUM(CASE WHEN paid_amount IS NOT NULL AND paid_amount < ' . $netAmountExpr . ' THEN 1 ELSE 0 END), 0) as underpaid_count')
                ->groupBy('period_key')
                ->orderBy('period_key')
                ->get()
                ->keyBy('period_key');

            return $this->hydrateTrendStats($trendRows, 11, function (int $offset) {
                $date = now()->subMonths($offset);

                return [
                    'key' => $date->format('Y-m'),
                    'label' => $date->format('M Y'),
                ];
            });
        }

        if ($period === 'yearly') {
            $trendStart = now()->subYears(4)->startOfYear();
            $trendEnd = now()->endOfYear();
            $trendRows = $this->build($trendFilters, false)
                ->whereBetween('created_at', [$trendStart, $trendEnd])
                ->selectRaw('YEAR(created_at) as period_key')
                ->selectRaw('COUNT(*) as total_invoices')
                ->selectRaw('COALESCE(SUM(' . $netAmountExpr . '), 0) as total_net_amount')
                ->selectRaw('COALESCE(SUM(COALESCE(paid_amount, 0)), 0) as total_paid_amount')
                ->selectRaw('COALESCE(SUM(CASE WHEN paid_amount IS NOT NULL AND paid_amount < ' . $netAmountExpr . ' THEN 1 ELSE 0 END), 0) as underpaid_count')
                ->groupBy('period_key')
                ->orderBy('period_key')
                ->get()
                ->keyBy('period_key');

            return $this->hydrateTrendStats($trendRows, 4, function (int $offset) {
                $date = now()->subYears($offset);

                return [
                    'key' => (string) $date->year,
                    'label' => (string) $date->year,
                ];
            });
        }

        $trendStart = now()->subDays(6)->startOfDay();
        $trendEnd = now()->endOfDay();
        $trendRows = $this->build($trendFilters, false)
            ->whereBetween('created_at', [$trendStart, $trendEnd])
            ->selectRaw('DATE(created_at) as period_key')
            ->selectRaw('COUNT(*) as total_invoices')
            ->selectRaw('COALESCE(SUM(' . $netAmountExpr . '), 0) as total_net_amount')
            ->selectRaw('COALESCE(SUM(COALESCE(paid_amount, 0)), 0) as total_paid_amount')
            ->selectRaw('COALESCE(SUM(CASE WHEN paid_amount IS NOT NULL AND paid_amount < ' . $netAmountExpr . ' THEN 1 ELSE 0 END), 0) as underpaid_count')
            ->groupBy('period_key')
            ->orderBy('period_key')
            ->get()
            ->keyBy('period_key');

        return $this->hydrateTrendStats($trendRows, 6, function (int $offset) {
            $date = now()->subDays($offset);

            return [
                'key' => $date->toDateString(),
                'label' => $date->format('d M'),
            ];
        });
    }

    private function hydrateTrendStats(mixed $trendRows, int $maxOffset, callable $periodResolver): array
    {
        $trendStats = [];

        for ($offset = $maxOffset; $offset >= 0; $offset--) {
            $period = $periodResolver($offset);
            $row = $trendRows->get($period['key']);
            $invoices = (int) ($row->total_invoices ?? 0);
            $underpaidCount = (int) ($row->underpaid_count ?? 0);
            $netAmount = (int) ($row->total_net_amount ?? 0);
            $paidAmount = (int) ($row->total_paid_amount ?? 0);

            $underpaidPercentage = $invoices > 0
                ? round(($underpaidCount / $invoices) * 100, 2)
                : 0.0;
            $paidCoveragePercentage = $netAmount > 0
                ? round(($paidAmount / $netAmount) * 100, 2)
                : 0.0;

            $trendStats[] = [
                'date_label' => $period['label'],
                'invoices' => $invoices,
                'underpaid_percentage' => $underpaidPercentage,
                'paid_coverage_percentage' => $paidCoveragePercentage,
            ];
        }

        return $trendStats;
    }
}
