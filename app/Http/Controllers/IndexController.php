<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\View;


class IndexController extends Controller
{
    public function home()
    {
        $hotmovie = Movie::where('isHot', 1)->where('status', 1)->orderBy('updated_at', 'DESC')->get();
        $category_home = Category::with('movie')->orderBy('position', 'ASC')->where('status', 1)->get();
        return view('pages.home', compact('category_home', 'hotmovie'));
    }
    public function category($slug)
    {
        $cate_slug = Category::where('slug', $slug)
            ->where('slug', $slug)
            ->first();
        $movie = Movie::where('category_id', $cate_slug->id)->orderBy('updated_at', 'DESC')->paginate(40);
        return view('pages.category', compact('cate_slug', 'movie'));
    }
    public function genre($slug)
    {
        $genre_slug = Genre::where('slug', $slug)->firstOrFail();
        $movie = $genre_slug->movie()
            ->where('status', 1)
            ->orderBy('updated_at', 'DESC')
            ->paginate(40);

        return view('pages.genre', compact('genre_slug', 'movie'));
    }
    public function country($slug)
    {
        $coun_slug = Country::where('slug', $slug)->first();
        $movie = Movie::where('country_id', $coun_slug->id)->orderBy('updated_at', 'DESC')->paginate(40);

        return view('pages.country', compact('coun_slug', 'movie'));
    }
    public function year($year)
    {
        $year = $year;
        $movie = Movie::where('year', $year)->orderBy('updated_at', 'DESC')->paginate(40);
        return view('pages.year', compact('year', 'movie'));
    }
    public function tag($tag)
    {
        $keyword = $tag;
        $movie = Movie::where('tags', 'LIKE', '%' . $keyword . '%')
            ->orWhere('title', 'LIKE', '%' . $keyword . '%')
            ->orderBy('updated_at', 'DESC')
            ->paginate(40);
        return view('pages.searchResult', compact('keyword', 'movie'));
    }
    public function search(Request $request)
    {
        $keyword = $request->input('search');

        if (!$keyword) {
            return redirect()->route('/');
        }

        $movie = Movie::where('tags', 'LIKE', '%' . $keyword . '%')
            ->orWhere('title', 'LIKE', '%' . $keyword . '%')
            ->orderBy('updated_at', 'DESC')
            ->paginate(40);

        return view('pages.searchResult', compact('keyword', 'movie'));
    }

    public function movie($slug)
    {
        $movie = Movie::with('category', 'movie_genre', 'country')->where('slug', $slug)->firstOrFail();

       // Lấy danh sách genre_id của phim hiện tại
        $genreIds = $movie->movie_genre->pluck('id')->toArray();

        // Tìm các phim có ít nhất 1 genre trùng, loại trừ phim hiện tại
        $movie_related = Movie::whereHas('movie_genre', function ($query) use ($genreIds) {
                $query->whereIn('genre_id', $genreIds);
            })
            ->where('status', 1)
            ->where('id', '!=', $movie->id)
            ->with('category', 'country', 'movie_genre')
            ->inRandomOrder()
            ->take(8)
            ->get();
 

        // $movie_related = Movie::with('category', 'country', 'movie_genre')
        //     ->where('category_id', $movie->category->id)
        //     ->where('status', 1)
        //     ->where('id', '!=', $movie->id)
        //     ->inRandomOrder()
        //     ->take(8)
        //     ->get();

        // list ep
        $list_ep = Episode::where('movie_id', $movie->id)
        ->select('episode')
        ->groupBy('episode')
        ->orderBy('episode', 'ASC')
        ->get();
        // $first_ep = $list_ep->first();

        $first_ep = Episode::where('movie_id', $movie->id)->orderBy('server_id')->orderBy('episode')->first();

        $eps = count($list_ep);


        return view('pages.movie', compact('movie', 'movie_related', 'first_ep', 'eps'));
    }
    public function watch($slug, $ep, $server)
    {
        $movie = Movie::with('category', 'movie_genre', 'country', 'episodes')->where('slug', $slug)->where('status', 1)->firstOrFail();
       $genreIds = $movie->movie_genre->pluck('id')->toArray();
       $movie_related = Movie::whereHas('movie_genre', function ($query) use ($genreIds) {
               $query->whereIn('genre_id', $genreIds);
           })
           ->where('status', 1)
           ->where('id', '!=', $movie->id)
           ->with('category', 'country', 'movie_genre')
           ->inRandomOrder()
           ->take(8)
           ->get();


        // episode
        $tapphim = $ep;
        $server_id = $server;

        $episode = Episode::where('movie_id', $movie->id)
            ->where('episode', $ep)
            ->where('server_id', $server_id)
            ->first();

        $alreadyViewed = View::where('movie_id', $movie->id)
            ->where('ip_address', request()->ip())
            ->where('created_at', '>=', now()->subMinutes(10)) // nếu chưa xem đủ 10 phút thì f5 sẽ kh tăng view
            ->exists();
        
        if (! $alreadyViewed) {
            View::create([
                'movie_id' => $movie->id,
                'user_id' => auth()->id(),
                'ip_address' => request()->ip(),
            ]);
        }
        // $sessionKey = 'viewed_movie_' . $movie->id;
        // if (!session()->has($sessionKey)) {
        //     $movie->increment('views');
        //     session()->put($sessionKey, true);
        // }
        $episodes_by_server = Episode::with('server')
            ->where('movie_id', $movie->id)
            ->orderBy('server_id')
            ->orderBy('episode')
            ->get()
            ->groupBy('server_id'); // nhóm theo server_id
        
        

        return view('pages.watch', compact('movie', 'movie_related', 'episode', 'tapphim','episodes_by_server','server_id'));
    }
    // public function episode()
    // {
    //     return view('pages.episode');
    // }
    // filter
    public function filter()
    {

        if (!empty($_GET['category']) || !empty($_GET['country']) || !empty($_GET['year']) || !empty($_GET['genre'])) {


            $query = Movie::query();

            if (!empty($_GET['category'])) {
                $query->where('category_id', $_GET['category']);
            }

            if (!empty($_GET['country'])) {
                $query->where('country_id', $_GET['country']);
            }

            if (!empty($_GET['year'])) {
                $query->where('year', $_GET['year']);
            }

            $genreId = $_GET['genre'] ?? null;
            if (!empty($_GET['genre'])) {
                $query->whereHas('movie_genre', function ($q) use ($genreId) {
                    $q->where('genres.id', $_GET['genre']);
                });
            }
            if (!empty($_GET['order'])) {
                switch ($_GET['order']) {
                    case 'dateupload':
                        $query->orderBy('created_at', 'desc');
                        break;
                    case 'year':
                        $query->orderBy('year', 'desc');
                        break;
                    case 'title':
                        $query->orderBy('title', 'asc');
                        break;
                    case 'view':
                        $query->orderBy('view', 'desc');
                        break;
                }
            }
            // Lấy danh sách kết quả
            $list = $query->paginate(40);
            return view('pages.filter', compact('list'));
        } else {
            $list = null;
            $error = 'Chọn ít nhất một điều kiện lọc.';
            return view('pages.filter', compact('list', 'error'));
        }
    }
  

}
