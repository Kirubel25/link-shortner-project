<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $links = ShortLink::latest()->get();
        return view('admin.dashboard', compact('links'));
    }

    public function destroy($id)
    {
        ShortLink::findOrFail($id)->delete();
        return back()->with('success', 'Link deleted');
    }
}
