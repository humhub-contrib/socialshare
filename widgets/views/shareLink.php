<?php

use humhub\modules\socialshare\assets\Assets;
use humhub\modules\socialshare\models\ConfigureForm;
use humhub\modules\socialshare\services\SocialShareService;

Assets::register($this);

$settings = new ConfigureForm();
$settings->loadSettings();

$option = "
    var width = 575,
        height = 400,
        left = ($(window).width() - width) / 2,
        top = ($(window).height() - height) / 2,
        url = this.href;
        opts = 'status=1' +
            ',width=' + width +
            ',height=' + height +
            ',top=' + top +
            ',left=' + left;

        window.open(url, 'share', opts);

        return false;
";

$linkOptions = ['onclick' => $option, 'target' => '_blank', 'rel' => 'noopener noreferrer'];

/** @var SocialShareService $socialShareService */
$socialShareService = new SOcialShareService;
?>

<span class="shareLinkContainer">
    <div class="pull-right">
        <?php if ($settings->facebook_enabled): ?>
            <?= $socialShareService->createShareLink(
                SocialShareService::PLATFORM_FACEBOOK,
                $permalink,
                $object->getContentDescription(),
                array_merge($linkOptions, ['onclick' => $option])
            ); ?>
        <?php endif; ?>

        <?php if ($settings->twitter_enabled): ?>
            <?= $socialShareService->createShareLink(
                SocialShareService::PLATFORM_TWITTER,
                $permalink,
                $object->getContentDescription(),
                array_merge($linkOptions, ['onclick' => $option])
            ); ?>
        <?php endif; ?>

        <?php if ($settings->linkedin_enabled): ?>
            <?= $socialShareService->createShareLink(
                SocialShareService::PLATFORM_LINKEDIN,
                $permalink,
                $object->getContentDescription(),
                array_merge($linkOptions, ['onclick' => $option])
            ); ?>
        <?php endif; ?>

        <?php if ($settings->line_enabled): ?>
            <?= $socialShareService->createShareLink(
                SocialShareService::PLATFORM_LINE,
                $permalink,
                $object->getContentDescription(),
                array_merge($linkOptions, ['onclick' => $option])
            ); ?>
        <?php endif; ?>

        <?php if ($settings->bluesky_enabled): ?>
            <?= $socialShareService->createShareLink(
                SocialShareService::PLATFORM_BLUESKY,
                $permalink,
                $object->getContentDescription(),
                array_merge($linkOptions, ['onclick' => $option])
            ); ?>
        <?php endif; ?>
    </div>
</span>
