<?php

use yii\helpers\Html;
use humhub\modules\socialshare\assets\Assets;
use humhub\modules\socialshare\models\ConfigureForm;

Assets::register($this);

// Load settings
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
?>

<span class="shareLinkContainer">
    <div class="pull-right">
        <?php if ($settings->facebook_enabled): ?>
            <?= Html::a('<i class="fa fa-facebook" style="font-size:16px;color:#3a5795">&nbsp;</i>', str_replace(['{url}', '{text}'], [urlencode((string)$permalink), urlencode((string)$object->getContentDescription())], $settings->custom_facebook_url), ['onclick' => $option]); ?>
        <?php endif; ?>

        <?php if ($settings->twitter_enabled): ?>
            <?= Html::a('<i class="fa fa-twitter" style="font-size:16px;color:#55acee">&nbsp;</i>', str_replace(['{url}', '{text}'], [urlencode((string)$permalink), urlencode((string)$object->getContentDescription())], $settings->custom_twitter_url), ['onclick' => $option]); ?>
        <?php endif; ?>

        <?php if ($settings->linkedin_enabled): ?>
            <?= Html::a('<i class="fa fa-linkedin-square" style="font-size:16px;color:#0177b5">&nbsp;</i>', str_replace(['{url}', '{title}'], [urlencode((string)$permalink), urlencode((string)$object->getContentDescription())], $settings->custom_linkedin_url), ['onclick' => $option]); ?>
        <?php endif; ?>

        <?php if ($settings->line_enabled): ?>
            <?= Html::a('<i class="fa fa-share" style="font-size:16px;color:#00c300">&nbsp;</i>', str_replace(['{url}', '{text}'], [urlencode((string)$permalink), urlencode((string)$object->getContentDescription())], $settings->custom_line_url), ['onclick' => $option]); ?>
        <?php endif; ?>

        <?php if ($settings->bluesky_enabled): ?>
            <?= Html::a('<i class="fa fa-share" style="font-size:16px;color:#25c5df">&nbsp;</i>', str_replace(['{url}', '{text}'], [urlencode((string)$permalink), urlencode((string)$object->getContentDescription())], $settings->custom_bluesky_url), ['onclick' => $option]); ?>
        <?php endif; ?>
    </div>
</span>
