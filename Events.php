<?php

namespace humhub\modules\socialshare;

use humhub\modules\socialshare\widgets\ShareLink;
use humhub\modules\user\helpers\AuthHelper;
use Yii;

class Events
{
    public static function onWallEntryLinksInit($event)
    {
        if (!Yii::$app->user->isGuest || AuthHelper::isGuestAccessEnabled()) {
            $event->sender->addWidget(ShareLink::class, ['object' => $event->sender->object], ['sortOrder' => 10]);
        }
    }

}
