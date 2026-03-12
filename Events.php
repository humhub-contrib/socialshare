<?php

namespace humhub\modules\socialshare;

use humhub\modules\socialshare\widgets\ShareLink;
use humhub\modules\user\helpers\AuthHelper;
use Yii;
use yii\base\Event;

class Events
{
    public static function onWallEntryLinksInit(Event $event): void
    {
        if (Yii::$app->user->isGuest && !AuthHelper::isGuestAccessEnabled()) {
            return;
        }

        if (!isset($event->sender->object)) {
            return;
        }

        $event->sender->addWidget(ShareLink::class, ['object' => $event->sender->object], ['sortOrder' => 10]);
    }
}
