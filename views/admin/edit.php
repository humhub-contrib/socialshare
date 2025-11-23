<?php

use yii\helpers\Html;
use humhub\widgets\form\ActiveForm;
use humhub\widgets\bootstrap\Alert;

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
                    'placeholder' => 'e.g., Facebook, X (Twitter)'
                ]) ?>
            </div>
        </div>

        <?= $form->field($model, 'url_pattern')->textInput([
            'maxlength' => true,
            'placeholder' => 'https://example.com/share?url={url}&text={text}'
        ])->hint(Yii::t('SocialshareModule.base', 'Use {url} for the content URL and {text} for the description.')) ?>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'icon_class')->textInput([
                    'maxlength' => true,
                    'placeholder' => 'e.g., facebook, twitter, share'
                ])->hint(Yii::t('SocialshareModule.base', 'FontAwesome icon class name')) ?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'icon_color')->input('color', [
                    'maxlength' => true,
                ])->hint(Yii::t('SocialshareModule.base', 'Brand color in hex format')) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'sort_order')->input('number', [
                    'min' => 0,
                ])->hint(Yii::t('SocialshareModule.base', 'Lower numbers appear first')) ?>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="form-check">
                        <?= Html::activeCheckbox($model, 'enabled', ['class' => 'form-check-input']) ?>
                        <label class="form-check-label" for="<?= Html::getInputId($model, 'enabled') ?>">
                            <?= $model->getAttributeLabel('enabled') ?>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($model->is_default): ?>
            <?= Alert::info()
                ->body(Yii::t('SocialshareModule.base', 'This is a default provider and cannot be deleted, but you can disable or customize it.')) ?>
        <?php endif; ?>

        <div class="mb-3">
            <?= Html::submitButton(
                $model->isNewRecord 
                    ? Yii::t('SocialshareModule.base', 'Create') 
                    : Yii::t('SocialshareModule.base', 'Update'),
                ['class' => 'btn btn-primary']
            ) ?>
            <?= Html::a(
                Yii::t('SocialshareModule.base', 'Cancel'),
                ['index'],
                ['class' => 'btn btn-light']
            ) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>

<?php if ($model->isNewRecord): ?>
<div class="panel panel-default">
    <div class="panel-heading">
        <strong><?= Yii::t('SocialshareModule.base', 'Common Provider Examples') ?></strong>
    </div>
    <div class="panel-body">
        <h4>Reddit</h4>
        <ul>
            <li><strong>URL Pattern:</strong> <code>https://reddit.com/submit?url={url}&title={text}</code></li>
            <li><strong>Icon Class:</strong> reddit</li>
            <li><strong>Icon Color:</strong> #ff4500</li>
        </ul>

        <h4>Pinterest</h4>
        <ul>
            <li><strong>URL Pattern:</strong> <code>https://pinterest.com/pin/create/button/?url={url}&description={text}</code></li>
            <li><strong>Icon Class:</strong> pinterest</li>
            <li><strong>Icon Color:</strong> #bd081c</li>
        </ul>

        <h4>WhatsApp</h4>
        <ul>
            <li><strong>URL Pattern:</strong> <code>https://wa.me/?text={text}%20{url}</code></li>
            <li><strong>Icon Class:</strong> whatsapp</li>
            <li><strong>Icon Color:</strong> #25d366</li>
        </ul>

        <h4>Telegram</h4>
        <ul>
            <li><strong>URL Pattern:</strong> <code>https://t.me/share/url?url={url}&text={text}</code></li>
            <li><strong>Icon Class:</strong> telegram</li>
            <li><strong>Icon Color:</strong> #0088cc</li>
        </ul>
    </div>
</div>
<?php endif; ?>