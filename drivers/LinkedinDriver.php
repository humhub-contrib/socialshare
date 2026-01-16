<?php

namespace humhub\modules\socialshare\drivers;

/**
 * LinkedIn Driver
 */
class LinkedinDriver extends BaseDriver
{
    /**
     * @inheritdoc
     */
    public static function getDefaultConfig()
    {
        return [
            'provider_id' => 'linkedin',
            'name' => 'LinkedIn',
            'url_pattern' => 'https://www.linkedin.com/shareArticle?mini=true&url={url}',
            'icon_class' => 'linkedin-square',
            'icon_color' => '#0177b5',
            'sort_order' => 3,
        ];
    }
}