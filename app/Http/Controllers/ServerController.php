<?php

namespace App\Http\Controllers;

use App\Models\Server;
use Illuminate\Http\Request;

class ServerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Server::all();
        return view('admin.server.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
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
            'name' => 'required|string|max:255',
 
        ], [
            'name.required' => 'Tên server không được để trống!',

        ]);
        $data = $request->all();
        $server = new Server();
        $server->name = $data['name'];
       
        $server->save();
        toastr()->success('Thêm server thành công !','Thông báo');
        return redirect()->route('server.index');
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
        $server = Server::findOrFail($id);

        if (in_array($server->name, ['embed', 'm3u8'])) {
            toastr()->warning('Không thể sửa server mặc định (embed hoặc m3u8)!', 'Cảnh báo');
            return redirect()->route('server.index');
        }
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Tên server không được để trống!',
        ]);
    
        $server->name = $request->input('name');
        $server->save();
    
        toastr()->success('Đã cập nhật server!', 'Thông báo');
        return redirect()->route('server.index');
    }
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $server = Server::find($id);
        if (in_array($server->name, ['embed', 'm3u8'])) {
            toastr()->warning('Không thể xóa server mặc định (embed hoặc m3u8)!');
            return redirect()->back();
        }
        if($server->episodes->isEmpty())
        {
            $server->delete();
            return redirect()->route('server.index')->with('success', 'Đã xoá server.');
        }
        else
        {
            return redirect()->route('server.index')->with('error','Không thể xóa server, vẫn còn tập phim tồn tại!');
        }
    }
}
