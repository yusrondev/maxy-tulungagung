<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;
use App\Events\PusherBroadcast;
use App\Models\Message;
use App\Models\Reply;

class RoomController extends Controller
{
    public function index()
    {
        $room = Room::orderBy('id','DESC')->get();
        return view('admin/room/index', compact('room'));
    }

    public function store(Request $request)
    {
        $model = new Room();
        $model->code = $request->code;
        $model->save();
        return redirect('room');
    }

    public function replychat(Request $request)
    {
        $model = new Reply();
        $model->message_id = $request->id_msg;
        $model->text = $request->text;
        $model->save();

        Message::where('id', $request->id_msg)->update([
            'status' => 1
        ]);

        return response()->json([
            'rc' => 200,
            'msg' => 'success'
        ]);
    }

    public function update(Request $request, $id)
    {
        Room::where('id', $id)->update([
            'code' => $request->code
        ]);
        return redirect('room');
    }

    public function delete($id)
    {
        Room::where('id', $id)->delete();
        return redirect('room');
    }

    public function enterName()
    {
        return view('name');
    }

    public function setName(Request $request)
    {
        $request->session()->put('user_name', $request->input('name'));
        return redirect('/chat_room');
    }

    public function ChatRoom()
    {
        return view('chat');
    }

    public function broadcast(Request $request)
    {
        $message = $request->get('message');
        $isOwnMessage = $request->get('isOwnMessage');
        $name = $request->get('name');

        broadcast(new PusherBroadcast($message, $isOwnMessage, $name))->toOthers();

        return view('broadcast', [
            'message' => $message,
            'isOwnMessage' => $isOwnMessage,
            'name' => $name
        ]);
    }

    public function receive(Request $request)
    {
        return view('receive', [
            'message' => $request->get('message'),
            'isOwnMessage' => $request->get('isOwnMessage'),
            'name' => $request->get('name')
        ]);
    }

    public function roomchat($code)
    {
        $room = Room::where('code', $code)->first();
        $model = Message::with('reply')->where('room_id', $room->id)->where('status', 1)->get();

        return view('admin/room/chat', [
            'model' => $model,
            'room' => $room
        ]);
    }

    public function pendingchat(Request $request, $id)
    {
        $model = Message::where('room_id', $id)->where('status', 0)->get();
        if ($request->ajax()) {
            return $model;
        }

        return view('admin/room/pending-chat', [
            'model' => $model,
            'id' => $id
        ]);
    }

    public function approvechat($id)
    {
        $model = Message::where('id', $id)->update([
            'status' => 1
        ]);

        return redirect()->back();
    }

    public function deletechat($id)
    {
        $chat = Message::where('id', $id);
        $chat->delete();

        return redirect()->back()->with('success', 'Chat deleted successfully.');
    }
}
