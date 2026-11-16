<?php

use humhub\components\View;
use humhub\helpers\Html;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\socialshare\assets\Assets;
use humhub\modules\socialshare\services\SocialShareService;

/* @var $this View */
/* @var $object ContentActiveRecord */

Assets::register($this);
?>
<?= Html::beginTag('span', ['class' => 'shareLinkContainer ms-auto order-last']) ?>
    <?= (new SocialShareService())->renderShareLinks($object) ?>
<?= Html::endTag('span') ?>
