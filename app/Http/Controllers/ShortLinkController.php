<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShortLinkRequest;
use App\Services\ShortLinkService;
use Illuminate\Http\RedirectResponse;

class ShortLinkController extends Controller
{
    protected ShortLinkService $shortLinkService;

    public function __construct(ShortLinkService $shortLinkService)
    {
        $this->shortLinkService = $shortLinkService;
    }

    public function index()
    {
        return view('home');
    }

    public function store(StoreShortLinkRequest $request): RedirectResponse
    {
        $link = $this->shortLinkService->findOrCreate($request->input('original_url'));

        return back()->with('success', url('/s/' . $link->short_code));
    }

    public function redirect(string $code): RedirectResponse
    {
        $link = $this->shortLinkService->getByCode($code);

        $this->shortLinkService->incrementClicks($link);

        return redirect()->to($link->original_url);
    }
}
