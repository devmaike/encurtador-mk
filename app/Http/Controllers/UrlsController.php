<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUrlRequest;
use App\Models\Urls;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UrlsController extends Controller
{
    /**
     * Store a new URL.
     */
    public function store(StoreUrlRequest $request): \Illuminate\Http\JsonResponse
    {
        $original_url = $request->input('url_original');
        $expiration_date = $request->input('data_expiracao');
        $short_custom = $request->input('apelido');
        $url = $this->createUrl($original_url, $short_custom, $expiration_date, $request->ip());

        return response()->json([
            'short_url' => config('app.url') . '/' . $url->short_url,
            'expires_at' => $url->expiration_date ? $url->expiration_date : null,
        ], 201);
    }

    /**
     * Update URL visits.
     */
    public function updateVisits(Urls $url): void
    {
        $user_agent = request()->header('User-Agent');
        $user_ip = request()->ip();

        if (!$this->hasVisitedToday($url, $user_ip, $user_agent)) {
            $url->visits()->create([
                'user_ip' => $user_ip,
                'user_agent' => $user_agent,
            ]);

            $url->visits++;
            $url->save();
        }
    }

    /**
     * Get URL by short URL.
     */
    public function getUrl($short_url)
    {
        $url = $this->getUrlByShortUrl($short_url);
        if (!$url) {
            return redirect()->route('home')->with('error', 'Link não encontrado');
        } elseif (
            Carbon::parse($url->expires_at)
            && Carbon::parse($url->expires_at) < today()->format('Y-m-d')
        ) {
            $this->destroy($url);
            return redirect()->route('home')->with('error', 'Link expirado');
        }

        $this->updateVisits($url);

        return redirect(base64_decode($url->original_url));
    }

    /**
     * Get URL Status
     */
    public function getUrlStatus($short_url)
    {
        $url = $this->getUrlByShortUrl($short_url);
        if (!$url) {
            return redirect()->route('home')->with('error', 'Link não encontrado');
        } elseif (
            Carbon::parse($url->expires_at)
            && Carbon::parse($url->expires_at) < today()->format('Y-m-d')
        ) {
            $this->destroy($url);
            return redirect()->route('home')->with('error', 'Link expirado');
        }

        return view('status', [
            'url' => $url,
        ]);
    }

    /**
     * Create a new URL.
     */
    private function createUrl($original_url, $short_custom = null, $expiration_date = null, $user_ip): Urls
    {
        return Urls::create([
            'original_url' => base64_encode($original_url),
            'short_url' => $short_custom ? $short_custom : $this->generateShortUrl(),
            'user_ip' => $user_ip,
            'expires_at' => $expiration_date ? Carbon::parse($expiration_date)->format('d/m/Y') : null,
        ]);
    }

    /**
     * Generate a short URL.
     */
    private function generateShortUrl($length = 5): string
    {
        do {
            $short_url = Str::random($length);
        } while (Urls::where('short_url', $short_url)->exists());

        return $short_url;
    }

    /**
     * Check if the URL has been visited today by a specific IP and User-Agent.
     */
    private function hasVisitedToday(Urls $url, $user_ip, $user_agent): bool
    {
        return $url->visits()
            ->where('user_ip', $user_ip)
            ->where('user_agent', $user_agent)
            ->whereDate('created_at', today())
            ->exists();
    }

    /**
     * Get URL by short URL.
     */
    private function getUrlByShortUrl($short_url): ?Urls
    {
        return Urls::where('short_url', $short_url)->first();
    }

    /**
     * Destroy URL.
     */
    public function destroy(Urls $url): \Illuminate\Http\JsonResponse
    {
        $url->visits()->delete();
        $url->delete();

        return response()->json(['message' => 'Link deletado com sucesso'], 200);
    }

    /**
     * Show URL.
     */
    public function show($code): \Illuminate\Http\JsonResponse
    {
        $url = Urls::where('short_url', $code)->firstOrFail();
        return response()->json([
            'url_encurtada' => config('app.url') . '/' . $url->short_url,
            'expira_em' => $url->expires_at ? $url->expires_at : null,
            'visitas' => $url->visits,
        ], 200);
    }
}
