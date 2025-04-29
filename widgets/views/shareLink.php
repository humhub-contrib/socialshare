<?php

use yii\helpers\Html;
use humhub\modules\socialshare\assets\Assets;
use humhub\modules\socialshare\models\ConfigureForm;
use humhub\modules\socialshare\services\SocialShareService;

Assets::register($this);

$settings = new ConfigureForm();
$settings->loadSettings();

$linkOptions = [
    'target' => '_blank',
    'rel' => 'noopener noreferrer'
];

/** @var SocialShareService $socialShareService */
$socialShareService = new SocialShareService();

?>

<?= Html::beginTag('span', $options) ?>
    <div class="pull-right">
        <?php if ($settings->facebook_enabled): ?>
            <?= $socialShareService->createShareLink(
                SocialShareService::PLATFORM_FACEBOOK,
                $permalink,
                $object->getContentDescription(),
                $linkOptions
            ); ?>
        <?php endif; ?>

        <?php if ($settings->twitter_enabled): ?>
            <?= $socialShareService->createShareLink(
                SocialShareService::PLATFORM_TWITTER,
                $permalink,
                $object->getContentDescription(),
                $linkOptions
            ); ?>
        <?php endif; ?>

        <?php if ($settings->linkedin_enabled): ?>
            <?= $socialShareService->createShareLink(
                SocialShareService::PLATFORM_LINKEDIN,
                $permalink,
                $object->getContentDescription(),
                $linkOptions
            ); ?>
        <?php endif; ?>

        <?php if ($settings->line_enabled): ?>
            <?= $socialShareService->createShareLink(
                SocialShareService::PLATFORM_LINE,
                $permalink,
                $object->getContentDescription(),
                $linkOptions
            ); ?>
        <?php endif; ?>

        <?php if ($settings->bluesky_enabled): ?>
            <?= $socialShareService->createShareLink(
                SocialShareService::PLATFORM_BLUESKY,
                $permalink,
                $object->getContentDescription(),
                $linkOptions
            ); ?>
        <?php endif; ?>
    </div>
<?= Html::endTag('span') ?>
