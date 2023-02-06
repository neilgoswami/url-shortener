<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use App\Services\UrlShortenerService;

class UrlController extends Controller
{
    protected $urlShortenerService;

    public function __construct(UrlShortenerService $urlShortenerService)
    {
        $this->urlShortenerService = $urlShortenerService;
    }

    public function index()
    {
        $urls = (new Url)->getAllUrls();

        return view('home', ['urls' => $urls]);
    }

    public function generateShortUrl(Request $request)
    {
        // URL Validation
        $request->validate([
            'url' => ['required', 'url']
        ]);

        // Generate key
        $key = $this->urlShortenerService->generateUniqueKey();

        // Insert into database
        $url = new Url;
        $url->key = $key;
        $url->original_url = $request->url;
        $url->save();

        return redirect('/');
    }

    public function getOriginalUrl(Request $request)
    {
        $originalUrl = (new Url)->getOriginalUrlByKey($request->key);

        return response()->json(['original_url' => $originalUrl]);
    }
}
