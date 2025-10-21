<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // Display admin dashboard with user and listing counts
    public function index()
    {
        $usersCount = User::count(); 
        $listingsCount = Listing::count();
        return view('admin.dashboard', compact('usersCount', 'listingsCount'));
    }
}
