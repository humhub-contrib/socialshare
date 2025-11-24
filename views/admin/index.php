<?php

use yii\helpers\Html;
use humhub\modules\ui\icon\widgets\Icon;
use humhub\widgets\bootstrap\Badge;

/* @var $this yii\web\View */
/* @var $providers humhub\modules\socialshare\models\SocialShareProvider[] */

$this->title = Yii::t('SocialshareModule.base', 'Social Share Providers');
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="d-flex justify-content-between align-items-center">
            <strong><?= Html::encode($this->title) ?></strong>
            <?= Html::a(
                Icon::get('plus') . ' ' . Yii::t('SocialshareModule.base', 'Add Provider'),
                ['create'],
                ['class' => 'btn btn-success btn-sm']
            ) ?>
        </div>
    </div>

    <div class="panel-body">
        <p class="text-muted mb-0">
            <?= Yii::t('SocialshareModule.base', 'Manage your social sharing providers. You can enable/disable, reorder, or customize each provider.') ?>
        </p>
    </div>

    <?php if (empty($providers)): ?>
        <div class="panel-body">
            <div class="alert alert-info mb-0">
                <?= Icon::get('info-circle') ?>
                <?= Yii::t('SocialshareModule.base', 'No providers configured yet. Click "Add Provider" to create one.') ?>
            </div>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;"></th>
                        <th><?= Yii::t('SocialshareModule.base', 'Provider') ?></th>
                        <th><?= Yii::t('SocialshareModule.base', 'ID') ?></th>
                        <th><?= Yii::t('SocialshareModule.base', 'URL Pattern') ?></th>
                        <th style="width: 80px;" class="text-center"><?= Yii::t('SocialshareModule.base', 'Order') ?></th>
                        <th style="width: 80px;" class="text-center"><?= Yii::t('SocialshareModule.base', 'Status') ?></th>
                        <th style="width: 200px;" class="text-end"><?= Yii::t('SocialshareModule.base', 'Actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($providers as $provider): ?>
                        <tr>
                            <td class="text-center">
                                <span style="font-size: 1.5rem; line-height: 1;">
                                    <?= Icon::get($provider->icon_class)->color($provider->icon_color) ?>
                                </span>
                            </td>
                            <td>
                                <strong><?= Html::encode($provider->name) ?></strong>
                                <?php if ($provider->is_default): ?>
                                    <?= Badge::light()
                                        ->icon('lock')
                                        ->tooltip(Yii::t('SocialshareModule.base', 'Default'))
                                        ->sm() ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <code class="small"><?= Html::encode($provider->provider_id) ?></code>
                            </td>
                            <td>
                                <small class="text-muted" style="word-break: break-all;">
                                    <?= Html::encode($provider->url_pattern) ?>
                                </small>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-secondary"><?= Html::encode($provider->sort_order) ?></span>
                            </td>
                            <td class="text-center">
                                <?php if ($provider->enabled): ?>
                                    <?= Badge::success()
                                        ->icon('check')
                                        ->tooltip(Yii::t('SocialshareModule.base', 'Enabled'))
                                        ->sm() ?>
                                <?php else: ?>
                                    <?= Badge::danger()
                                        ->icon('times')
                                        ->tooltip(Yii::t('SocialshareModule.base', 'Disabled'))
                                        ->sm() ?>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <div class="btn-group btn-group-sm">
                                    <?php
                                    $icon = $provider->enabled ? 'eye-slash' : 'eye';
                                    $title = $provider->enabled
                                        ? Yii::t('SocialshareModule.base', 'Disable')
                                        : Yii::t('SocialshareModule.base', 'Enable');

                                    echo Html::a(
                                        Icon::get($icon),
                                        ['toggle', 'id' => $provider->id],
                                        [
                                            'class' => 'btn btn-outline-secondary',
                                            'data-method' => 'post',
                                            'title' => $title,
                                            'data-toggle' => 'tooltip',
                                        ]
                                    );
                                    ?>

                                    <?= Html::a(
                                        Icon::get('pencil'),
                                        ['edit', 'id' => $provider->id],
                                        [
                                            'class' => 'btn btn-outline-primary',
                                            'title' => Yii::t('SocialshareModule.base', 'Edit'),
                                            'data-toggle' => 'tooltip',
                                        ]
                                    ) ?>

                                    <?php if (!$provider->is_default): ?>
                                        <?= Html::a(
                                            Icon::get('trash'),
                                            ['delete', 'id' => $provider->id],
                                            [
                                                'class' => 'btn btn-outline-danger',
                                                'data-method' => 'post',
                                                'data-confirm' => Yii::t('SocialshareModule.base', 'Are you sure you want to delete this provider?'),
                                                'title' => Yii::t('SocialshareModule.base', 'Delete'),
                                                'data-toggle' => 'tooltip',
                                            ]
                                        ) ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <strong><?= Icon::get('info-circle') ?> <?= Yii::t('SocialshareModule.base', 'URL Pattern Placeholders') ?></strong>
    </div>
    <div class="panel-body">
        <p class="mb-2"><?= Yii::t('SocialshareModule.base', 'Use these placeholders in your URL patterns:') ?></p>
        <div class="row">
            <div class="col-md-6">
                <dl class="mb-0">
                    <dt><code>{url}</code></dt>
                    <dd class="text-muted"><?= Yii::t('SocialshareModule.base', 'The content permalink (URL encoded)') ?></dd>
                    <dt><code>{text}</code></dt>
                    <dd class="text-muted mb-0"><?= Yii::t('SocialshareModule.base', 'The content description/text (URL encoded)') ?></dd>
                </dl>
            </div>
            <div class="col-md-6">
                <div class="alert alert-light mb-0">
                    <strong class="small"><?= Yii::t('SocialshareModule.base', 'Example:') ?></strong><br>
                    <code class="small">https://example.com/share?url={url}&text={text}</code>
                </div>
            </div>
        </div>
    </div>
</div>
