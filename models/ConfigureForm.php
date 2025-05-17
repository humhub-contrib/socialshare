<?php

namespace humhub\modules\socialshare\models;

use Yii;
use yii\base\Model;

class ConfigureForm extends Model
{
    public $facebook_enabled;
    public $x_enabled;
    public $linkedin_enabled;
    public $line_enabled;
    public $bluesky_enabled;
    public $custom_facebook_url;
    public $custom_x_url;
    public $custom_linkedin_url;
    public $custom_line_url;
    public $custom_bluesky_url;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        $this->loadSettings();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['facebook_enabled', 'x_enabled', 'linkedin_enabled', 'line_enabled', 'bluesky_enabled'], 'boolean'],
            [['custom_facebook_url', 'custom_x_url', 'custom_linkedin_url', 'custom_line_url', 'custom_bluesky_url'], 'string'],
        ];
    }

    /**
     * Loads settings from the module's configuration
     */
    protected function loadSettings()
    {
        $config = Yii::$app->getModule('socialshare')->settings;

        $this->facebook_enabled = $config->get('facebook_enabled', true);
        $this->x_enabled = $config->get('x_enabled', true);
        $this->linkedin_enabled = $config->get('linkedin_enabled', true);
        $this->line_enabled = $config->get('line_enabled', true);
        $this->bluesky_enabled = $config->get('bluesky_enabled', true);
        $this->custom_facebook_url = $config->get('custom_facebook_url', 'https://www.facebook.com/sharer/sharer.php?u={url}');
        $this->custom_x_url = $config->get('custom_x_url', 'https://x.com/intent/post?text={text}&url={url}');
        $this->custom_linkedin_url = $config->get('custom_linkedin_url', 'https://www.linkedin.com/shareArticle?mini=true&url={url}&title={title}');
        $this->custom_line_url = $config->get('custom_line_url', 'https://social-plugins.line.me/lineit/share?text={text}&url={url}');
        $this->custom_bluesky_url = $config->get('custom_bluesky_url', 'https://bsky.app/intent/compose?text={text}&url={url}');
    }

    /**
     * Save settings to the module's configuration
     * @return bool Whether the save was successful
     */
    public function saveSettings()
    {
        if (!$this->validate()) {
            return false;
        }

        $config = Yii::$app->getModule('socialshare')->settings;

        $config->set('facebook_enabled', $this->facebook_enabled);
        $config->set('x_enabled', $this->x_enabled);
        $config->set('linkedin_enabled', $this->linkedin_enabled);
        $config->set('line_enabled', $this->line_enabled);
        $config->set('bluesky_enabled', $this->bluesky_enabled);
        $config->set('custom_facebook_url', $this->custom_facebook_url);
        $config->set('custom_x_url', $this->custom_x_url);
        $config->set('custom_linkedin_url', $this->custom_linkedin_url);
        $config->set('custom_line_url', $this->custom_line_url);
        $config->set('custom_bluesky_url', $this->custom_bluesky_url);

        return true;
    }
}