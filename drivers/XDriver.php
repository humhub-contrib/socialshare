<?php

namespace humhub\modules\socialshare\drivers;

/**
 * X (Twitter) Driver
 */
class XDriver extends BaseDriver
{
    /**
     * @inheritdoc
     */
    public static function getDefaultConfig()
    {
        return [
            'provider_id' => 'x',
            'name' => 'X',
            'url_pattern' => 'https://x.com/intent/post?text={text}&url={url}',
            'icon_class' => 'twitter',
            'icon_color' => '#55acee',
            'sort_order' => 2,
        ];
    }
}