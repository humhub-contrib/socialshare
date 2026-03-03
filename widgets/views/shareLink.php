<?php

use humhub\modules\socialshare\assets\Assets;
use humhub\widgets\bootstrap\Link;

/* @var string $permalink */
/* @var string $description */

Assets::register($this);
?>
<div class="shareLinkContainer float-end" style="font-size:16px">
    <?= Link::to(null)
        ->icon('facebook')
        ->link('https://www.facebook.com/sharer/sharer.php?u=' . urlencode((string) $permalink) . '&description=' . urlencode((string) $description))
        ->cssTextColor('#3a5795') ?>

    <?= Link::to(null)
        ->icon('twitter')
        ->link('https://twitter.com/intent/tweet?text=' . urlencode((string) $description) . '&url=' . urlencode((string) $permalink))
        ->cssTextColor('#55acee') ?>

    <?= Link::to(null)
        ->icon('linkedin-square')
        ->link('https://www.linkedin.com/shareArticle?summary=&mini=true&source=&title=' . urlencode((string) $description) . '&url=' . urlencode((string) $permalink))
        ->cssTextColor('#0177b5') ?>

    <?= Link::to(null)
        ->icon('share')
        ->link('https://social-plugins.line.me/lineit/share?text=' . urlencode((string) $description) . '&url=' . urlencode((string) $permalink))
        ->cssTextColor('#00c300') ?>
</div>
