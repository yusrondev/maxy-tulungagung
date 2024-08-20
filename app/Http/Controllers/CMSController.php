<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cms;
use App\Models\User;
use App\Models\Chat_content;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CMSController extends Controller
{
    public function index(){

        $data = DB::table('cms')->first();
        $data_chat = DB::table('chat_contents')->first();

        return view('admin.cms', ['data' => $data, 'data_chat' => $data_chat]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'website_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'primary_color' => 'required|string|size:7',
            'secondary_color' => 'required|string|size:7',
        ]);

        $cms = Cms::findOrFail($id);

        $cms->website_name = $request->input('website_name');
        $cms->primary_color = $request->input('primary_color');
        $cms->secondary_color = $request->input('secondary_color');

        if ($request->hasFile('logo')) {
            if ($cms->logo && file_exists(public_path('/assets/image_content/'.$cms->logo))) {
                unlink(public_path('/assets/image_content/'.$cms->logo));
            }

            $logo = $request->file('logo');
            $logoName = time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('/assets/image_content'), $logoName);
            $cms->logo = $logoName;
        }

        if ($request->hasFile('image')) {
            if ($cms->image && file_exists(public_path('/assets/image_content/'.$cms->image))) {
                unlink(public_path('/assets/image_content/'.$cms->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('/assets/image_content'), $imageName);
            $cms->image = $imageName;
        }

        $cms->save();

        return response()->json(['message' => 'Data updated successfully!']);
    }

    public function chatContent_update(Request $request, $id)
    {
        $request->validate([
            'username_font' => 'required|string|max:255',
            'chat_font' => 'required|string|max:255',
            'username_color' => 'required|string|max:255',
            'chat_color' => 'required|string|max:255',
            'chat_sizeName' => 'required|string',
            'chat_size' => 'required|string',
        ]);

        $cms = Chat_content::findOrFail($id);

        $cms->username_font = $request->input('username_font');
        $cms->chat_font = $request->input('chat_font');
        $cms->username_color = $request->input('username_color');
        $cms->chat_color = $request->input('chat_color');
        $cms->chat_sizeName = $request->input('chat_sizeName');
        $cms->chat_size = $request->input('chat_size');

        $cms->save();

        return response()->json(['message' => 'Data updated successfully!']);
    }

    public function setting(){

        $data = DB::table('cms')
        ->get();

        return view('admin.setting', ['data' => $data]);
    }

    public function getUsers()
    {
        $users = DB::table('users')->where('id', '!=', 1)->get();
        return response()->json(['data' => $users]);
    }

    public function store(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Simpan data pengguna
        $userId = DB::table('users')->insertGetId([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'userId' => $userId]);
    }

    public function updateUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::find($id);

        if ($user) {
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            return response()->json(['success' => 'User updated successfully']);
        }

        return response()->json(['error' => 'User not found'], 404);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if ($user) {
            $user->delete();
            return response()->json(['success' => 'User deleted successfully']);
        }

        return response()->json(['error' => 'User not found'], 404);
    }

    public function image_destroy($id)
    {
        // Temukan model berdasarkan ID
        $data = CMS::find($id);

        if ($data && $data->image) {
            // Hapus file gambar dari storage
            $imagePath = public_path('/assets/image_content/' . $data->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            
            // Set field image menjadi null di database
            $data->image = null;
            $data->save();
        }

        // Kembalikan response JSON untuk AJAX
        return response()->json(['success' => 'Image deleted successfully']);
    }

}
