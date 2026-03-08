<?php

namespace humhub\modules\socialshare;

use humhub\modules\socialshare\widgets\ShareLink;
use yii\base\WidgetEvent;

class Events
{
    public static function onWallEntryLinksAfterRun(WidgetEvent $event)
    {
        if (!Yii::$app->user->isGuest || Yii::$app->user->identity && AuthHelper::isGuestAccessEnabled())
        {
            $event->sender->addWidget(widgets\ShareLink::class, ['object' => $event->sender->object], ['sortOrder' => 10]);
        }
    }

}
