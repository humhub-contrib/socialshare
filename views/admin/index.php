<?php

use humhub\modules\ui\icon\widgets\Icon;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $providers humhub\modules\socialshare\models\SocialShareProvider[] */

$this->title = Yii::t('SocialshareModule.base', 'Share Providers');

?>

<div class="panel panel-default">
    <div class="panel-heading">
        <strong><?= $this->title ?></strong>
    </div>

    <div class="panel-body">
        <h4><?= Yii::t('SocialshareModule.base', 'Manage share providers') ?></h4>
        <div class="text-body-secondary">
            <?= Yii::t('SocialshareModule.base', 'Here you can create or edit share providers.') ?>
        </div>

        <?php if (empty($providers)): ?>
            <div class="alert alert-info">
                <?= Icon::get('info-circle') ?>
                <?= Yii::t('SocialshareModule.base', 'No providers configured yet. Click "Add Provider" to create one.') ?>
            </div>
            
            <?= humhub\widgets\bootstrap\Button::success(Yii::t('SocialshareModule.base', 'Add Provider'))
                ->icon('add')
                ->link(Url::to(['create']))
                ->sm() ?>
        <?php else: ?>
            <?= $this->render('_providerGrid', ['providers' => $providers]) ?>
        <?php endif; ?>
    </div>
</div>