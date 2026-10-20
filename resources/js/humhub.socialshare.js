/*
 * @link https://www.humhub.org/
 * @copyright Copyright (c) HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */
humhub.module('socialshare', function (module, require, $) {
    const additions = require('ui.additions');

    const openSocialSharePopup = (e) => {
        e.preventDefault();

        const width = 575;
        const height = 400;
        const left = Math.round((window.innerWidth - width) / 2);
        const top = Math.round((window.innerHeight - height) / 2);

        window.open(e.currentTarget.href, 'share', `status=1,width=${width},height=${height},top=${top},left=${left},resizable=1,scrollbars=1`);
    }

    const init = function() {
        // Applied to the share links on the page and to all links loaded later (e.g. wall entries added on scroll)
        additions.register('socialshare', '.shareLinkContainer a', function ($match) {
            $match.each((i, link) => link.addEventListener('click', openSocialSharePopup));
        });
    }

    module.export({
        init,
    });
});
