<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $activeMember = Member::where('status', 'active')->count();
        $inactiveMember = Member::where('status', 'expired')->count();
        $countMember = Member::count();

        // Latest Transactions
        $latestTransactions = Transaction::with(['member.user', 'package'])->latest()->take(5)->get();

        // Top Packages
        $topPackages = Transaction::select('package_id', DB::raw('COUNT(*) as total_sales'))->groupBy('package_id')->orderByDesc('total_sales')->with('package')->take(5)->get();

        // Line Chart Transactions
        $selectedYear = $request->input('year', date('Y'));

        $rawRevenue = Transaction::selectRaw('MONTH(transactions.created_at) as month, SUM(packages.price) as total')
            ->join('packages', 'transactions.package_id', '=', 'packages.id')
            ->whereYear('transactions.created_at', $selectedYear)
            ->groupBy(DB::raw('MONTH(transactions.created_at)'))
            ->pluck('total', 'month');

        // Buat array 1-12, isi 0 jika bulan tidak ada
        $monthlyRevenue = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyRevenue[$i] = $rawRevenue[$i] ?? 0;
        }

        $years = Transaction::selectRaw('YEAR(created_at) as year')->distinct()->pluck('year');

        // Pie Chart Age
        $rawAgeData = Member::whereHas('user', function ($query) {
        $query->whereNotNull('age');
            })
            ->with('user')
            ->get()
            ->groupBy(function ($member) {
                return $member->user->age;
            })
            ->map(function ($group) {
                return $group->count();
            })
            ->sortKeys();

        $ageChartLabels = $rawAgeData->keys()->toArray();
        $ageChartCounts = $rawAgeData->values()->toArray();

        return view('dashboard', compact(
            'activeMember',
            'inactiveMember',
            'countMember',
            'latestTransactions',
            'topPackages',
            'monthlyRevenue',
            'years',
            'selectedYear',
            'ageChartLabels',
            'ageChartCounts'
        ));
    }

}
