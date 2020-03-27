<?php

namespace humhub\modules\socialshare\widgets;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;

class ShareLink extends \yii\base\Widget
{

    public $object;

    public function run()
    {
        $permaLink = Url::to(['/content/perma', 'id' => $this->object->content->id], true);
        return $this->render('shareLink', [
            'object' => $this->object,
            'id' => $this->object->getUniqueId(),
            'permalink' => $permaLink,
        ]);
    }

}

?>
