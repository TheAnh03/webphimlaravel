<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class UserProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user(); // Lấy thông tin người dùng hiện tại
        return view('admin.profile.index', compact('user'));
    }
    public function show_userprofile()
    {
        $user = Auth::user(); // Lấy thông tin người dùng hiện tại
        return view('pages.userprofile', compact('user'));
    }
    public function update_userprofile(Request $request)
    {

        $user = Auth::user();
        $validator = Validator::make($request->all(), [
            'password' => 'nullable|string|min:8',  // Mật khẩu có thể để trống
            'fileToUpload' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg', // Ảnh dưới 5MB
        ]);

        if ($validator->fails()) {
            return redirect()->route('show_profile')
                ->withErrors($validator)
                ->withInput();
        }
        // Cập nhật mật khẩu nếu có
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        // Xử lý upload avatar
        if ($request->hasFile('fileToUpload')) {
            $file = $request->file('fileToUpload');

            // Kiểm tra dung lượng file (nếu lớn hơn 5MB thì chọn ảnh mặc định)
            if ($file->getSize() > 5120 * 1024) {  // Dung lượng > 5MB
                $filename = 'avtdefaut.jpeg';  // Ảnh mặc định
            } else {
                // Xóa avatar cũ nếu không phải ảnh mặc định
                if ($user->avatar && $user->avatar != 'avtdefaut.jpeg') {
                    $oldPath = public_path('uploads/logo/' . $user->avatar);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }

                // Lưu avatar mới
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/logo'), $filename);
            }

            $user->avatar = $filename;
        }

        // Lưu thông tin người dùng
        $user->save();

        return redirect()->route('show_profile')->with('success', 'Thông tin đã được cập nhật.');
    }
}
