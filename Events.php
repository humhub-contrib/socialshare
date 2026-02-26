<?php

namespace humhub\modules\socialshare;

use humhub\modules\socialshare\widgets\ShareLink;
use yii\base\WidgetEvent;

class Events
{
    public static function onWallEntryLinksAfterRun(WidgetEvent $event)
    {
        $event->result = ShareLink::widget(['object' => $event->sender->object]) . $event->result;
    }
}
