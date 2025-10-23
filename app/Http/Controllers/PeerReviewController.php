<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PeerReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PeerReviewController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        $teammates = collect();

        if ($user->kelompok) {
            $teammates = User::where('role', 'mahasiswa')
                             ->where('kelas', $user->kelas)
                             ->where('kelompok', $user->kelompok)
                             ->where('id', '!=', $user->id)
                             ->get();
        }

        // --- QUERY BARU UNTUK MENGAMBIL RIWAYAT ---
        $reviewHistory = PeerReview::where('reviewer_id', $user->id)
                                   ->with('reviewed') // Mengambil nama teman yang dinilai
                                   ->orderBy('minggu_ke', 'desc')
                                   ->orderBy('created_at', 'desc')
                                   ->get();
        // --- AKHIR QUERY BARU ---

        return view('mahasiswa.penilaian_sejawat.index', [
            'teammates' => $teammates,
            'reviewHistory' => $reviewHistory, // Kirim data riwayat ke view
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'minggu_ke' => 'required|integer|min:1',
            'ratings'   => 'required|array',
            'ratings.*' => 'required|integer|min:1|max:5',
            'komentars' => 'nullable|array',
            'komentars.*' => 'nullable|string|max:500',
        ]);

        $reviewerId = Auth::user()->id;

        foreach ($request->ratings as $reviewedId => $rating) {
            PeerReview::updateOrCreate(
                [
                    'reviewer_id' => $reviewerId,
                    'reviewed_id' => $reviewedId,
                    'minggu_ke'   => $request->minggu_ke,
                ],
                [
                    'rating' => $rating,
                    'komentar' => $request->komentars[$reviewedId] ?? null,
                ]
            );
        }

        return back()->with('success', 'Penilaian untuk teman sejawat di minggu ke-' . $request->minggu_ke . ' berhasil disimpan!');
    }
}