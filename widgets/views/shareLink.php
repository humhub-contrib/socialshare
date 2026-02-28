<?php

use humhub\helpers\Html;
use humhub\modules\socialshare\assets\Assets;
use humhub\modules\socialshare\helpers\SocialShareHelper;

/* @var $this yii\web\View */
/* @var $object object */
/* @var $permalink string */
/* @var $options array */

Assets::register($this);

$linkOptions = [
    'target' => '_blank',
    'rel' => 'noopener noreferrer',
    'class' => 'share-link-item',
];

?>

<?= Html::beginTag('span', $options) ?>
    <?= SocialShareHelper::renderShareLinks($object, $permalink, $linkOptions) ?>

<?= Html::endTag('span') ?>
