<?php

namespace humhub\modules\socialshare\widgets;

use Yii;
use yii\helpers\Url;
use humhub\modules\socialshare\services\SocialShareService;
use humhub\widgets\JsWidget;

class ShareLink extends JsWidget
{
    /**
     * @var object The content object to be shared
     */
    public $object;

    /**
     * @inheritdoc
     */
    public $jsWidget = 'socialshare.ShareLink';

    /**
     * @var SocialShareService
     */
    protected $socialShareService;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $permaLink = Url::to(['/content/perma', 'id' => $this->object->content->id], true);

        return $this->render('shareLink', [
            'object' => $this->object,
            'id' => $this->object->getUniqueId(),
            'permalink' => $permaLink,
            'socialShareService' => $this->socialShareService,
        ]);
    }
}
