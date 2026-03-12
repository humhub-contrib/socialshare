<?php

namespace humhub\modules\socialshare\controllers;

use humhub\modules\admin\components\Controller;
use humhub\modules\socialshare\models\SocialShareProvider;
use Yii;
use yii\web\NotFoundHttpException;

class AdminController extends Controller
{
    public function actionIndex()
    {
        $providers = SocialShareProvider::find()
            ->orderBy(['sort_order' => SORT_ASC, 'name' => SORT_ASC])
            ->all();

        return $this->render('index', ['providers' => $providers]);
    }

    public function actionCreate()
    {
        $model = new SocialShareProvider(['enabled' => true]);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->view->success(Yii::t('SocialshareModule.base', 'Provider created successfully!'));
            return $this->redirect(['index']);
        }

        return $this->render('edit', ['model' => $model]);
    }

    public function actionEdit(int $id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->view->success(Yii::t('SocialshareModule.base', 'Provider updated successfully!'));
            return $this->redirect(['index']);
        }

        return $this->render('edit', ['model' => $model]);
    }

    public function actionDelete(int $id)
    {
        $this->forcePostRequest();

        $model = $this->findModel($id);

        if ($model->delete()) {
            $this->view->success(Yii::t('SocialshareModule.base', 'Provider deleted successfully!'));
        } else {
            $this->view->error(Yii::t('SocialshareModule.base', 'Could not delete provider.'));
        }

        return $this->redirect(['index']);
    }

    public function actionToggle(int $id)
    {
        $this->forcePostRequest();

        $model = $this->findModel($id);
        $model->enabled = !$model->enabled;

        if ($model->save(false, ['enabled'])) {
            $status = $model->enabled ? 'enabled' : 'disabled';
            $this->view->success(Yii::t('SocialshareModule.base', 'Provider {status}!', ['status' => $status]));
        } else {
            $this->view->error(Yii::t('SocialshareModule.base', 'Could not update provider status.'));
        }

        return $this->redirect(['index']);
    }

    public function actionReorder()
    {
        $this->forcePostRequest();

        $order = Yii::$app->request->post('order', []);

        foreach ($order as $index => $id) {
            $provider = SocialShareProvider::findOne((int) $id);
            if ($provider !== null) {
                $provider->sort_order = ($index + 1) * 100;
                $provider->save(false, ['sort_order']);
            }
        }

        return $this->asJson(['success' => true]);
    }

    protected function findModel(int $id): SocialShareProvider
    {
        $model = SocialShareProvider::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException(Yii::t('SocialshareModule.base', 'Provider not found.'));
        }

        return $model;
    }
}
