<?php

namespace humhub\modules\socialshare\assets;

use yii\web\AssetBundle;

class Assets extends AssetBundle
{
    public $sourcePath = '@socialshare/resources';

    /**
     * @inheritdoc
     */
    public $publishOptions = [
        'forceCopy' => false,
    ];
}
