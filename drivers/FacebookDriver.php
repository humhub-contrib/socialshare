<?php

namespace humhub\modules\socialshare\drivers;

/**
 * Facebook Driver
 *
 * Facebook only accepts a URL in its sharer dialog.
 * Any text parameter must be ignored.
 */
class FacebookDriver extends BaseDriver
{
    /**
     * Facebook does not allow custom "text" in share dialogs.
     * We ensure only {url} is replaced and remove all unused placeholders.
     *
     * @inheritdoc
     */
    protected function buildShareUrl($permalink, $text)
    {
        // Only the URL can be shared; Facebook ignores share text
        $replacements = [
            '{url}' => urlencode($permalink),
            '{text}' => '',
        ];

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            $this->provider->url_pattern
        );
    }

    /**
     * Facebook uses a slightly modified URL-building behavior,
     * so we mark this as custom logic.
     *
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
            'provider_id' => 'facebook',
            'name' => 'Facebook',
            'url_pattern' => 'https://www.facebook.com/sharer/sharer.php?u={url}',
            'icon_class' => 'facebook',
            'icon_color' => '#1877F2',
            'sort_order' => 1,
        ];
    }
}