<?php

namespace humhub\modules\socialshare;

use yii\helpers\Url;

class Module extends \humhub\components\Module
{
    public $resourcesPath = 'resources';

    public function getConfigUrl()
    {
        return Url::to(['/socialshare/admin']);
    }

}
