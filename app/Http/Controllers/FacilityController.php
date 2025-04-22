<?php


namespace App\Http\Controllers;


use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::all();
        return view('facilities.index', compact('facilities'));
    }


    public function create()
    {
        return view('facilities.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);


        $imgPath = $request->file('img')->store('facilities', 'public');


        Facility::create([
            'title' => $request->title,
            'description' => $request->description,
            'img' => $imgPath,
        ]);


        return redirect()->route('admin.facilities.index')->with('success', 'Facility berhasil ditambahkan.');
    }


    public function show(Facility $facility)
    {
        return view('facilities.show', compact('facility'));
    }


    public function edit(Facility $facility)
    {
        return view('facilities.edit', compact('facility'));
    }


    public function update(Request $request, Facility $facility)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'img' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);


        if ($request->hasFile('img')) {
            if ($facility->img) {
                Storage::disk('public')->delete($facility->img);
            }
            $imgPath = $request->file('img')->store('facilities', 'public');
            $facility->img = $imgPath;
        }


        $facility->title = $request->title;
        $facility->description = $request->description;
        $facility->save();


        return redirect()->route('admin.facilities.index')->with('success', 'Facility berhasil diupdate.');
    }


    public function destroy(Facility $facility)
    {
        if ($facility->img) {
            Storage::disk('public')->delete($facility->img);
        }
        $facility->delete();


        return redirect()->route('admin.facilities.index')->with('success', 'Facility berhasil dihapus.');
    }
}


