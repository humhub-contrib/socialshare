<?php

namespace humhub\modules\socialshare\assets;

use Yii;
use yii\web\AssetBundle;

class Assets extends AssetBundle
{
    public $sourcePath = '@socialshare/resources';

    public $js = [
        'js/humhub.socialshare.ShareLink.js'
    ];

    public $publishOptions = [
        'forceCopy' => false,
    ];
}
