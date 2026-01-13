<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use App\Http\Requests\StoreResepRequest;
use App\Http\Requests\UpdateResepRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResepController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $reseps = Resep::when($search, function ($query, $search) {
            return $query->where('judul', 'like', "%{$search}%")
                         ->orWhere('bahan', 'like', "%{$search}%");
        })->paginate(12);

        return view('reseps.index', compact('reseps'));
    }

    public function create()
    {
        return view('reseps.create');
    }

    public function store(StoreResepRequest $request)
    {
        $data = $request->validated();  // Sudah include 'langkah' dari Form Request

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('reseps', 'public');
        }

        // Assign user: use authenticated user, otherwise create/find a local dev user
        if (auth()->check()) {
            $data['user_id'] = auth()->id();
        } elseif (app()->environment('local')) {
            $localUser = \App\Models\User::first();
            if (! $localUser) {
                $localUser = \App\Models\User::factory()->create([
                    'email' => 'local@example.com',
                    'password' => bcrypt('password'),
                ]);
            }
            $data['user_id'] = $localUser->id;
        } else {
            abort(403);
        }

        Resep::create($data);

        return redirect()->route('reseps.index')->with('success', 'Resep berhasil ditambahkan');
    }

    public function show(Resep $resep)
    {
        return view('reseps.show', compact('resep'));
    }

    public function edit(Resep $resep)
    {
        $this->authorize('update', $resep);

        return view('reseps.edit', compact('resep'));
    }

    public function update(UpdateResepRequest $request, Resep $resep)
    {
        $data = $request->validated();  // Sudah include 'langkah' jika diubah

        if ($request->hasFile('gambar')) {
            // delete old gambar if exists
            if ($resep->gambar) {
                Storage::disk('public')->delete($resep->gambar);
            }

            $data['gambar'] = $request->file('gambar')->store('reseps', 'public');
        }

        $resep->update($data);

        return redirect()->route('reseps.index')->with('success', 'Resep berhasil diperbarui');
    }

    public function destroy(Resep $resep)
    {
        $this->authorize('delete', $resep);

        if ($resep->gambar) {
            Storage::disk('public')->delete($resep->gambar);
        }

        $resep->delete();
        return redirect()->route('reseps.index')->with('success', 'Resep berhasil dihapus');
    }

    public function favorite(Resep $resep)
    {
        $user = auth()->user();

        if ($resep->isFavoritedBy($user)) {
            $user->favorites()->detach($resep);
            $message = 'Resep dihapus dari favorite.';
        } else {
            $user->favorites()->attach($resep);
            $message = 'Resep ditambahkan ke favorite.';
        }

        return back()->with('success', $message);
    }
}
