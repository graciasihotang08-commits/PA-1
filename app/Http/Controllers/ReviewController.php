<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Fungsi untuk USER (Menampilkan Form)
    public function index()
    {
        $reviews = Review::latest()->get();

        return view('kritik', compact('reviews'));
    }

    // Fungsi untuk menyimpan kritik dari User
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required'
        ]);

        Review::create([
            'name' => Auth::user()->name,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'user_id' => Auth::id()
        ]);

        return redirect()->back()->with('success', 'Berhasil mengirim kritik!');
    }

    // Fungsi untuk Menghapus Review (User)
    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        return redirect()->back()->with('success', 'Review berhasil dihapus!');
    }


}   