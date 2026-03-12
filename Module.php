<?php

namespace humhub\modules\socialshare;

use humhub\modules\socialshare\drivers\BaseDriver;
use Yii;
use yii\helpers\Url;

class Module extends \humhub\components\Module
{
    public $resourcesPath = 'resources';

    public function init(): void
    {
        parent::init();

        if (Yii::$app === null || !Yii::$app->has('db')) {
            return;
        }

        try {
            if (Yii::$app->db->schema->getTableSchema('socialshare_provider', true) !== null) {
                BaseDriver::initializeDefaults();
            }
        } catch (\Throwable $e) {
            Yii::warning($e->getMessage(), 'socialshare');
        }
    }

    public function getConfigUrl(): string
    {
        return Url::to(['/socialshare/admin']);
    }
}
