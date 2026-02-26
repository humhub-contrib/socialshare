<?php

namespace humhub\modules\socialshare\widgets;

use humhub\modules\content\components\ContentActiveRecord;
use yii\base\Widget;
use yii\helpers\Url;

class ShareLink extends Widget
{
    /**
     * @var ContentActiveRecord $object
     */
    public $object;

    public function run()
    {
        return $this->render('shareLink', [
            'permalink' => Url::to(['/content/perma', 'id' => $this->object->content->id], true),
            'description' => (string)$this->object->getContentDescription(),
        ]);
    }

}
