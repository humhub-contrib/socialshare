<?php

namespace humhub\modules\socialshare\widgets;

use Yii;
use yii\helpers\Url;
use humhub\modules\socialshare\services\SocialShareService;

class ShareLink extends \yii\base\Widget
{
    /**
     * @var object The content object to be shared
     */
    public $object;
    
    /**
     * @var SocialShareService
     */
    protected $socialShareService;

    /**
     * Initialize the widget
     */
    public function init()
    {
        parent::init();
        $this->socialShareService = new SocialShareService();
    }

    /**
     * Run the widget
     * 
     * @return string HTML content
     */
    public function run()
    {
        $permaLink = Url::to(['/content/perma', 'id' => $this->object->content->id], true);
        
        return $this->render('shareLink', [
            'object' => $this->object,
            'id' => $this->object->getUniqueId(),
            'permalink' => $permaLink,
            'socialShareService' => $this->socialShareService
        ]);
    }
}
