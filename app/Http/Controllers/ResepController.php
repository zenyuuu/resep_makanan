use App\Models\Resep;
use Illuminate\Http\Request;

class ResepController extends Controller
{
    public function index()
    {
        $reseps = Resep::latest()->get();
        return view('reseps.index', compact('reseps'));
    }

    public function create()
    {
        return view('reseps.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'judul' => 'required',
            'bahan' => 'required',
            'langkah' => 'required',
            'gambar' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('reseps', 'public');
        }

        $data['user_id'] = auth()->id();
        Resep::create($data);

        return redirect()->route('reseps.index')->with('success', 'Resep berhasil ditambahkan');
    }

    public function show(Resep $resep)
    {
        return view('reseps.show', compact('resep'));
    }

    public function edit(Resep $resep)
    {
        return view('reseps.edit', compact('resep'));
    }

    public function update(Request $request, Resep $resep)
    {
        $data = $request->validate([
            'judul' => 'required',
            'bahan' => 'required',
            'langkah' => 'required',
            'gambar' => 'image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('reseps', 'public');
        }

        $resep->update($data);

        return redirect()->route('reseps.index')->with('success', 'Resep berhasil diperbarui');
    }

    public function destroy(Resep $resep)
    {
        $resep->delete();
        return redirect()->route('reseps.index')->with('success', 'Resep berhasil dihapus');
    }
}
