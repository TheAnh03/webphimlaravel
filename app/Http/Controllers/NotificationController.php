<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\Movie;
use App\Models\Episode;


class NotificationController extends Controller
{
    public function read($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update(['is_read' => true]);
    
        
        try {
            $parsed = parse_url($notification->link, PHP_URL_PATH);
            $parts = explode('/', trim($parsed, '/')); // ["xem-phim", "{slug}", "ep-{ep}", "ser-{server}"]
    
            $slug = $parts[1] ?? null;
            $epStr = $parts[2] ?? null;
            $serStr = $parts[3] ?? null;
    
            $ep = intval(str_replace('ep-', '', $epStr));
            $server = intval(str_replace('ser-', '', $serStr));
    
            $movie = Movie::where('slug', $slug)->first();
            if (!$movie) {
                return back()->with('alert', 'Tập phim không còn tồn tại!');
            }
    
            $episode = Episode::where([
                ['movie_id', $movie->id],
                ['episode', $ep],
                ['server_id', $server]
            ])->first();
    
            if (!$episode) {
                return back()->with('alert', 'Tập phim không còn tồn tại!');
            }
    
            return redirect($notification->link);
    
        } catch (\Exception $e) {
            return back()->with('alert', 'Đã xảy ra lỗi khi mở tập phim.');
        }
    }
    

public function clear()
{
    Notification::where('user_id', Auth::id())->delete();
    return back();
}

}
 