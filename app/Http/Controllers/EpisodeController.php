<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Server;
use App\Models\Notification;
use Illuminate\Support\Facades\DB;


class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $episodes = Episode::with('movie')->orderBy('movie_id')->orderBy('episode')->get();

        return view('admin.episode.form', compact('episodes'));
    }
    
    public function manageEpisodes(Request $request)
    {
        $movie = Movie::find($request->id);

      
        $list_server = Server::pluck('name','id');
        
        return view('admin.episode.manage', compact('movie','list_server'));


    }


    public function getEpisodesByMovieAndServer(Request $request)
    {
        $movie = Movie::find($request->movie_id);
        if (!$movie) {
            return response()->json(['episode' => 1, 'da_co' => []]);
        }

        $existingEpisodes = Episode::where('movie_id', $request->movie_id)
            ->where('server_id', $request->server_id)
            ->get(['id', 'episode', 'link']);

        return response()->json([
            'episode' => (int) $movie->episode,
            'da_co' => $existingEpisodes
        ]);
    }


    public function list_episodes_store(Request $request)
    {
        //  Validate dữ liệu
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'server_id' => 'required|exists:servers,id',
            'episodes' => 'required|array',
            'episodes.*.link' => 'nullable|url'
        ]);
    
        DB::beginTransaction(); //   transaction
    
        try {
            $movieId = $request->movie_id;
            $serverId = $request->server_id;
    
            //  Lấy danh sách các tập đã tồn tại
            $existingEpisodes = Episode::where('movie_id', $movieId)
                ->where('server_id', $serverId)
                ->pluck('episode')
                ->toArray();
    
            $addedCount = 0;
    
            $movie = Movie::findOrFail($movieId);
            $followers = $movie->usersWhoFavorited;
    
            //  Duyệt qua từng tập được gửi từ request
            foreach ($request->episodes as $epNumber => $epData) {
                if (empty($epData['link'])) {
                    continue;
                }
    
                if (in_array($epNumber, $existingEpisodes)) {
                    continue;
                }
    
                // Thêm tập mới
                $episode = Episode::create([
                    'movie_id' => $movieId,
                    'server_id' => $serverId,
                    'episode'   => $epNumber,
                    'link'      => $epData['link']
                ]);
    
                $addedCount++;
    
                // Gửi thông báo đến người dùng theo dõi
                foreach ($followers as $user) {
                    Notification::create([
                        'user_id' => $user->id,
                        'movie_id' => $movie->id,
                        'message' => 'Phim "' . $movie->title . '" đã có tập mới: Tập ' . $epNumber,
                        'link'    => route('watch', [
                            'slug'   => $movie->slug,
                            'ep'     => $episode->episode,
                            'server' => $episode->server_id,
                        ]),
                    ]);
                }
            }
    
            // Không có tập nào được thêm
            if ($addedCount === 0) {
                DB::rollBack();
                return response()->json([
                    'status'  => 'warning',
                    'message' => 'Không có tập phim nào được thêm mới!'
                ], 200);
            }
    
            // OK
            DB::commit();
            return response()->json([
                'status'  => 'success',
                'message' => "Đã thêm $addedCount tập phim mới!"
            ], 200);
    
        } catch (\Exception $e) {
            DB::rollBack(); // Có lỗi 
            return response()->json([
                'status'  => 'error',
                'message' => 'Đã xảy ra lỗi: ' . $e->getMessage()
            ], 500);
        }
    }
    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list_movie = Movie::orderBy('id', 'DESC')->pluck('title', 'id');
        $list_server = Server::pluck('name','id');
        
        return view('admin.episode.addform', compact('list_movie','list_server'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
        
            'link'     => 'required|url',   // link bắt buộc và phải đúng định dạng URL
        ], [
         
            'link.required'     => 'Vui lòng nhập link phim.',
            'link.url'          => 'Link phim không đúng định dạng URL.',
        ]);
        
        $data = $request->all();
        $episode = new Episode();
        $episode->movie_id = $data['movie_id'];
        $episode->episode = $data['ep'];
        $episode->link = $data['link'];
        $episode->save();
        
        toastr()->success('Thêm tập phim thành công!', 'Thông báo');
        return redirect()->route('manage-episodes', ['id' => $request->movie_id]);
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
    public function createWithMovie($id)
    {
        $movie = Movie::with('episodes')->findOrFail($id); // Load cả danh sách các tập đã có

        return view('admin.episode.addep', compact('movie'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $episode = Episode::findOrFail($id); // Lấy tập phim cần sửa

        $list_movie = Movie::pluck('title', 'id'); // Lấy danh sách phim (id => tên phim)

        return view('admin.episode.addform', compact('episode', 'list_movie'));
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

        $request->validate([
            'link' => 'required|string|max:2000' 
        ], [
         
            'link.required'     => 'Vui lòng nhập link phim.',
            'link.url'          => 'Link phim không đúng định dạng URL.',
        ]);

        $episode = Episode::findOrFail($id);
        if ($request->has('link')) {
            $episode->link = $request->link;
            $episode->save();
    
            return response()->json(['success' => true, 'message' => 'Cập nhật link tập phim thành công!']);
        }
    
        return response()->json(['success' => false, 'message' => 'Link không được để trống!']);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $episode = Episode::findOrFail($id);
        $episode->delete();
        // toastr()->success('Đã xóa tập phim!', 'Thông báo');
        return back();
    }

    public function deleteAll($movie_id)
    {
        $deleted = Episode::where('movie_id', $movie_id)->delete();

        if ($deleted) {
            toastr()->success('Đã xóa tất cả các tập phim!');
        } else {
            toastr()->info('Không có tập phim nào để xóa.');
        }

        return redirect()->back();
    }

    public function getEpisodes(Request $request)
    {
        $movie = Movie::find($request->movie_id);

        if (!$movie) {
            return response()->json(['error' => 'Phim không tồn tại'], 404);
        }

        $so_tap = $movie->episode;

        $tap_da_co = Episode::where('movie_id', $movie->id)->pluck('episode')->toArray();

        return response()->json([
            'so_tap' => $so_tap,
            'da_co' => $tap_da_co
        ]);
    }
    public function get_episodes_detail(Request $request)
    {
        $movie = Movie::find($request->id);
        $episodes = Episode::with('movie')->where('movie_id', $movie->id)->orderBy('episode')->get();
        
        if (!$episodes) {
            return response()->json(['error' => 'Chưa có tập phim nào!'], 404);
        }
        $output['ep_content_title'] = '<h3>Phim: ' . $movie->title . '</h3>';
        $output['ep_content_detail'] =''; 
        return response()->json($output);
    }
}
