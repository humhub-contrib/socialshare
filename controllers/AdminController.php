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

        if ($model->load(Yii::$app->request->post())) {
            $this->applyCustomSettings($model);

            if ($model->save()) {
                $this->view->success(Yii::t('SocialshareModule.base', 'Provider created successfully!'));
                return $this->redirect(['index']);
            }
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

        if ($model->load(Yii::$app->request->post())) {
            $this->applyCustomSettings($model);

            if ($model->save()) {
                $this->view->success(Yii::t('SocialshareModule.base', 'Provider updated successfully!'));
                return $this->redirect(['index']);
            }
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
        $this->forcePostRequest();
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
        $this->forcePostRequest();
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
        $this->forcePostRequest();
        $order = Yii::$app->request->post('order', []);

        foreach ($order as $index => $id) {
            $provider = SocialShareProvider::findOne((int)$id);

            if ($provider !== null) {
                $provider->sort_order = (int)$index;
                $provider->save(false);
            }
        }

        return $this->asJson(['success' => true]);
    }

    /**
     * Re-encode posted custom_settings fields into the model's JSON column.
     *
     * The view renders driver-specific fields as array inputs using the naming
     * convention SocialShareProvider[custom_settings][key], so after a standard
     * model->load() the attribute holds an array rather than a JSON string.
     *
     * This method intercepts that array, strips empty values, and calls
     * setCustomSettings() to re-encode it correctly before validation and save.
     *
     * For providers whose driver declares no custom settings fields, the posted
     * value will be absent entirely and the existing stored JSON is left untouched.
     *
     * @param SocialShareProvider $model
     */
    protected function applyCustomSettings(SocialShareProvider $model): void
    {
        $posted = Yii::$app->request->post('SocialShareProvider', []);

        if (!isset($posted['custom_settings'])) {
            return;
        }

        if (!is_array($posted['custom_settings'])) {
            return;
        }

        $filtered = array_filter(
            $posted['custom_settings'],
            static fn($v) => $v !== null && $v !== '',
        );

        $model->setCustomSettings($filtered);
    }

    /**
     * Find model by ID or throw 404
     *
     * @param int $id
     * @return SocialShareProvider
     * @throws NotFoundHttpException
     */
    protected function findModel($id): SocialShareProvider
    {
        $model = SocialShareProvider::findOne((int)$id);

        if ($model === null) {
            throw new NotFoundHttpException(Yii::t('SocialshareModule.base', 'Provider not found.'));
        }

        return $model;
    }
}
