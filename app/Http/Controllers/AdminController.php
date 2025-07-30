<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function index()
    {
        $links = ShortLink::with('user')->latest()->get();
        $totalLinks = $links->count();
        $totalClicks = $links->sum('clicks');
        $mostClickedLink = $links->sortByDesc('clicks')->first();
        $totalUsers = User::count(); 
    
        return view('admin.dashboard', compact('links', 'totalLinks', 'totalClicks', 'mostClickedLink', 'totalUsers'));
    
    }

    public function destroy($id)
    {
        ShortLink::findOrFail($id)->delete();
        return back()->with('success', 'Link deleted');
    }
}
