<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resep;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResepApiController extends Controller
{
    /**
     * Get all reseps with pagination
     * GET /api/reseps?page=1&per_page=12
     */
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 12);
        $reseps = Resep::with('user')
            ->latest()
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $reseps->items(),
            'pagination' => [
                'current_page' => $reseps->currentPage(),
                'per_page' => $reseps->perPage(),
                'total' => $reseps->total(),
                'last_page' => $reseps->lastPage(),
                'from' => $reseps->firstItem(),
                'to' => $reseps->lastItem(),
            ]
        ]);
    }

    /**
     * Get single resep detail
     * GET /api/reseps/{id}
     */
    public function show($id)
    {
        $resep = Resep::with('user', 'favorites')->find($id);

        if (!$resep) {
            return response()->json([
                'success' => false,
                'message' => 'Resep tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $resep->id,
                'judul' => $resep->judul,
                'bahan' => $resep->bahan,
                'langkah' => $resep->langkah,
                'gambar' => $resep->gambar ? Storage::url($resep->gambar) : null,
                'user' => [
                    'id' => $resep->user->id,
                    'name' => $resep->user->name,
                    'email' => $resep->user->email,
                ],
                'favorites_count' => $resep->favorites()->count(),
                'created_at' => $resep->created_at,
                'updated_at' => $resep->updated_at,
            ]
        ]);
    }

    /**
     * Get all reseps by specific user
     * GET /api/reseps/{user_id}/user
     */
    public function showByUser($userId)
    {
        $reseps = Resep::where('user_id', $userId)
            ->with('user')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'count' => $reseps->count(),
            'data' => $reseps
        ]);
    }

    /**
     * Search reseps by judul or bahan
     * GET /api/search?q=nasi+goreng
     */
    public function search(Request $request)
    {
        $query = $request->query('q');

        if (!$query || strlen($query) < 2) {
            return response()->json([
                'success' => false,
                'message' => 'Query minimal 2 karakter'
            ], 400);
        }

        $reseps = Resep::with('user')
            ->where('judul', 'like', "%{$query}%")
            ->orWhere('bahan', 'like', "%{$query}%")
            ->latest()
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'query' => $query,
            'count' => $reseps->count(),
            'data' => $reseps
        ]);
    }

    /**
     * Create new resep
     * POST /api/reseps
     * Required: judul, bahan, langkah
     * Optional: gambar (file)
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'bahan' => 'required|string',
            'langkah' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['judul', 'bahan', 'langkah']);
        $data['user_id'] = auth()->id();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('reseps', 'public');
        }

        $resep = Resep::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Resep berhasil dibuat',
            'data' => $resep->load('user')
        ], 201);
    }

    /**
     * Update resep
     * PUT /api/reseps/{id}
     */
    public function update(Request $request, $id)
    {
        $resep = Resep::find($id);

        if (!$resep) {
            return response()->json([
                'success' => false,
                'message' => 'Resep tidak ditemukan'
            ], 404);
        }

        // Check authorization
        if ($resep->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk update resep ini'
            ], 403);
        }

        $request->validate([
            'judul' => 'sometimes|string|max:255',
            'bahan' => 'sometimes|string',
            'langkah' => 'sometimes|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['judul', 'bahan', 'langkah']);

        if ($request->hasFile('gambar')) {
            // Delete old image
            if ($resep->gambar && Storage::disk('public')->exists($resep->gambar)) {
                Storage::disk('public')->delete($resep->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('reseps', 'public');
        }

        $resep->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Resep berhasil diupdate',
            'data' => $resep->load('user')
        ]);
    }

    /**
     * Delete resep
     * DELETE /api/reseps/{id}
     */
    public function destroy($id)
    {
        $resep = Resep::find($id);

        if (!$resep) {
            return response()->json([
                'success' => false,
                'message' => 'Resep tidak ditemukan'
            ], 404);
        }

        // Check authorization
        if ($resep->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak memiliki akses untuk delete resep ini'
            ], 403);
        }

        // Delete image
        if ($resep->gambar && Storage::disk('public')->exists($resep->gambar)) {
            Storage::disk('public')->delete($resep->gambar);
        }

        $resep->delete();

        return response()->json([
            'success' => true,
            'message' => 'Resep berhasil dihapus'
        ]);
    }

    /**
     * Get user's favorite reseps
     * GET /api/favorites
     */
    public function favorites()
    {
        $user = auth()->user();
        $favorites = $user->favorites()->with('user')->latest()->get();

        return response()->json([
            'success' => true,
            'count' => $favorites->count(),
            'data' => $favorites
        ]);
    }

    /**
     * Toggle favorite status
     * POST /api/reseps/{id}/favorite
     */
    public function favorite($id)
    {
        $resep = Resep::find($id);

        if (!$resep) {
            return response()->json([
                'success' => false,
                'message' => 'Resep tidak ditemukan'
            ], 404);
        }

        $user = auth()->user();
        $isFavorited = $user->favorites()->where('resep_id', $id)->exists();

        if ($isFavorited) {
            $user->favorites()->detach($resep);
            $message = 'Resep dihapus dari favorit';
        } else {
            $user->favorites()->attach($resep);
            $message = 'Resep ditambahkan ke favorit';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'is_favorited' => !$isFavorited
        ]);
    }

    /**
     * Remove from favorite
     * DELETE /api/reseps/{id}/favorite
     */
    public function unfavorite($id)
    {
        $resep = Resep::find($id);

        if (!$resep) {
            return response()->json([
                'success' => false,
                'message' => 'Resep tidak ditemukan'
            ], 404);
        }

        auth()->user()->favorites()->detach($resep);

        return response()->json([
            'success' => true,
            'message' => 'Resep dihapus dari favorit'
        ]);
    }
}
