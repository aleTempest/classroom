<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Career;
use App\Models\Teacher;
use App\Models\Room;

class AdminDashboardController extends Controller
{
    public function index() 
    {
        return view('admin-dashboard', [
            'careersCount' => Career::count(),
            'teachersCount' => Teacher::count(),
            'roomsCount' => Room::count(),
        ]);
    }
}
