<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Movie;
use App\Models\View;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_user = User::all();
        return view('admin.user.index',compact('list_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.addform');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          // Validate dữ liệu
          $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // email ko trùng
            'password' => 'required|string|min:8',
            'role' => 'required|in:0,1', // chỉ nhận 0 hoặc 1
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Tạo user mới
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        // Gán role
        if ($request->input('role') == 1) {
            $user->assignRole('admin');
        } else {
            $user->assignRole('user');
        }
        toastr()->success('Thêm quốc gia thành công !','Thông báo');
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->avatar && $user->avatar != 'avtdefaut.jpeg') {
            $avatarPath = public_path('uploads/logo/' . $user->avatar);
            if (file_exists($avatarPath)) {
                unlink($avatarPath);
            }
        }
        $user->syncRoles([]);
        $user->delete();
        toastr()->success('Đã xóa tài khoản !','Thông báo');
        return back();
    }

    // list favorite movies
    public function get_favoritelist()
    {
        $user = Auth::user();
        $movieIds = $user->favorites()->pluck('movie_id');
        $favoriteMovies = Movie::whereIn('id', $movieIds)->paginate(10);  
        return view('pages.favoriteList', compact('favoriteMovies'));
    }

    public function addToFavorite($movieId)
    {
        $user = Auth::user();
        
        // Kiểm tra xem phim đã có trong danh sách yêu thích chưa
        if (!$user->favorites()->where('movie_id', $movieId)->exists()) {
            // Thêm vào danh sách yêu thích
            $user->favorites()->attach($movieId);
            toastr()->success('Đã thêm phim vào danh sách theo dõi!','Thông báo');

            return back();
        }
    }
    



    public function removeFavorite($movieId)
    {
        $user = Auth::user();

        // Tìm và xóa phim khỏi danh sách yêu thích
        $user->favorites()->detach($movieId);

        // Quay lại danh sách yêu thích và thông báo thành công
        toastr()->success('Đã bỏ theo dõi phim!','Thông báo');
        return back();
    }
      // history watch
      public function watchHistory()
    {
        $userId = auth()->id();

        $latestViews = DB::table('views')
            ->select(DB::raw('MAX(id) as latest_id'))
            ->where('user_id', $userId)
            ->groupBy('movie_id');

        $history = View::with('movie')
            ->whereIn('id', $latestViews)
            ->latest()
            ->paginate(20);

        return view('pages.history', compact('history'));
    }
    
    
    

}
