<?php

namespace humhub\modules\socialshare\assets;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public $sourcePath = '@socialshare/resources';

    /**
     * @inheritdoc
     */
    public $js = [
        'js/humhub.socialshare.ShareLink.js'
    ];

    public $publishOptions = [
        'forceCopy' => 'false'
    ];
}
