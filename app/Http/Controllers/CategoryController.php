<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Category::orderBy('position','ASC')->get();
        return view('admin.category.form',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.addform');
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
            'slug' => 'required|string|max:255|unique:categories,slug',  
            'description' => 'required|string|max:255',  
            'status' => 'required|in:0,1',  
        ], [
            'title.required' => 'Tiêu đề không được để trống!',
            'slug.required' => 'Slug không được để trống!',
            'slug.unique' => 'Slug đã tồn tại, vui lòng chọn một slug khác!',
            'description.required' => 'Mô tả không được để trống!',
        ]);
    
        // Nếu validate thành công, tiếp tục với việc lưu danh mục
        $data = $request->all();
        $category = new Category();
        $category->title = $data['title'];
        $category->slug = $data['slug'];
        $category->description = $data['description'];
        $category->status = $data['status'];
        
        $category->save();
    
        toastr()->success('Thêm danh mục thành công !','Thông báo');
        return redirect()->route('category.index');
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
        $category = Category::find($id);
        return view('admin.category.addform',compact('category'));

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
            'slug' => 'required|string|max:255|unique:categories,slug,' . $id, 
            'description' => 'required|string|max:255',  
            'status' => 'required|in:0,1',  
        ], [
            'title.required' => 'Tiêu đề không được để trống!',
            'slug.required' => 'Slug không được để trống!',
            'slug.unique' => 'Slug đã tồn tại, vui lòng chọn một slug khác!',
            'description.required' => 'Mô tả không được để trống!',
        ]);
    
        // Nếu validate thành công, tiếp tục với việc cập nhật danh mục
        $data = $request->all();
        $category = Category::find($id);
        $category->title = $data['title'];
        $category->slug = $data['slug'];
        $category->description = $data['description'];
        $category->status = $data['status'];
        $category->save();
    
        toastr()->success('Đã cập nhật danh mục !','Thông báo');
        return redirect()->route('category.index');
        
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
        Category::find($id)->delete();
        toastr()->success('Đã xóa danh mục !','Thông báo');
        return back();
    }
    public function resorting(Request $request)
    {
        $data = $request->all();
        foreach($data['array_id'] as $key => $value){
            $category = Category::find($value);
            $category->position = $key;
            $category->save();

        } 
      
    }
}
