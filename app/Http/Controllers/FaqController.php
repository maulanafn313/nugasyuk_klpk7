<?php




namespace App\Http\Controllers;




use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;




class FaqController extends Controller
{
    // Form pertanyaan user
    public function create()
    {
        return view('faq.form');
    }

    // Simpan pertanyaan user
    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
        ]);


        Faq::create([
            'question' => $request->question,
            'user_id' => Auth::id(),
        ]);


        return redirect()->route('faq.form')->with('success', 'Pertanyaan Anda telah dikirim!');
    }


    //halaman admin untuk menjawab pertanyaan
    public function index()
    {
        $faqs = Faq::whereNull('answer')->get(); // Ambil pertanyaan yang belum dijawab
        return view('admin.faqs', compact('faqs'));
    }


    // Proses menjawab pertanyaan
    public function answer(Request $request, Faq $faq)
    {
        $request->validate([
            'answer' => 'required|string|max:255',
        ]);


        $faq->update([
            'answer' => $request->answer,
        ]);


        return redirect()->route('admin.faqs')->with('success', 'Pertanyaan telah dijawab!');
    }
}


