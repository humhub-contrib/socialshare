<?php

use humhub\modules\content\widgets\WallEntryLinks;
use humhub\modules\socialshare\Events;
use humhub\modules\socialshare\Module;
return [
    'id' => 'socialshare',
    'class' => Module::class,
    'namespace' => 'humhub\modules\socialshare',
    'events' => [
        ['class' => WallEntryLinks::class, 'event' => WallEntryLinks::EVENT_INIT, 'callback' => [Events::class, 'onWallEntryLinksInit']],
    ],
];
