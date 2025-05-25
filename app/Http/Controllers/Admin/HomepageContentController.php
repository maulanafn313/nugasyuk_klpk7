<?php

namespace App\Http\Controllers\Admin;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Models\HomepageContent;
use App\Http\Controllers\Controller;

class HomepageContentController extends Controller
{
    // public function index()
    // {
    //     $contents = HomepageContent::all();
    //     return view('admin.homepage.index', compact('contents'));
    // }

    // public function create()
    // {
    //     return view('admin.homepage.create');
    // }

    // public function store(Request $request)
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'body' => 'required',
    //         'image_url' => 'nullable|url',
    //     ]);

    //     HomepageContent::create($validated);

    //     return redirect()->route('admin.homepage.index')->with('success', 'Konten berhasil ditambahkan.');
    // }

    // public function edit($id)
    // {
    //     $content = HomepageContent::findOrFail($id);
    //     return view('admin.homepage.edit', compact('content'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'body' => 'required',
    //         'image_url' => 'nullable|url',
    //     ]);

    //     $content = HomepageContent::findOrFail($id);
    //     $content->update($validated);

    //     return redirect()->route('admin.homepage.index')->with('success', 'Konten berhasil diupdate.');
    // }

    // public function destroy($id)
    // {
    //     $content = HomepageContent::findOrFail($id);
    //     $content->delete();

    //     return redirect()->route('admin.homepage.index')->with('success', 'Konten berhasil dihapus.');
    // }

    public function homepage()
    {
        $faqs = Faq::with('user')->whereNotNull('answer')->get(); // Ambil FAQ yang sudah dijawab
        return view('homepage', compact('faqs'));
    }
}
