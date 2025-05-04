<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Country::all();
        return view('admin.country.form',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.country.addform');
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
            'slug' => 'required|string|max:255|unique:countries,slug',
            'description' => 'required|string|max:255',
       
        ], [
            'title.required' => 'Tên quốc gia không được để trống!',
            'slug.required' => 'Slug không được để trống!',
            'slug.unique' => 'Slug đã tồn tại!',
            'description.required' => 'Mô tả không được để trống!',
           
        ]);
        $data = $request->all();
        $country = new Country();
        $country->title = $data['title'];
        $country->slug = $data['slug'];
        $country->description = $data['description'];
        $country->status = $data['status'];
        $country->save();
        toastr()->success('Thêm quốc gia thành công !','Thông báo');
        return redirect()->route('country.index');
 
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
        $country = Country::find($id);
        return view('admin.country.addform',compact('country'));
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
            'slug' => 'required|string|max:255|unique:countries,slug,' . $id,
            'description' => 'required|string|max:255',
       
        ], [
            'title.required' => 'Tên quốc gia không được để trống!',
            'slug.required' => 'Slug không được để trống!',
            'slug.unique' => 'Slug đã tồn tại!',
            'description.required' => 'Mô tả không được để trống!',
           
        ]);
        $data = $request->all();
        $country = Country::find($id);
        $country->title = $data['title'];
        $country->slug = $data['slug'];
        $country->description = $data['description'];
        $country->status = $data['status'];
        $country->save();
        toastr()->success('Đã cập nhật quốc gia !','Thông báo');
        return redirect()->route('country.index');
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
        Country::find($id)->delete();
        toastr()->success('Đã xóa quốc gia !','Thông báo');
        return back();
    }
    public function resorting(Request $request)
    {
        $data = $request->all();
        foreach($data['array_id'] as $key => $value){
            $country = Country::find($value);
            $country->position = $key;
            $country->save();

        } 
      
    }
}
