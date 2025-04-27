<?php

namespace humhub\modules\socialshare\controllers;

use Yii;
use humhub\modules\admin\components\Controller;
use humhub\modules\socialshare\models\ConfigureForm;

class AdminController extends Controller
{
    public function actionIndex()
    {
        $settingsModel = new ConfigureForm();
        $settingsModel->loadSettings();
        if ($settingsModel->load(Yii::$app->request->post()) && $settingsModel->saveSettings()) {
            $this->view->success(Yii::t('SocialshareModule.base', 'Social Share settings saved!'));
        }

        return $this->render('index', ['model' => $settingsModel]);
    }
}
