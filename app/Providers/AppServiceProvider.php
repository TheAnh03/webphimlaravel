<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Country;
use App\Models\Decoration;
use App\Models\Genre;
use App\Models\Movie;

use Carbon\Carbon;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use GrahamCampbell\ResultType\Success;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try{
        $info = Decoration::find(1);
        $category = Category::orderBy('position', 'ASC')->where('status', 1)->get();
        $genre = Genre::orderBy('position', 'ASC')->where('status', 1)->get();
        $country = Country::orderBy('position', 'ASC')->where('status', 1)->get();
        $mov_sidebar = Movie::where('isHot', 1)->where('status', 0)->orderBy('updated_at', 'DESC')->take(10)->get();
        $category_total = Category::all()->count();
        $genre_total = Genre::all()->count();
        $country_total = Country::all()->count();
        $movie_total = Movie::all()->count();
        $user_total = User::all()->count();
         // Top ngày
        $topToday = Movie::withCount(['views' => function ($q) {
            $q->whereDate('created_at', Carbon::today());
        }])->orderByDesc('views_count')->take(10)->get();

        // Top tuần
        $topWeek = Movie::withCount(['views' => function ($q) {
            $q->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        }])->orderByDesc('views_count')->take(10)->get();

        // Top tháng
        $topMonth = Movie::withCount(['views' => function ($q) {
            $q->whereMonth('created_at', Carbon::now()->month);
        }])->orderByDesc('views_count')->take(10)->get();

        view()->share([
            'info'=>$info,
            'category_view'=>$category,
            'genre_view'=>$genre,
            'country_view'=>$country,
            'mov_sidebar'=>$mov_sidebar,
            'category_total'=>$category_total,
            'genre_total'=>$genre_total,
            'country_total'=>$country_total,
            'movie_total'=>$movie_total,
            'user_total'=>$user_total,
            'topToday'=>$topToday,
            'topWeek'=>$topWeek,
            'topMonth'=>$topMonth,

        ]);
        view()->composer('*', function ($view) {
            if (Auth::check()) {
                $notifications = Notification::where('user_id', Auth::id())
                    ->orderBy('created_at', 'desc')
                    ->get();
        
                $view->with('notifications', $notifications);
            }
        });
    }
    catch(\Exception $e){}
      

    }
}
