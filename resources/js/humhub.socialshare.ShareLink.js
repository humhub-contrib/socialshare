humhub.module('socialshare.ShareLink', function (module, require, $) {
    const Widget = require('ui.widget').Widget;

    const ShareLink = Widget.extend();

    ShareLink.prototype.open = function (evt) {
        const width = 575,
            height = 400,
            left = ($(window).width() - width) / 2,
            top = ($(window).height() - height) / 2,
            url = evt.$trigger.attr('href');

        window.open(url, 'share', 'status=1' +
            ',width=' + width +
            ',height=' + height +
            ',top=' + top +
            ',left=' + left);

        evt.finish();
    };

    module.exports = ShareLink;
});