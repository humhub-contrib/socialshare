/*
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */
humhub.module('socialshare', function (module, require, $) {
    const openSocialSharePopup = (e) => {
        e.preventDefault();

        const width = 575;
        const height = 400;
        const left = Math.round((window.innerWidth - width) / 2);
        const top = Math.round((window.innerHeight - height) / 2);

        window.open(e.currentTarget.href, 'share', `status=1,width=${width},height=${height},top=${top},left=${left},resizable=1,scrollbars=1`);
    }

    const init = function() {
        document.querySelectorAll('.shareLinkContainer a').forEach(link =>
            link.addEventListener('click', e => openSocialSharePopup(e))
        );
    }

    module.export({
        init,
    });
});
