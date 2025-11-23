<?php

namespace humhub\modules\socialshare\services;

use Yii;
use yii\helpers\Html;
use humhub\modules\socialshare\models\SocialShareProvider;
use humhub\modules\socialshare\drivers\BaseDriver;

/**
 * SocialShareService handles business logic for social sharing
 */
class SocialShareService
{
    /**
     * Default HTML options for share links
     * 
     * @var array
     */
    protected $defaultOptions = [
        'class' => 'share-link',
        'target' => '_blank',
        'rel' => 'noopener noreferrer'
    ];

    /**
     * Cache for driver instances
     * 
     * @var BaseDriver[]
     */
    protected $drivers = [];

    /**
     * Get driver instance for a provider
     * 
     * @param SocialShareProvider $provider
     * @return BaseDriver
     */
    protected function getDriver(SocialShareProvider $provider)
    {
        if (!isset($this->drivers[$provider->id])) {
            $this->drivers[$provider->id] = $this->createDriver($provider);
        }

        return $this->drivers[$provider->id];
    }

    /**
     * Create driver instance based on provider
     * 
     * @param SocialShareProvider $provider
     * @return BaseDriver
     */
    protected function createDriver(SocialShareProvider $provider)
    {
        $driverClass = $provider->getDriverClass();

        return new $driverClass($provider);
    }

    /**
     * Get all enabled providers
     * 
     * @return SocialShareProvider[]
     */
    public function getEnabledProviders()
    {
        return SocialShareProvider::getEnabled();
    }

    /**
     * Get sharing URL for a specific provider
     * 
     * @param SocialShareProvider $provider
     * @param string $permalink
     * @param string $text
     * @param array $additionalParams
     * @return string
     */
    public function getShareUrl(SocialShareProvider $provider, $permalink, $text = '', $additionalParams = [])
    {
        $driver = $this->getDriver($provider);

        return $driver->getShareUrl($permalink, $text, $additionalParams);
    }

    /**
     * Create a share link HTML element for a provider
     * 
     * @param SocialShareProvider $provider
     * @param string $permalink
     * @param string $text
     * @param array $options HTML options
     * @return string
     */
    public function createShareLink(SocialShareProvider $provider, $permalink, $text = '', $options = [])
    {
        $driver = $this->getDriver($provider);
        $options = array_merge($this->defaultOptions, $options);

        $url = $driver->getShareUrl($permalink, $text);
        $icon = $driver->getIcon();

        return Html::a($icon, $url, $options);
    }

    /**
     * Render all enabled share links for a content object
     * 
     * @param object $object Content object with getContentDescription() method
     * @param string $permalink
     * @param array $options HTML options
     * @return string
     */
    public function renderShareLinks($object, $permalink, $options = [])
    {
        $description = method_exists($object, 'getContentDescription') 
            ? $object->getContentDescription() 
            : '';

        $links = [];
        $providers = $this->getEnabledProviders();

        foreach ($providers as $provider) {
            $links[] = $this->createShareLink($provider, $permalink, $description, $options);
        }

        return implode("\n", $links);
    }
}