<?php

namespace humhub\modules\socialshare\widgets;

use humhub\components\Widget;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\socialshare\models\SocialShareProvider;

/**
 * ShareLink Widget
 * Renders social share buttons for content
 */
class ShareLink extends Widget
{
    /**
     * @var ContentActiveRecord The content object to be shared
     */
    public $object;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (empty(SocialShareProvider::getEnabled())) {
            return '';
        }

        return $this->render('shareLink', [
            'object' => $this->object,
        ]);
    }
}
