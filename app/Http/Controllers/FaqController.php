<?php


namespace App\Http\Controllers;


use App\Models\Faq;
use Illuminate\Http\Request;


class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::all();
        return view('faqs.index', compact('faqs'));
    }


    public function create()
    {
        return view('faqs.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);


        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);


        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil ditambahkan.');
    }


    public function show(Faq $faq)
    {
        return view('faqs.show', compact('faq'));
    }


    public function edit(Faq $faq)
    {
        return view('faqs.edit', compact('faq'));
    }


    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);


        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);


        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil diupdate.');
    }


    public function destroy(Faq $faq)
    {
        $faq->delete();


        return redirect()->route('admin.faqs.index')->with('success', 'FAQ berhasil dihapus.');
    }
}



