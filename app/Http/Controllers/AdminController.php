<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Movie;
use App\Models\User;
use App\Models\Rating;
use App\Models\Favorite;
use App\Models\View;
use App\Models\Visitor;
use Carbon\Carbon;
use DatePeriod;
use DateInterval;


use App\Http\Controllers\Controller;
class AdminController extends Controller
{
     // Constructor để kiểm tra quyền
     public function __construct()
     {
         $this->middleware('role:admin'); // Chỉ admin mới vào được
     }
 
     // Hàm để gán role cho user
     public function assignRole(User $user)
     {
         // Gán role "editor" cho user
         $user->assignRole('editor');
         return "Role assigned!";
     }
 
     // Hàm để kiểm tra quyền
     public function checkPermission(User $user)
     {
         if ($user->can('edit articles')) {
             return "User can edit articles!";
         }
         return "User cannot edit articles.";
     }
     
        public function index(Request $request)
    {
        $from = $request->input('from') ? Carbon::parse($request->input('from')) : Carbon::now()->subDays(6);
        $to = $request->input('to') ? Carbon::parse($request->input('to')) : Carbon::now();

        $formattedFrom = Carbon::parse($from)->format('H:i - d-m-Y');
        $formattedTo = Carbon::parse($to)->format('H:i - d-m-Y');
        // Tổng hợp thống kê
        $totalUsers = User::count();
        $totalVisitors = Visitor::distinct('ip_address')->count();
        $totalViews = View::count();
        $totalComments = Rating::count();
        $totalFavorites = Favorite::count();

        // Tạo mảng ngày
        $period = new DatePeriod($from, new DateInterval('P1D'), $to->copy()->addDay());
        $dates = [];
        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        // Dữ liệu theo ngày cho biểu đồ
        $visitorsData = [];
        $viewsData = [];
        $ratingsData = [];
        $favoritesData = [];

        foreach ($dates as $date) {
            $visitorsData[] = Visitor::whereDate('created_at', $date)->distinct('ip_address')->count();
            $viewsData[] = View::whereDate('created_at', $date)->count();
            $ratingsData[] = Rating::whereDate('created_at', $date)->count();
            $favoritesData[] = Favorite::whereDate('created_at', $date)->count(); // Đảm bảo bảng favorites có cột created_at
        }

        return view('admin.user.stats', compact(
            'totalVisitors', 'totalUsers', 'totalViews',
            'totalComments', 'totalFavorites',
            'dates', 'visitorsData', 'viewsData', 'ratingsData', 'favoritesData',
            'formattedFrom', 'formattedTo'
        ));
    }

     
  
}
