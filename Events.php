<?php

namespace humhub\modules\socialshare;

use humhub\modules\socialshare\widgets\ShareLink;
use Yii;
use yii\base\WidgetEvent;
use yii\helpers\Url;

class Events
{

    public static function onTopMenuInit($event)
    {
        $event->sender->addItem([
            'label' => 'SocialShare',
            'url' => Url::toRoute('/socialshare/main/index'),
            'icon' => '<i class="fa fa-sun-o"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'socialshare'),
        ]);
    }

    public static function onWallEntryLinksAfterRun(WidgetEvent $event)
    {
        $event->result = ShareLink::widget(['object' => $event->sender->object]) . $event->result;
    }
}
