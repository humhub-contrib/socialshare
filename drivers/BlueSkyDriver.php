<?php

namespace humhub\modules\socialshare\drivers;

class BlueSkyDriver extends BaseDriver
{
    protected function buildShareUrl(string $permalink, string $text): string
    {
        return str_replace(
            ['{url}', '{text}'],
            ['', urlencode(trim($text . ' ' . $permalink))],
            $this->provider->url_pattern,
        );
    }

    public function hasCustomLogic(): bool
    {
        return true;
    }

    public static function getDefaultConfig(): ?array
    {
        return [
            'provider_id' => 'bluesky',
            'name' => 'Bluesky',
            'url_pattern' => 'https://bsky.app/intent/compose?text={text}',
            'icon_class' => 'share',
            'icon_color' => '#4f9bd9',
            'sort_order' => 500,
        ];
    }
}
