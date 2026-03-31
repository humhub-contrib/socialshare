<?php

use humhub\helpers\Html;
use humhub\widgets\form\ActiveForm;
use humhub\widgets\bootstrap\Alert;
use humhub\modules\ui\form\widgets\SortOrderField;

/* @var $this yii\web\View */
/* @var $model humhub\modules\socialshare\models\SocialShareProvider */

$this->title = $model->isNewRecord
    ? Yii::t('SocialshareModule.base', 'Create Provider')
    : Yii::t('SocialshareModule.base', 'Edit Provider: {name}', ['name' => $model->name]);

$customSettingsFields = !$model->isNewRecord
    ? $model->getDriverCustomSettingsFields()
    : [];

$storedSettings = $model->getCustomSettings();
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <strong><?= Html::encode($this->title) ?></strong>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'provider_id')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'e.g., facebook, twitter, custom_provider',
                    'disabled' => !$model->isNewRecord,
                ])->hint(Yii::t('SocialshareModule.base', 'Lowercase letters, numbers, and underscores only. Cannot be changed after creation.')) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'name')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'e.g., Facebook, X (Twitter)',
                ]) ?>
            </div>
        </div>

        <?= $form->field($model, 'url_pattern')->textInput([
            'maxlength' => true,
            'placeholder' => 'https://example.com/share?url={url}&text={text}',
        ])->hint(Yii::t('SocialshareModule.base', 'Use {url} for the content URL and {text} for the description.')) ?>

        <div id="icon-color-field" class="input-group mt-3 input-color-group">
            <?= $form->field($model, 'icon_color')
                ->colorInput()
                ->label(false) ?>

            <?= $form->field($model, 'icon_class')
                ->textInput([
                    'maxlength' => true,
                    'placeholder' => 'e.g., facebook, twitter, share',
                ]) ?>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'sort_order')->widget(SortOrderField::class) ?>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="form-check">
                        <?= Html::activeCheckbox($model, 'enabled', ['class' => 'form-check-input']) ?>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($customSettingsFields)): ?>
            <hr />
            <h5><?= Yii::t('SocialshareModule.base', 'Driver Settings') ?></h5>
            <p class="text-muted small">
                <?= Yii::t('SocialshareModule.base', 'These settings are specific to the {driver} driver.', [
                    'driver' => Html::encode($model->name),
                ]) ?>
            </p>

            <?php foreach ($customSettingsFields as $field): ?>
                <?php
                    $key = $field['key'];
                    $label = $field['label'];
                    $hint = $field['hint'] ?? '';
                    $type = $field['type'] ?? 'text';
                    $defaultValue = $field['default'] ?? '';
                    $currentValue = $storedSettings[$key] ?? $defaultValue;
                    $inputName = Html::getInputName($model, 'custom_settings') . '[' . $key . ']';
                    $inputId = Html::getInputId($model, 'custom_settings') . '_' . $key;
                ?>
                <div class="mb-3">
                    <?php if ($type === 'boolean'): ?>
                        <div class="form-check">
                            <?= Html::checkbox($inputName, (bool)$currentValue, [
                                'id' => $inputId,
                                'class' => 'form-check-input',
                                'value' => 1,
                            ]) ?>
                            <?= Html::label(Html::encode($label), $inputId, ['class' => 'form-check-label']) ?>
                        </div>

                    <?php elseif ($type === 'select'): ?>
                        <?= Html::label(Html::encode($label), $inputId, ['class' => 'control-label']) ?>
                        <?= Html::dropDownList($inputName, $currentValue, $field['options'] ?? [], [
                            'id' => $inputId,
                            'class' => 'form-control',
                        ]) ?>

                    <?php else: ?>
                        <?= Html::label(Html::encode($label), $inputId, ['class' => 'control-label']) ?>
                        <?= Html::textInput($inputName, $currentValue, [
                            'id' => $inputId,
                            'class' => 'form-control',
                            'placeholder' => $defaultValue,
                        ]) ?>
                    <?php endif; ?>

                    <?php if (!empty($hint)): ?>
                        <p class="help-block"><?= Html::encode($hint) ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <?php if ($model->is_default): ?>
            <?= Alert::info(
                Yii::t('SocialshareModule.base', 'This is a default provider and cannot be deleted, but you can disable or customize it.')
            )->closeButton(false) ?>
        <?php endif; ?>

        <div class="mb-3">
            <?= Html::a(
                Yii::t('SocialshareModule.base', 'Cancel'),
                ['index'],
                ['class' => 'btn btn-light']
            ) ?>
            <?= Html::submitButton(
                $model->isNewRecord
                    ? Yii::t('SocialshareModule.base', 'Create')
                    : Yii::t('SocialshareModule.base', 'Update'),
                ['class' => 'btn btn-primary']
            ) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
