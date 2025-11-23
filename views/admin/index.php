<?php

use yii\helpers\Html;
use humhub\modules\ui\icon\widgets\Icon;
use humhub\widgets\bootstrap\Badge;

/* @var $this yii\web\View */
/* @var $providers humhub\modules\socialshare\models\SocialShareProvider[] */

$this->title = Yii::t('SocialshareModule.base', 'Social Share Providers');
?>

<div class="panel panel-default">
    <div class="panel-heading clearfix">
        <strong><?= Html::encode($this->title) ?></strong>

        <div class="pull-right">
            <?= Html::a(
                Icon::get('plus') . ' ' . Yii::t('SocialshareModule.base', 'Add Provider'),
                ['create'],
                ['class' => 'btn btn-success btn-sm']
            ) ?>
        </div>
    </div>

    <div class="panel-body">
        <p><?= Yii::t('SocialshareModule.base', 'Manage your social sharing providers. You can enable/disable, reorder, or customize each provider.') ?></p>
    </div>

    <?php if (empty($providers)): ?>
        <div class="panel-body">
            <div class="alert alert-info">
                <?= Yii::t('SocialshareModule.base', 'No providers configured yet. Click "Add Provider" to create one.') ?>
            </div>
        </div>
    <?php else: ?>
        <div class="panel-body">
            <?php foreach ($providers as $provider): ?>
                <div class="provider-card d-flex">
                    <div class="provider-icon flex-shrink-0 me-3">
                        <?= Icon::get($provider->icon_class)->color($provider->icon_color) ?>
                    </div>

                    <div class="provider-info">
                        <div class="d-flex justify-content-between align-items-start mb-2">

                            <div>
                                <h4 class="mt-0 mb-1">
                                    <?= Html::encode($provider->name) ?>
                                    <?php if ($provider->is_default): ?>
                                        <?= Badge::light()
                                            ->icon('lock')
                                            ->tooltip(Yii::t('SocialshareModule.base', 'Default'))
                                            ->sm() ?>
                                    <?php endif; ?>
                                </h4>
                            </div>

                            <div>
                                <?php if ($provider->enabled): ?>
                                    <?= Badge::success()->tooltip(Yii::t('SocialshareModule.base', 'Enabled')) ?>
                                <?php else: ?>
                                    <?= Badge::danger()->tooltip(Yii::t('SocialshareModule.base', 'Disabled')) ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="mb-2">
                            <strong><?= Yii::t('SocialshareModule.base', 'ID:') ?></strong>
                            <code><?= Html::encode($provider->provider_id) ?></code>
                        </div>

                        <div class="mb-2">
                            <strong><?= Yii::t('SocialshareModule.base', 'URL:') ?></strong>
                            <div class="provider-url"><?= Html::encode($provider->url_pattern) ?></div>
                        </div>

                        <div class="mb-2">
                            <strong><?= Yii::t('SocialshareModule.base', 'Order:') ?></strong>
                            <?= Html::encode($provider->sort_order) ?>
                        </div>

                        <div class="provider-actions">
                            <?php
                            $icon = $provider->enabled ? 'eye-slash' : 'eye';
                            $title = $provider->enabled
                                ? Yii::t('SocialshareModule.base', 'Disable')
                                : Yii::t('SocialshareModule.base', 'Enable');

                            echo Html::a(
                                Icon::get($icon) . ' ' . $title,
                                ['toggle', 'id' => $provider->id],
                                [
                                    'class' => 'btn btn-sm btn-light',
                                    'data-method' => 'post',
                                ]
                            );
                            ?>

                            <?= Html::a(
                                Icon::get('pencil') . ' ' . Yii::t('SocialshareModule.base', 'Edit'),
                                ['edit', 'id' => $provider->id],
                                ['class' => 'btn btn-sm btn-primary']
                            ) ?>

                            <?php if (!$provider->is_default): ?>
                                <?= Html::a(
                                    Icon::get('trash') . ' ' . Yii::t('SocialshareModule.base', 'Delete'),
                                    ['delete', 'id' => $provider->id],
                                    [
                                        'class' => 'btn btn-sm btn-danger',
                                        'data-method' => 'post',
                                        'data-confirm' => Yii::t('SocialshareModule.base', 'Are you sure you want to delete this provider?'),
                                    ]
                                ) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <strong><?= Yii::t('SocialshareModule.base', 'URL Pattern Placeholders') ?></strong>
    </div>
    <div class="panel-body">
        <p><?= Yii::t('SocialshareModule.base', 'Use these placeholders in your URL patterns:') ?></p>
        <ul>
            <li><code>{url}</code> - <?= Yii::t('SocialshareModule.base', 'The content permalink (URL encoded)') ?></li>
            <li><code>{text}</code> - <?= Yii::t('SocialshareModule.base', 'The content description/text (URL encoded)') ?></li>
        </ul>
        <p class="text-body-secondary">
            <?= Yii::t('SocialshareModule.base', 'Example: https://example.com/share?url={url}&text={text}') ?>
        </p>
    </div>
</div>