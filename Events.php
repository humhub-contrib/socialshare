<?php

namespace humhub\modules\socialshare;

use Yii;
use humhub\modules\user\helpers\AuthHelper;
use humhub\modules\socialshare\widgets\ShareLink;

class Events
{
    public static function onWallEntryLinksInit($event)
    {
        if (!Yii::$app->user->isGuest || Yii::$app->user->identity && AuthHelper::isGuestAccessEnabled())
        {
            $event->sender->addWidget(ShareLink::class, ['object' => $event->sender->object], ['sortOrder' => 10]);
        }
    }

}
