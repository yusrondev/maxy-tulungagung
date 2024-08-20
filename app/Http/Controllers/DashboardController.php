<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $room = Room::count();
        $pending = Message::where('status', 0)->count();
        return view('admin.dashboard', ['pending' => $pending, 'room' => $room]);
    }
}
