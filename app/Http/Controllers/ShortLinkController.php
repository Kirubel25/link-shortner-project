<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShortLinkRequest;
use App\Models\ShortLink;
use App\Services\ShortLinkService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ShortLinkController extends Controller
{
    protected ShortLinkService $shortLinkService;

    public function __construct(ShortLinkService $shortLinkService)
    {
        $this->shortLinkService = $shortLinkService;
    }

    public function index()
    {
        $userLinks = null;

        if (Auth::check()) {
            // Fetch user’s links if logged in
            $userLinks = Auth::user()->shortLinks()->latest()->get(); 
            // dd($userLinks);
        }

        return view('home', compact('userLinks'));
    }

    public function store(StoreShortLinkRequest $request): RedirectResponse
    {
        $userId = auth()->id();
        // dd($userId);
        $link = $this->shortLinkService->findOrCreate($request->input('original_url'), $userId);

        return back()->with('success', url('/s/' . $link->short_code));
    }

    public function redirect(string $code): RedirectResponse
    {
        $link = $this->shortLinkService->getByCode($code);

        $this->shortLinkService->incrementClicks($link);

        return redirect()->to($link->original_url);
    }

    public function destroy($id)
    {
        $link = ShortLink::findOrFail($id);

        if ($link->user_id !== auth()->id()) {
            abort(403, 'You are not authorized to delete this link.');
        }

        $link->delete();

        return redirect()->back()->with('success', 'Link deleted successfully.');
    }
}
