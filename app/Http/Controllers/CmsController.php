<?php


namespace App\Http\Controllers;


use App\Models\Cms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $cms = Cms::all();
        return view('cms.index', compact('cms'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cms.create');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'logo' => 'required|image|mimes:jpg,jpeg,png|max:10240',
            'img_text2' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'img_text3' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'img_text4' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'color' => 'required|string',
            'hero_text' => 'required|string',
            'description_text' => 'required|string',
            'hero_text2' => 'nullable|string',
            'description_text2' => 'nullable|string',
            'hero_text3' => 'nullable|string',
            'description_text3' => 'nullable|string',
            'hero_text4' => 'nullable|string',
            'description_text4' => 'nullable|string',
        ]);




        $logoPath = $request->file('logo')->store('cms', 'public');


        $imgText2Path = $request->hasFile('img_text2') ? $request->file('img_text2')->store('cms', 'public') : null;
        $imgText3Path = $request->hasFile('img_text3') ? $request->file('img_text3')->store('cms', 'public') : null;
        $imgText4Path = $request->hasFile('img_text4') ? $request->file('img_text4')->store('cms', 'public') : null;


        Cms::create([
            'logo' => basename($logoPath),
            'img_text2' => $imgText2Path ? basename($imgText2Path) : null,
            'img_text3' => $imgText3Path ? basename($imgText3Path) : null,
            'img_text4' => $imgText4Path ? basename($imgText4Path) : null,
            'color' => $validated['color'],
            'hero_text' => $validated['hero_text'],
            'description_text' => $validated['description_text'],
            'hero_text2' => $validated['hero_text2'],
            'description_text2' => $validated['description_text2'],
            'hero_text3' => $validated['hero_text3'],
            'description_text3' => $validated['description_text3'],
            'hero_text4' => $validated['hero_text4'],
            'description_text4' => $validated['description_text4'],
        ]);


        return redirect()->route('admin.cms.index')->with('success', 'CMS created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Cms $cms)
    {
        return view('cms.show', compact('cms'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cms $cms)
    {
        return view('cms.edit', compact('cms'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cms $cms)
    {
        $validated = $request->validate([
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'img_text2' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'img_text3' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'img_text4' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'color' => 'required|string',
            'hero_text' => 'required|string',
            'description_text' => 'required|string',
            'hero_text2' => 'nullable|string',
            'description_text2' => 'nullable|string',
            'hero_text3' => 'nullable|string',
            'description_text3' => 'nullable|string',
            'hero_text4' => 'nullable|string',
            'description_text4' => 'nullable|string',
        ]);


        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('cms', 'public');
            $cms->logo = basename($logoPath);
        }


        if ($request->hasFile('img_text2')) {
            $imgText2Path = $request->file('img_text2')->store('cms', 'public');
            $cms->img_text2 = basename($imgText2Path);
        }


        if ($request->hasFile('img_text3')) {
            $imgText3Path = $request->file('img_text3')->store('cms', 'public');
            $cms->img_text3 = basename($imgText3Path);
        }
        if ($request->hasFile('img_text4')) {
            $imgText4Path = $request->file('img_text4')->store('cms', 'public');
            $cms->img_text4 = basename($imgText4Path);
        }


        $cms->update([
            'color' => $validated['color'],
            'hero_text' => $validated['hero_text'],
            'description_text' => $validated['description_text'],
            'hero_text2' => $validated['hero_text2'],
            'description_text2' => $validated['description_text2'],
            'hero_text3' => $validated['hero_text3'],
            'description_text3' => $validated['description_text3'],
            'hero_text4' => $validated['hero_text4'],
            'description_text4' => $validated['description_text4'],
        ]);


        return redirect()->route('admin.cms.index')->with('success', 'CMS updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cms $cms)
    {
        if ($cms->logo) {
            Storage::delete('public/cms/' . $cms->logo);
        }
        if ($cms->img_text2) {
            Storage::delete('public/cms/' . $cms->img_text2);
        }
        if ($cms->img_text3) {
            Storage::delete('public/cms/' . $cms->img_text3);
        }
        if ($cms->img_text4) {
            Storage::delete('public/cms/' . $cms->img_text4);
        }


        $cms->delete();


        return redirect()->route('admin.cms.index')->with('success', 'CMS deleted successfully.');
    }
}


