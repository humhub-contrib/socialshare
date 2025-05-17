<?php

use yii\helpers\Html;
use humhub\modules\socialshare\assets\Assets;
use humhub\modules\socialshare\services\SocialShareService;

Assets::register($this);

$linkOptions = [
    'target' => '_blank',
    'rel' => 'noopener noreferrer'
];

/** @var SocialShareService $socialShareService */
$socialShareService = new SocialShareService();

?>

<?= Html::beginTag('span', $options) ?>
<!--<?php foreach ($socialShareService->getEnabledPlatforms() as $platform) : ?>
    <?= $socialShareService->createShareLink($platform, $permalink, $object->getContentDescription(), $linkOptions); ?>
<?php endforeach; ?> -->
<?= $socialShareService->renderShareLinks($object, $permalink, $linkOptions) ?>
<?= Html::endTag('span') ?>