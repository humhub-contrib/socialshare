<?php

namespace humhub\modules\socialshare\widgets;

use Yii;
use yii\helpers\Url;
use humhub\modules\socialshare\helpers\SocialShareHelper;
use humhub\widgets\JsWidget;

/**
 * ShareLink Widget
 * Renders social share buttons for content
 */
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
     * @inheritdoc
     */
    public $init = true;

    /**
     * Returns the container HTML attributes
     * @return array HTML attributes for the container
     */
    protected function getAttributes()
    {
        return [
            'class' => 'shareLinkContainer pull-right',
        ];
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (empty(SocialShareHelper::getEnabledProviderIds())) {
            return '';
        }

        $permaLink = Url::to(['/content/perma', 'id' => $this->object->content->id], true);

        return $this->render('shareLink', [
            'object' => $this->object,
            'permalink' => $permaLink,
            'options' => $this->getOptions(),
        ]);
    }
}