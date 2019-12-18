<?php

namespace humhub\modules\socialshare;

use Yii;
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
    
    public static function onWallEntryLinksInit($event)
    {
    	$event->sender->addWidget(widgets\ShareLink::class, ['object' => $event->sender->object], ['sortOrder' => 10]);
    }

}
