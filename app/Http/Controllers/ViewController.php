<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\View;

class ViewController extends Controller
{
    public function destroy($id)
    {
        $view = View::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();
    
        if ($view) {
            $view->delete();
            toastr()->success('Đã xóa khỏi lịch sử xem!', 'Thông báo');
        } else {
            toastr()->error('Không tìm thấy hoặc không có quyền xóa!', 'Lỗi');
        }
    
        return back();
    }
    public function clearHistory()
    {
        View::where('user_id', auth()->id())->delete();
        toastr()->success('Đã xóa toàn bộ lịch sử xem!', 'Thông báo');
        return back();
    }

    
    
}
