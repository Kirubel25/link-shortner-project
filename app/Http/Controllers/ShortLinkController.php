<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Illuminate\Http\Request;

class ShortLinkController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function store(Request $request)
    {
        $request->validate([
            'original_url' => 'required|url',
        ]);

        $shortCode = substr(md5(uniqid()), 0, 6);

        ShortLink::create([
            'original_url' => $request->original_url,
            'short_code' => $shortCode,
        ]);

        return back()->with('success', url('/s/' . $shortCode));
    }

    public function redirect($code)
    {
        $link = ShortLink::where('short_code', $code)->firstOrFail();
        $link->increment('clicks');
        return redirect($link->original_url);
    }

}
