<?php

namespace humhub\modules\socialshare\helpers;

use humhub\modules\socialshare\services\SocialShareService;
use humhub\modules\socialshare\models\SocialShareProvider;
use humhub\modules\socialshare\drivers\BaseDriver;

/**
 * SocialShareHelper provides convenient static methods for social sharing
 */
class SocialShareHelper
{
    /**
     * @var SocialShareService
     */
    protected static $service;

    /**
     * Get the service instance
     * 
     * @return SocialShareService
     */
    protected static function getService()
    {
        if (static::$service === null) {
            static::$service = new SocialShareService();
        }

        return static::$service;
    }

    /**
     * Render share links for a content object
     * 
     * @param object $object Content object
     * @param string $permalink
     * @param array $options
     * @return string
     */
    public static function renderShareLinks($object, $permalink, $options = [])
    {
        return static::getService()->renderShareLinks($object, $permalink, $options);
    }

    /**
     * Get share URL for a specific provider
     * 
     * @param string $providerId Provider identifier
     * @param string $permalink
     * @param string $text
     * @param array $additionalParams
     * @return string|null
     */
    public static function getShareUrl($providerId, $permalink, $text = '', $additionalParams = [])
    {
        $provider = SocialShareProvider::findByProviderId($providerId);

        if (!$provider || !$provider->enabled) {
            return null;
        }

        return static::getService()->getShareUrl($provider, $permalink, $text, $additionalParams);
    }

    /**
     * Create a single share link
     * 
     * @param string $providerId Provider identifier
     * @param string $permalink
     * @param string $text
     * @param array $options
     * @return string|null
     */
    public static function createShareLink($providerId, $permalink, $text = '', $options = [])
    {
        $provider = SocialShareProvider::findByProviderId($providerId);

        if (!$provider || !$provider->enabled) {
            return null;
        }

        return static::getService()->createShareLink($provider, $permalink, $text, $options);
    }

    /**
     * Check if a provider is enabled
     * 
     * @param string $providerId
     * @return bool
     */
    public static function isProviderEnabled($providerId)
    {
        $provider = SocialShareProvider::findByProviderId($providerId);

        return $provider && $provider->enabled;
    }

    /**
     * Get all enabled provider IDs
     * 
     * @return string[]
     */
    public static function getEnabledProviderIds()
    {
        return array_map(function($provider) {
            return $provider->provider_id;
        }, SocialShareProvider::getEnabled());
    }

    /**
     * Initialize default providers from driver classes
     * 
     * @return void
     */
    public static function initializeDefaultProviders()
    {
        BaseDriver::initializeDefaults();
    }
}