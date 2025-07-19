<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Presence;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PresenceController extends Controller
{
    public function index()
    {
        $presences = Presence::with(['member.user'])
            ->where('status', 'active')
            ->whereDate('scan_in_at', now()->toDateString())
            ->get();

        $members = Member::with('user')->where('status', 'active')->get();

        return view('presence.index', compact('presences', 'members'));
    }

    public function manualStore(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
        ]);

        $member = Member::where('barcode', $request->barcode)->first();

        if (!$member) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Member tidak ditemukan.'], 422);
            }
            return back()->with('error', 'Member tidak ditemukan.');
        }

        if ($member->status !== 'active' || Carbon::parse($member->end_date)->isPast()) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Gagal presensi. Silakan perpanjang membership Anda.'], 422);
            }
            return back()->with('error', 'Gagal presensi. Silakan perpanjang membership Anda.');
        }

        $existingSession = Presence::where('member_id', $member->id)
            ->where('status', 'active')
            ->whereNull('scan_out_at')
            ->first();

        if ($existingSession) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Presensi gagal. Anda masih memiliki sesi aktif.'], 422);
            }
            return back()->with('error', 'Presensi gagal. Anda masih memiliki sesi aktif.');
        }

        Presence::create([
            'member_id' => $member->id,
            'scan_in_at' => now(),
            'status' => 'active',
        ]);

        if ($request->ajax()) {
            return response()->json(['message' => 'Presensi berhasil. Selamat beraktivitas di Lembah Fitness!']);
        }
        return back()->with('success', 'Presensi berhasil. Selamat beraktivitas di Lembah Fitness!');
    }

    public function scanStore(Request $request)
    {
        $request->validate([
            'barcode' => 'required|string',
        ]);

        $member = Member::where('barcode', $request->barcode)->first();

        if (!$member) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Member tidak ditemukan.'], 422);
            }
            return back()->with('error', 'Member tidak ditemukan.');
        }

        if ($member->status !== 'active' || Carbon::parse($member->end_date)->isPast()) {
            if ($request->ajax()) {
                return response()->json(['message' => 'Membership tidak aktif. Silakan perpanjang membership Anda.'], 422);
            }
            return back()->with('error', 'Membership tidak aktif. Silakan perpanjang membership Anda.');
        }

        $existingSession = Presence::where('member_id', $member->id)
            ->where('status', 'active')
            ->whereNull('scan_out_at')
            ->first();

        if ($existingSession) {
            // Scan out (akhiri sesi aktif)
            $existingSession->update([
                'scan_out_at' => now(),
                'status' => 'completed',
            ]);

            if ($request->ajax()) {
                return response()->json(['message' => 'Sesi berhasil diakhiri. Terima kasih!']);
            }
            return back()->with('success', 'Sesi berhasil diakhiri. Terima kasih!');
        } else {
            // Scan in (mulai sesi baru)
            Presence::create([
                'member_id' => $member->id,
                'scan_in_at' => now(),
                'status' => 'active',
            ]);

            if ($request->ajax()) {
                return response()->json(['message' => 'Berhasil presensi masuk. Selamat beraktivitas!']);
            }
            return back()->with('success', 'Berhasil presensi masuk. Selamat beraktivitas!');
        }
    }


    public function closeSession($id)
    {
        $presence = Presence::findOrFail($id);
        $presence->update([
            'scan_out_at' => now(),
            'status' => 'completed',
        ]);

        return back()->with('success', 'Sesi berhasil ditutup.');
    }

    public function chart(Request $request)
    {
        $date = $request->input('date', now()->toDateString());
        $rangeType = $request->input('range_type', 'daily');

        $labels = [];
        $counts = [];

        if ($rangeType === 'daily') {
            $start = Carbon::parse($date)->setTime(6, 0, 0);
            $end = Carbon::parse($date)->setTime(21, 59, 59);

            $data = Presence::whereBetween('scan_in_at', [$start, $end])
                ->select(
                    DB::raw('HOUR(scan_in_at) as hour'),
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy('hour')
                ->pluck('total', 'hour');

            for ($i = 6; $i <= 21; $i++) {
                $labels[] = $i . ":00";
                $counts[] = $data[$i] ?? 0;
            }
        } elseif ($rangeType === 'weekly') {
            $start = Carbon::parse($date)->startOfWeek();
            $end = Carbon::parse($date)->endOfWeek();

            $data = Presence::whereBetween('scan_in_at', [$start, $end])
                ->select(
                    DB::raw('DAYNAME(scan_in_at) as day'),
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy('day')
                ->pluck('total', 'day');

            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            foreach ($days as $day) {
                $labels[] = $day;
                $counts[] = $data[$day] ?? 0;
            }
        } elseif ($rangeType === 'monthly') {
            $start = Carbon::parse($date)->startOfMonth();
            $end = Carbon::parse($date)->endOfMonth();

            $data = Presence::whereBetween('scan_in_at', [$start, $end])
                ->select(
                    DB::raw('DATE(scan_in_at) as day'),
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy('day')
                ->pluck('total', 'day');

            $period = Carbon::parse($start);
            while ($period <= $end) {
                $dayStr = $period->toDateString();
                $labels[] = $period->format('d M');
                $counts[] = $data[$dayStr] ?? 0;
                $period->addDays(2); // ambil tiap 2 hari
            }
        }

        return response()->json([
            'labels' => $labels,
            'counts' => $counts,
        ]);
    }
}
