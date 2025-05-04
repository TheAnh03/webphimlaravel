<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Episode;
use Dotenv\Store\File\Paths;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Image; 


class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::pluck('title','id');
        $genre = Genre::pluck('title','id');
        $country = Country::pluck('title','id');
        $list = Movie::with('category','movie_genre','country','views')->orderBy('id','DESC')->get();

        $path = public_path()."/json/";
        if(!is_dir($path)) {
            mkdir($path,0777,true);
        }
        File::put($path.'movie.json',json_encode($list));
        return view('admin.movie.form',compact('list','category','genre','country'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::pluck('title','id');
        $genre = Genre::pluck('title','id');
        $country = Country::pluck('title','id');
        $list_genre = Genre::all();
        $movie = null;
        return view('admin.movie.addform',compact('category','genre','country','movie','list_genre'));
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
            'title' => 'required|string|max:255',
            'name_eng' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:movies,slug',
            'description' => 'required|string|max:2500',
            'duration' => 'required|string|max:255',
            'episode' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'country_id' => 'required|exists:countries,id',
            'resolution' => 'required|integer',
            'season' => 'nullable|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'genre' => 'required|array|min:1',
            'genre.*' => 'exists:genres,id',
            'image' => ($request->isMethod('post') ? 'required' : 'nullable') . '|image|mimes:jpeg,png,jpg,gif|max:10240',
        ], [
            'title.required' => 'Tiêu đề không được để trống!',
            'name_eng.required' => 'Tên tiếng anh không được để trống!',
            'slug.required' => 'Slug không được để trống!',
            'slug.unique' => 'Slug đã tồn tại!',
            'description.required' => 'Mô tả không được để trống!',
            'duration.required' => 'Thời lượng không được để trống!',
            'episode.required' => 'Số tập không được để trống!',
            'category_id.required' => 'Danh mục bắt buộc!',
            'country_id.required' => 'Quốc gia bắt buộc!',
            'resolution.required' => 'Độ phân giải bắt buộc!',
         
            'year.required' => 'Năm phát hành không được để trống!',
            'genre.required' => 'Chọn ít nhất 1 thể loại!',
            'image.required' => 'Ảnh phim là bắt buộc khi thêm mới!',
            'image.image' => 'Tệp tải lên phải là ảnh!',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif!',
            'image.max' => 'Ảnh không được vượt quá 2MB!',
        ]);
        $data = $request->all();
        $movie = new Movie();
        $movie->title = $data['title'];
        $movie->name_eng = $data['name_eng'];
        $movie->slug = $data['slug'];
        $movie->description = $data['description'];
        $movie->tags = $data['tags'];
        $movie->duration = $data['duration'];
        $movie->episode = $data['episode'];
        $movie->category_id = $data['category_id'];
        $movie->country_id = $data['country_id'];
        $movie->status = $data['status'];
        $movie->isHot = $data['isHot'];
        $movie->resolution = $data['resolution'];
        $movie->subtitle = $data['subtitle'];
        $movie->season = $data['season'];
        $movie->year = $data['year'];
        $movie->trailer = $data['trailer'];

        // them anh
        $get_image = $request->file('image');

        
        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();

            // Resize ảnh và lưu lại bằng Intervention Image
            $image_resize = Image::make($get_image)->resize(600, 900)->encode($get_image->getClientOriginalExtension());
            $image_resize->save(public_path('uploads/movies/' . $new_image));

            // Gán tên ảnh cho model
            $movie->image = $new_image;
        }

        $movie->save();
        $movie->movie_genre()->attach($data['genre']);
        toastr()->success('Thêm phim thành công!', 'Thông báo');

        return redirect()->route('movie.index');
        
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
        $category = Category::pluck('title','id');
        $genre = Genre::pluck('title','id');
        $country = Country::pluck('title','id');
        $list_genre = Genre::all();
       
        $movie = Movie::find($id);
        $movie_genre = $movie->movie_genre;
        return view('admin.movie.addform',compact('movie','category','genre','country','list_genre','movie_genre'));
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
        $movie = Movie::find($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'name_eng' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('movies', 'slug')->ignore($id)],
            'description' => 'required|string|max:2500',
            'duration' => 'required|string|max:255',
            'episode' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
            'country_id' => 'required|exists:countries,id',
            'resolution' => 'required|integer',
            'season' => 'nullable|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'genre' => 'required|array|min:1',
            'genre.*' => 'exists:genres,id',
            'image' => ($request->isMethod('post') ? 'required' : 'nullable') . '|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'Tiêu đề không được để trống!',
            'name_eng.required' => 'Tên tiếng anh không được để trống!',
            'slug.required' => 'Slug không được để trống!',
            'slug.unique' => 'Slug đã tồn tại!',
            'description.required' => 'Mô tả không được để trống!',
            'duration.required' => 'Thời lượng không được để trống!',
            'episode.required' => 'Số tập không được để trống!',
            'category_id.required' => 'Danh mục bắt buộc!',
            'country_id.required' => 'Quốc gia bắt buộc!',
            'resolution.required' => 'Độ phân giải bắt buộc!',
            
            'year.required' => 'Năm phát hành không được để trống!',
            'genre.required' => 'Chọn ít nhất 1 thể loại!',
            'image.required' => 'Ảnh phim là bắt buộc khi thêm mới!',
            'image.image' => 'Tệp tải lên phải là ảnh!',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif!',
            'image.max' => 'Ảnh không được vượt quá 2MB!',
        ]);
        $data = $request->all();
        
        $movie->title = $data['title'];
        $movie->name_eng = $data['name_eng'];
        $movie->slug = $data['slug'];
        $movie->description = $data['description'];
        $movie->tags = $data['tags'];
        $movie->duration = $data['duration'];
        $movie->episode = $data['episode'];
        $movie->category_id = $data['category_id'];
        
        $movie->country_id = $data['country_id'];
        $movie->status = $data['status'];
        $movie->isHot = $data['isHot'];
        $movie->resolution = $data['resolution'];
        $movie->subtitle = $data['subtitle'];
        $movie->season = $data['season'];
        $movie->year = $data['year'];
        $movie->trailer = $data['trailer'];
     
      
        $movie->movie_genre()->sync($data['genre']);
        

        // sua anh
        if ($request->hasFile('image')) {
            $get_image = $request->file('image');
        
            // Xoá ảnh cũ nếu có
            if (!empty($movie->image) && file_exists('uploads/movies/' . $movie->image)) {
                unlink('uploads/movies/' . $movie->image);
            }
        
            // Tạo tên file mới và lưu
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
            Image::make($get_image)->resize(600, 900)->save(public_path('uploads/movies/' . $new_image));

        
            $movie->image = $new_image;
        }

        $movie->save();
        toastr()->success('Đã cập nhật phim!', 'Thông báo');
        return redirect()->route('movie.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $movie = Movie::find($id);

        // Xoá ảnh
        if (!empty($movie->image) && file_exists('uploads/movies/' . $movie->image)) {
            unlink('uploads/movies/' . $movie->image);
        }
    
        // Xoá quan hệ thể loại
        $movie->movie_genre()->detach();
    
        // Xoá record phim
        $movie->delete();
        toastr()->success('Đã xóa phim !','Thông báo');
    
        return redirect()->back();
    }

    public function get_movie_detail(Request $request)
    {
        // $movie = Movie::where('slug', $request->slug)
        //             ->with(['category', 'genre', 'country'])
        //             ->first();
        $movie = Movie::with('category', 'movie_genre', 'country')->where('slug', $request->slug)->firstOrFail();
        
        $resolution_text = match($movie->resolution) {
            1 => 'Full HD',
            2 => 'HD',
            3 => 'CAM',
            default => 'Đang cập nhật',
        };
        $ishot_text = match($movie->isHot) {
            1 => 'Có',
            0 => 'Không',
        
        };
        $status_text = match($movie->status) {
            1 => 'Đã hoàn tất', 
            0 => 'Sắp chiếu',
       
        };

        if (!$movie) {
            return response()->json(['error' => 'Không tìm thấy phim'], 404);
        }

        $output['content_title'] = '<h3>' . $movie->title . '</h3>';
        
        $output['content_detail'] = '
            <div class="row">
                <div class="col-md-5">
                    <img src="' . asset('uploads/movies/' . $movie->image) . '" width="100%">
                </div>
                <div class="col-md-7">
                    <p><b>Tên tiếng anh:</b> ' . $movie->name_eng . '</p>
                    <p><b>Mô tả:</b> ' . $movie->description . '</p>
                    <p><b>Số tập:</b> ' . $movie->episode . '</p>
                    <p><b>Thời lượng:</b> ' . $movie->duration . '</p>
                    <p><b>Chất lượng:</b> ' . $resolution_text . '</p>
                    <p><b>Năm phát hành:</b> ' . $movie->year . '</p>
                    <p><b>Mùa phim:</b> ' . $movie->season . '</p>
                   
                    <p><b>Danh mục:</b> ' . $movie->category->title . '</p>
                    <p><b>Thể loại:</b> '; 
                    foreach ($movie->movie_genre as $item) {
                        $output['content_detail'] .= '<span class="badge badge-dark">' . $item->title . '</span> ';
                    }
                    
                    $output['content_detail'] .= '</p>
                    <p><b>Quốc gia:</b> ' . $movie->country->title . '</p>
                    <p><b>Ngày thêm:</b> ' . $movie->created_at . '</p>
                    <p><b>Ngày cập nhật:</b> ' . $movie->updated_at . '</p>
                    <p><b>Đề xuất:</b> ' . $ishot_text . '</p>
                    <p><b>Trạng thái:</b> ' . $status_text . '</p>

                    
                </div>
            </div>
        ';

        return response()->json($output);
    }

    
}
