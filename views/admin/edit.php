<?php

use humhub\helpers\Html;
use humhub\modules\ui\form\widgets\SortOrderField;
use humhub\widgets\bootstrap\Alert;
use humhub\widgets\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model humhub\modules\socialshare\models\SocialShareProvider */

$this->title = $model->isNewRecord
    ? Yii::t('SocialshareModule.base', 'Create Provider')
    : Yii::t('SocialshareModule.base', 'Edit Provider: {name}', ['name' => $model->name]);
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <strong><?= Html::encode($this->title) ?></strong>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(['acknowledge' => true]); ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'provider_id')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'e.g., facebook, x, custom_provider',
                    'disabled' => !$model->isNewRecord,
                ])->hint(Yii::t('SocialshareModule.base', 'Lowercase letters, numbers, and underscores only. Cannot be changed after creation.')) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'name')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'e.g., Facebook, X, Bluesky',
                ]) ?>
            </div>
        </div>

        <?= $form->field($model, 'url_pattern')->textInput([
            'maxlength' => true,
            'placeholder' => 'https://example.com/share?url={url}&text={text}',
        ])->hint(Yii::t('SocialshareModule.base', 'Use {url} for the content URL and {text} for the description.')) ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'icon_color')->colorInput() ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'icon_class')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'e.g., facebook, twitter, linkedin-square',
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'sort_order')->widget(SortOrderField::class) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'enabled')->checkbox() ?>
            </div>
        </div>

        <?php if ($model->is_default): ?>
            <?= Alert::info(
                Yii::t('SocialshareModule.base', 'This is a default provider and cannot be deleted, but you can disable or customize it.')
            )->closeButton(false) ?>
        <?php endif; ?>

        <div class="mb-3">
            <?= Html::a(Yii::t('SocialshareModule.base', 'Cancel'), ['index'], ['class' => 'btn btn-light']) ?>
            <?= Html::submitButton(
                $model->isNewRecord ? Yii::t('SocialshareModule.base', 'Create') : Yii::t('SocialshareModule.base', 'Update'),
                ['class' => 'btn btn-primary'],
            ) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
