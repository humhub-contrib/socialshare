<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Configure Social Share Settings';
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <strong><?= Html::encode($this->title) ?></strong>
    </div>
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'facebook_enabled')->checkbox() ?>
        <?= $form->field($model, 'custom_facebook_url')->textInput() ?>

        <?= $form->field($model, 'twitter_enabled')->checkbox() ?>
        <?= $form->field($model, 'custom_twitter_url')->textInput() ?>

        <?= $form->field($model, 'linkedin_enabled')->checkbox() ?>
        <?= $form->field($model, 'custom_linkedin_url')->textInput() ?>

        <?= $form->field($model, 'line_enabled')->checkbox() ?>
        <?= $form->field($model, 'custom_line_url')->textInput() ?>

        <?= $form->field($model, 'bluesky_enabled')->checkbox() ?>
        <?= $form->field($model, 'custom_bluesky_url')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
