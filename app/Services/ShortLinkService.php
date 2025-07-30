<?php

namespace App\Services;

use App\Models\ShortLink;

class ShortLinkService
{
    public function findOrCreate(string $originalUrl, ?int $userId = null): ShortLink
    {
        if ($userId != null) {
            $existing = ShortLink::where(['original_url' => $originalUrl, 'user_id' => $userId])->first();
        }else {
            $existing = ShortLink::where(['original_url' => $originalUrl, 'user_id' => null])->first();
        }

        if ($existing) {
            return $existing;
        }

        // dd($userId);

        return ShortLink::create([
            'original_url' => $originalUrl,
            'short_code' => $this->generateUniqueCode(),
            'user_id' => $userId,
        ]);
    }

    public function getByCode(string $code): ShortLink
    {
        return ShortLink::where('short_code', $code)->firstOrFail();
    }

    public function incrementClicks(ShortLink $link): void
    {
        $link->increment('clicks');
    }

    private function generateUniqueCode(): string
    {
        do {
            $code = substr(md5(uniqid()), 6, 6);
        } while (ShortLink::where('short_code', $code)->exists());

        return $code;
    }
}
