<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genre;
class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Genre::all();
        return view('admin.genre.form',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.genre.addform');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:genres,slug',
            'description' => 'required|string|max:255',
        ], [
            'title.required' => 'Tên thể loại không được để trống!',
            'slug.required' => 'Slug không được để trống!',
            'slug.unique' => 'Slug đã tồn tại!',
            'description.required' => 'Mô tả không được để trống!',
        ]);
        $data = $request->all();
        $genre = new Genre();
        $genre->title = $data['title'];
        $genre->slug = $data['slug'];
        $genre->description = $data['description'];
        $genre->status = $data['status'];
        $genre->save();
        toastr()->success('Thêm thể loại thành công !','Thông báo');
        return redirect()->route('genre.index');
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
        $genre = Genre::find($id);
        return view('admin.genre.addform',compact('genre'));

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
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:genres,slug,' . $id,
            'description' => 'required|string|max:255',
        ], [
            'title.required' => 'Tên thể loại không được để trống!',
            'slug.required' => 'Slug không được để trống!',
            'slug.unique' => 'Slug đã tồn tại!',
            'description.required' => 'Mô tả không được để trống!',
        ]);
        $data = $request->all();
        $genre = Genre::find($id);
        $genre->title = $data['title'];
        $genre->slug = $data['slug'];
        $genre->description = $data['description'];
        $genre->status = $data['status'];
        $genre->save();
        toastr()->success('Đã cập nhật thể loại !','Thông báo');
        return redirect()->route('genre.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id == 1) {
            toastr()->error('Không thể xóa dòng mặc định này!', 'Lỗi');
            return redirect()->back();
        }  
        Genre::find($id)->delete();
        toastr()->success('Đã xóa thể loại !','Thông báo');
        return back();
    }
    public function resorting(Request $request)
    {
        $data = $request->all();
        foreach($data['array_id'] as $key => $value){
            $genre = Genre::find($value);
            $genre->position = $key;
            $genre->save();

        } 
      
    }
    
}
