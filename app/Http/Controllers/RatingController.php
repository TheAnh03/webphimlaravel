<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;

class RatingController extends Controller
{
    //
    public function store(Request $request)
    {
        // $exists = Rating::where('user_id', auth()->id())
        //         ->where('movie_id', $request->movie_id)
        //         ->exists();

        // if ($exists) {
        //     return back()->with('error', 'Bạn đã đánh giá phim này rồi.');
        // }
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'ratepoint' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);
        Rating::create([
            'user_id'   => auth()->id(),
            'movie_id'  => $request->movie_id,
            'ratepoint' => $request->ratepoint,
            'comment'   => $request->comment,
        ]);        

        return redirect()->back()->with('success', 'Đánh giá của bạn đã được lưu.');
    }

    public function destroy($id)
    {
        Rating::destroy($id);
        return back()->with('success', 'Đã xoá bình luận.');
    }
}
