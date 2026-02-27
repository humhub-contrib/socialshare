<?php

use humhub\helpers\Html;
use humhub\widgets\bootstrap\Link;

/* @var string $permalink */
/* @var string $description */
?>
<div class="shareLinkContainer float-end" style="font-size:16px">
    <?= Link::to()
        ->icon('facebook')
        ->link('https://www.facebook.com/sharer/sharer.php?u=' . urlencode((string) $permalink) . '&description=' . urlencode((string) $description))
        ->cssTextColor('#3a5795') ?>

    <?= Link::to()
        ->icon('twitter')
        ->link('https://twitter.com/intent/tweet?text=' . urlencode((string) $description) . '&url=' . urlencode((string) $permalink))
        ->cssTextColor('#55acee') ?>

    <?= Link::to()
        ->icon('linkedin-square')
        ->link('https://www.linkedin.com/shareArticle?summary=&mini=true&source=&title=' . urlencode((string) $description) . '&url=' . urlencode((string) $permalink))
        ->cssTextColor('#0177b5') ?>

    <?= Link::to()
        ->icon('share')
        ->link('https://social-plugins.line.me/lineit/share?text=' . urlencode((string) $description) . '&url=' . urlencode((string) $permalink))
        ->cssTextColor('#00c300') ?>
</div>
<script <?= Html::nonce() ?>>
const openSocialSharePopup = (e) => {
    e.preventDefault();

    const width = 575;
    const height = 400;
    const left = Math.round((window.innerWidth - width) / 2);
    const top = Math.round((window.innerHeight - height) / 2);

    window.open(e.currentTarget.href, 'share', `status=1,width=${width},height=${height},top=${top},left=${left},resizable=1,scrollbars=1`);
};

document.querySelectorAll('.shareLinkContainer a').forEach(link =>
    link.addEventListener('click', e => openSocialSharePopup(e))
);
</script>
