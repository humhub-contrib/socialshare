<?php

use humhub\helpers\Html;
use humhub\modules\ui\icon\widgets\Icon;
use humhub\modules\admin\grid\CheckboxColumn;
use humhub\widgets\bootstrap\Button;
use humhub\widgets\GridView;
use yii\data\ArrayDataProvider;
use yii\grid\ActionColumn;
use yii\helpers\Url;

/* @var $providers humhub\modules\socialshare\models\SocialShareProvider[] */

?>

<?= Button::success(Yii::t('SocialshareModule.base', 'Add Provider'))
    ->icon('add')->sm()->link(Url::to(['create']))->right() ?>

<br/>

<?= GridView::widget([
    'dataProvider' => new ArrayDataProvider(['allModels' => $providers, 'pagination' => ['pageSize' => 0]]),
    'layout' => '{items}',
    'columns' => [
        [
            'attribute' => 'icon',
            'label' => '',
            'format' => 'raw',
            'options' => ['style' => 'width: 50px;'],
            'contentOptions' => ['style' => 'text-align:center; font-size: 1.5rem; line-height: 1;'],
            'content' => function ($model) {
                return Icon::get($model->icon_class)->color($model->icon_color);
            }
        ],
        [
            'attribute' => 'name',
            'content' => fn($model, $key, $index, $that) => Html::encode($that->getDataCellValue($model, $key, $index))
        ],
        [
            'class' => CheckboxColumn::class,
            'label' => Yii::t('SocialshareModule.base', 'Enabled'),
            'attribute' => 'enabled',
            'options' => ['style' => 'width: fit-content;'],
            'headerOptions' => ['style' => 'word-break: keep-all; hyphens: none;'],
        ],
        [
            'class' => CheckboxColumn::class,
            'label' => Yii::t('SocialshareModule.base', 'Default'),
            'attribute' => 'is_default',
            'options' => ['style' => 'width: fit-content;'],
            'headerOptions' => ['style' => 'word-break: keep-all; hyphens: none;'],
        ],
        [
            'attribute' => 'sort_order',
        ],
        [
            'header' => '&nbsp;',
            'class' => ActionColumn::class,
            'options' => ['style' => 'width:80px;'],
            'contentOptions' => ['style' => 'text-align:center'],
            'headerOptions' => ['style' => 'text-align:center'],
            'template' => '<div style="display: flex; gap: 4px; justify-content: center;">{update} {delete}</div>',
            'buttons' => [
                'view' => function (): void {
                    return;
                },
                'delete' => fn($url, $model) =>
                    !$model->is_default 
                        ? Button::danger()->icon('trash')->link(Url::to(['delete', 'id' => $model->id]))->sm()
                            ->options([
                                'data-method' => 'post',
                                'data-confirm' => Yii::t('SocialshareModule.base', 'Are you sure you want to delete this provider?'),
                            ])
                        : '',
                'update' => fn($url, $model) =>
                    Button::primary()->icon('edit')->link(Url::to(['edit', 'id' => $model->id]))->sm(),
            ],
        ],
    ]
]);
