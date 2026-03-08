<?php

namespace humhub\modules\socialshare\controllers;

use Yii;
use humhub\modules\admin\components\Controller;
use humhub\modules\socialshare\models\SocialShareProvider;
use yii\web\NotFoundHttpException;

/**
 * AdminController for managing social share providers
 */
class AdminController extends Controller
{
    /**
     * List all providers
     */
    public function actionIndex()
    {
        $providers = SocialShareProvider::find()
            ->orderBy(['sort_order' => SORT_ASC, 'name' => SORT_ASC])
            ->all();

        return $this->render('index', ['providers' => $providers]);
    }

    /**
     * Create a new provider
     */
    public function actionCreate()
    {
        $model = new SocialShareProvider();
        $model->enabled = true;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->view->success(Yii::t('SocialshareModule.base', 'Provider created successfully!'));
            return $this->redirect(['index']);
        }

        return $this->render('edit', ['model' => $model]);
    }

    /**
     * Edit an existing provider
     * 
     * @param int $id
     */
    public function actionEdit($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->view->success(Yii::t('SocialshareModule.base', 'Provider updated successfully!'));
            return $this->redirect(['index']);
        }

        return $this->render('edit', ['model' => $model]);
    }

    /**
     * Delete a provider
     * 
     * @param int $id
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->is_default) {
            $this->view->error(Yii::t('SocialshareModule.base', 'Cannot delete default providers.'));
        } elseif ($model->delete()) {
            $this->view->success(Yii::t('SocialshareModule.base', 'Provider deleted successfully!'));
        } else {
            $this->view->error(Yii::t('SocialshareModule.base', 'Could not delete provider.'));
        }

        return $this->redirect(['index']);
    }

    /**
     * Toggle provider enabled status
     * 
     * @param int $id
     */
    public function actionToggle($id)
    {
        $model = $this->findModel($id);
        $model->enabled = !$model->enabled;

        if ($model->save()) {
            $status = $model->enabled ? 'enabled' : 'disabled';
            $this->view->success(Yii::t('SocialshareModule.base', 'Provider {status}!', ['status' => $status]));
        }

        return $this->redirect(['index']);
    }

    /**
     * Reorder providers
     */
    public function actionReorder()
    {
        $order = Yii::$app->request->post('order', []);

        foreach ($order as $index => $id) {
            $provider = SocialShareProvider::findOne($id);
            if ($provider) {
                $provider->sort_order = $index;
                $provider->save(false);
            }
        }

        return $this->asJson(['success' => true]);
    }

    /**
     * Find model by ID
     * 
     * @param int $id
     * @return SocialShareProvider
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        $model = SocialShareProvider::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException(Yii::t('SocialshareModule.base', 'Provider not found.'));
        }

        return $model;
    }
}