<?php

namespace humhub\modules\socialshare\widgets;

use humhub\modules\content\components\ContentActiveRecord;
use humhub\widgets\JsWidget;
use yii\helpers\Url;

class ShareLink extends JsWidget
{
    public ContentActiveRecord $object;

    public $jsWidget = 'socialshare.ShareLink';

    public $init = true;

    protected function getAttributes()
    {
        return ['class' => 'shareLinkContainer float-end'];
    }

    public function run()
    {
        return $this->render('shareLink', [
            'object' => $this->object,
            'permalink' => Url::to(['/content/perma', 'id' => $this->object->content->id], true),
            'options' => $this->getOptions(),
        ]);
    }
}
