<?php

namespace humhub\modules\socialshare\assets;

use humhub\components\assets\AssetBundle;

class Assets extends AssetBundle
{
    public $sourcePath = '@socialshare/resources';

    /**
     * @inheritdoc
     */
    public $forceCopy = false;
}
