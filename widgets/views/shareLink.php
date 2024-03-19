<?php

use humhub\modules\socialshare\assets\Assets;
use yii\helpers\Html;

Assets::register($this);
?>
<div class="shareLinkContainer pull-right">
    <?php
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
    <?= Html::a('<i class="fa fa-facebook" style="font-size:16px;color:#3a5795">&nbsp;</i>', 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode((string)$permalink) . '&description=' . urlencode((string)$object->getContentDescription()), ['onclick' => $option]); ?>
    <?= Html::a('<i class="fa fa-twitter" style="font-size:16px;color:#55acee">&nbsp;</i>', 'https://twitter.com/intent/tweet?text=' . urlencode((string)$object->getContentDescription()) . '&url=' . urlencode((string)$permalink), ['onclick' => $option]); ?>
    <?= Html::a('<i class="fa fa-linkedin-square" style="font-size:16px;color:#0177b5">&nbsp;</i>', 'https://www.linkedin.com/shareArticle?summary=&mini=true&source=&title=' . urlencode((string)$object->getContentDescription()) . '&url=' . urlencode((string)$permalink) . '&ro=false', ['onclick' => $option]); ?>
    <?= Html::a('<i class="fa fa-share" style="font-size:16px;color:#00c300">&nbsp;</i>', 'https://social-plugins.line.me/lineit/share?' . '&text=' . urlencode((string)$object->getContentDescription()) . '&url=' . urlencode((string)$permalink), ['onclick' => $option]); ?>
</div>
