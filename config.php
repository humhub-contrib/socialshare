<?php

use humhub\modules\content\widgets\WallEntryLinks;

return [
    'id' => 'socialshare',
    'class' => 'app\modules\socialshare\Module',
    'namespace' => 'app\modules\socialshare',
    'events' => [
        ['class' => WallEntryLinks::class, 'event' => WallEntryLinks::EVENT_INIT, 'callback' => ['app\modules\socialshare\Events', 'onWallEntryLinksInit']],
    ],
];
