<?php

namespace App\Http\Controllers;

use App\Models\Chat_content;
use App\Models\Cms;
use App\Models\Message;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function getmsg(Request $request)
    {
        $model = Message::with('reply')->where('room_id', $request->id)->where('status', 1)->get();

        return $model;
    }

    public function sendmsg(Request $request)
    {
        $message = new Message;
        $message->room_id = $request->room_id;
        $message->name = $request->name;
        $message->text = $request->msg;

        if (!empty($request->file('file'))) {
            $request->validate([
                'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);
    
            $file = $request->file('file');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $message->image = 'uploads/' . $filename;
        }
        
        $message->save();

        return response()->json([
            'name' => $request->name,
            'msg' => $request->msg
        ]);
    }

    public function sendFile(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $file = $request->file('file');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $filename);

        $message = new Message;
        $message->room_id = $request->room_id;
        $message->name = $request->name;
        $message->text = null;
        $message->image = 'uploads/' . $filename;
        $message->save();

        return response()->json(['success' => true]);
    }

    public function getcms()
    {
        $dynamic_cms = Cms::orderBy('id', 'DESC')->first();
        $dynamic_content = Chat_content::orderBy('id', 'DESC')->first();

        return response()->json([
            'dynamic_cms' => $dynamic_cms,
            'dynamic_content' => $dynamic_content
        ]);
    }

}
