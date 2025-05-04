<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Server;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;



use Intervention\Image\Facades\Image;

class LeechMovieController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $page = $request->get('start') / $request->get('length') + 1;
            $response = Http::get("https://ophim1.com/danh-sach/phim-moi-cap-nhat", [
                'page' => $page
            ])->json();

            $data = $response['items'] ?? [];
            $pathImage = $response['pathImage'] ?? '';
            $total = $response['pagination']['totalItems'] ?? 0;

            $data = array_map(function ($item) use ($pathImage) {
                $item['full_thumb_url'] = $pathImage . $item['thumb_url'];
                return $item;
            }, $data);



            return response()->json([
                'data' => $data,
                'recordsTotal' => $total,
                'recordsFiltered' => $total,
            ]);
        }

        return view('admin.leech.index');
    }

    // show detail
    public function show(Request $request)
    {
        $slug = $request->slug;

        $resp = Http::get('https://ophim1.com/phim/' . $slug)->json();
        $resp_array[] = $resp['movie'];


        $output['content_title'] = '<h3>' . $resp['movie']['name'] . '</h3>';


        $output['content_detail'] = '
            <div class="row">
                <div class="col-md-5"><img src="' . $resp['movie']['thumb_url'] . '" width="100%"></div>
                <div class="col-md-7">
                    <h4><b>Tên phim :</b>' . $resp['movie']['name'] . '</h4>
                    <p><b>Tên tiếng anh:</b>' . $resp['movie']['origin_name'] . '</p>
                    <p><b>Trạng thái :</b> ' . $resp['movie']['episode_current'] . '</p>
                    <p><b>Số tập :</b> ' . $resp['movie']['episode_total'] . '</p>
                    <p><b>Thời lượng : </b>' . $resp['movie']['time'] . '</p>
                    <p><b>Năm phát hành : </b>' . $resp['movie']['year'] . '</p>
                    <p><b>Chất lượng : </b>' . $resp['movie']['quality'] . '</p>
                    <p><b>Ngôn ngữ : </b>' . $resp['movie']['lang'] . '</p>';
        foreach ($resp['movie']['director'] as $dir) {
            $output['content_detail'] .= '<b>Đạo diễn:</b> <span class="badge badge-pill badge-info">' . $dir . '</span>';
        }
        $output['content_detail'] .= '<br/><b>Thể loại :</b>';

        foreach ($resp['movie']['category'] as $cate) {
            $output['content_detail'] .= '
                        <span class="badge badge-pill badge-info">' . $cate['name'] . '</span>';
        }
        $output['content_detail'] .= '<br/><b>Diễn viên :</b>';
        foreach ($resp['movie']['actor'] as $act) {
            $output['content_detail'] .= '
                        <span class="badge badge-pill badge-info">' . $act . '</span>';
        }
        $output['content_detail'] .= '<br/><b>Quốc gia :</b>';
        foreach ($resp['movie']['country'] as $country) {
            $output['content_detail'] .= '
                        <span class="badge badge-pill badge-info">' . $country['name'] . '</span>';
        }
        $output['content_detail'] .= '

                </div>
            </div>
        ';

        return response()->json($output);
    }



    // down anh

    public function downloadImage($url)
    {
        if (!$url) return null;

        try {
            $image = Image::make($url)->resize(600, 900);

            $filename = Str::random(10) . '.jpg';
            $path = public_path('uploads/movies/');

            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            $image->save($path . $filename);

            return $filename;
        } catch (\Exception $e) {
            \Log::error('Lỗi khi tải ảnh: ' . $e->getMessage());
            return null;
        }
    }



    // import movie
    public function import(Request $request, $slug)
    {
        $resp = Http::get('https://ophim1.com/phim/' . $slug);

        if ($resp->failed()) {
            toastr()->error('Không thể lấy dữ liệu từ API!');
            return back();
        }

        $item = $resp->json()['movie'];

        // episode_current
        preg_match('/\d+/', $item['episode_current'] ?? '', $matches);
        $episode = isset($matches[0]) ? (int)$matches[0] : 1;

        if (Movie::where('slug', $item['slug'])->exists()) {
            toastr()->info('Phim đã tồn tại!');
            return back();
        }

        Movie::create([
            'title' => $item['name'],
            'slug' => $item['slug'],
            'name_eng' => $item['origin_name'],
            'description' => $item['content'] ?? 'Đang cập nhật',
            'episode' => $episode,
            'trailer' => $item['trailer_url'] ?? '',
            'duration' => $item['time'] ?? '',
            'category_id' => 1,
            'country_id' => 1,
            'image' => $this->downloadImage($item['thumb_url']),
            'isHot' => 0,
            'resolution' => 1,
            'season' => 'Đang cập nhật',
            'subtitle' => 0,
            'year' => $item['year'] ?? '2025',
            'status' =>  0,
            'leech_index' => 1
        ]);

        toastr()->success('Thêm phim từ API thành công!');
        return redirect()->back();
    }

    // list_import
    public function list_import()
    {
        $list_import = Movie::where('leech_index', 1)->get();
        return view('admin.leech.list_import', compact('list_import'));
    }

    // leech_ep
    public function leech_episodes(Request $request, $slug)
    {

        $resp = Http::get('https://ophim1.com/phim/' . $slug);

        if ($resp->failed()) {
            toastr()->error('Không thể lấy dữ liệu từ API!');
            return back();
        }

        $item = $resp->json()['episodes'];
        $movie_id = Movie::where('slug', $slug)->value('id');

        return view('admin.leech.leech_episode', compact('item','movie_id'));
    }

    // store leech_ep
    public function storeLeechEpisodes(Request $request)
{
    if (!$request->has('movie_id')) {
        toastr()->error('Không có movie_id!');
        return back();
    }

    $movie_id = $request->movie_id;

    $server_embed = Server::where('name', 'embed')->first();
    $server_m3u8 = Server::where('name', 'm3u8')->first();

    if (!$server_embed || !$server_m3u8) {
        toastr()->error('Không tìm thấy server embed hoặc m3u8!');
        return back();
    }

    foreach ($request->episodes as $ep) {
        if (!isset($ep['selected']) || $ep['selected'] != 'on') {
            continue;
        }

        $episodeNumber = $ep['episode'] ?? 1;

        // Thêm link_embed
        if (!empty($ep['link_embed'])) {
            $exists = Episode::where('movie_id', $movie_id)
                ->where('episode', $episodeNumber)
                ->where('server_id', $server_embed->id)
                ->exists();

            if (!$exists) {
                Episode::create([
                    'movie_id' => $movie_id,
                    'server_id' => $server_embed->id,
                    'link' => $ep['link_embed'],
                    'episode' => $episodeNumber,
                ]);
            }
        }

        // Thêm link_m3u8 
        if (!empty($ep['link_m3u8'])) {
            $exists = Episode::where('movie_id', $movie_id)
                ->where('episode', $episodeNumber)
                ->where('server_id', $server_m3u8->id)
                ->exists();

            if (!$exists) {
                Episode::create([
                    'movie_id' => $movie_id,
                    'server_id' => $server_m3u8->id,
                    'link' => $ep['link_m3u8'],
                    'episode' => $episodeNumber,
                ]);
            }
        }
    }

    toastr()->success('Đã thêm các tập phim chưa tồn tại!');
    return redirect()->back();
}


    


}
