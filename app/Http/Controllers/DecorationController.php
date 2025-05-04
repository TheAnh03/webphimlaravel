<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Decoration;

class DecorationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $info = Decoration::find(1);
        
        return view('admin.decoration.index', compact('info'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        // $info = Decoration::find(1);
        // dd($info);
        // return view('admin.decoration.index', compact('info'));
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
            'title' => 'required|string|max:255',  
            
            'description' => 'required|string|max:2000',  
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'title.required' => 'Tiêu đề không được để trống!',
 
            'description.required' => 'Mô tả không được để trống!',
            'image.image' => 'File tải lên phải là hình ảnh!',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg hoặc gif!',
            'image.max' => 'Ảnh không được vượt quá 2MB!'
        ]);
        $data = $request->all();
        $info = Decoration::find($id);
        $info->title = $data['title'];
        $info->description = $data['description'];
        if ($request->hasFile('image')) {
            $get_image = $request->file('image');
        
            // Xoá ảnh cũ nếu có
            if (!empty($info->logo) && file_exists('uploads/logo/' . $info->logo)) {
                unlink('uploads/logo/' . $info->logo);
            }
        
            // Tạo tên file mới và lưu
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image));
            $new_image = $name_image . rand(0, 9999) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('uploads/logo', $new_image);
        
            $info->logo = $new_image;
        }

        $info->save();
        toastr()->success('Cập nhật thành công !','Thông báo');
        return redirect()->route('decoration.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
