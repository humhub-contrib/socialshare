<?php

namespace humhub\modules\socialshare\drivers;

/**
 * BlueSky driver with custom share URL logic
 * BlueSky combines text and URL into a single text parameter
 */
class BlueskyDriver extends BaseDriver
{
    /**
     * @inheritdoc
     */
    protected function buildShareUrl($permalink, $text)
    {
        // BlueSky combines text and URL in the text parameter
        $combinedText = trim($text . ' ' . $permalink);

        $replacements = [
            '{url}' => '',
            '{text}' => urlencode($combinedText),
        ];

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            $this->provider->url_pattern
        );
    }

    /**
     * @inheritdoc
     */
    public function hasCustomLogic()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public static function getDefaultConfig()
    {
        return [
            'provider_id' => 'bluesky',
            'name' => 'Bluesky',
            'url_pattern' => 'https://bsky.app/intent/compose?text={text}',
            'icon_class' => 'share',
            'icon_color' => '#4f9bd9',
            'sort_order' => 5,
        ];
    }
}