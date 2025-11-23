<?php

namespace humhub\modules\socialshare\drivers;

/**
 * LINE Driver
 */
class LineDriver extends BaseDriver
{
    /**
     * @inheritdoc
     */
    public static function getDefaultConfig()
    {
        return [
            'provider_id' => 'line',
            'name' => 'Line',
            'url_pattern' => 'https://social-plugins.line.me/lineit/share?text={text}&url={url}',
            'icon_class' => 'share',
            'icon_color' => '#00c300',
            'sort_order' => 4,
        ];
    }
}