<?php

namespace humhub\modules\socialshare\drivers;

use Yii;
use humhub\modules\socialshare\models\SocialShareProvider;
use humhub\modules\ui\icon\widgets\Icon;

/**
 * Base class for social share drivers
 * Handles platform-specific sharing logic and default provider initialization
 */
class BaseDriver
{
    /**
     * @var SocialShareProvider
     */
    protected $provider;

    /**
     * Constructor
     * 
     * @param SocialShareProvider $provider
     */
    public function __construct(SocialShareProvider $provider)
    {
        $this->provider = $provider;
    }

    /**
     * Get the sharing URL
     * 
     * @param string $permalink The content URL
     * @param string $text The share text/description
     * @param array $additionalParams Additional URL parameters
     * @return string
     */
    public function getShareUrl($permalink, $text = '', $additionalParams = [])
    {
        $url = $this->buildShareUrl($permalink, $text);

        if (!empty($additionalParams)) {
            $separator = strpos($url, '?') !== false ? '&' : '?';
            $url .= $separator . http_build_query($additionalParams);
        }

        return $url;
    }

    /**
     * Build the share URL from the pattern
     * Can be overridden for platform-specific logic
     * 
     * @param string $permalink
     * @param string $text
     * @return string
     */
    protected function buildShareUrl($permalink, $text)
    {
        $replacements = [
            '{url}' => urlencode($permalink),
            '{text}' => urlencode($text),
        ];

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            $this->provider->url_pattern
        );
    }

    /**
     * Get the icon HTML
     * 
     * @return string
     */
    public function getIcon()
    {
        return Icon::get($this->provider->icon_class)
            ->color($this->provider->icon_color)
            ->style('font-size:16px')
            ->tooltip($this->provider->name);
    }

    /**
     * Get the provider name
     * 
     * @return string
     */
    public function getName()
    {
        return $this->provider->name;
    }

    /**
     * Get the provider ID
     * 
     * @return string
     */
    public function getProviderId()
    {
        return $this->provider->provider_id;
    }

    /**
     * Check if this driver requires special handling
     * 
     * @return bool
     */
    public function hasCustomLogic()
    {
        return false;
    }

    /**
     * Get default provider configuration
     * Override this in subclasses to provide default settings
     * 
     * @return array|null
     */
    public static function getDefaultConfig()
    {
        return null;
    }

    /**
     * Initialize all default providers
     * Scans for driver classes and installs their defaults
     * 
     * @return void
     */
    public static function initializeDefaults()
    {
        $driverPath = Yii::getAlias('@humhub/modules/socialshare/drivers');
        $driverFiles = glob($driverPath . '/*Driver.php');

        foreach ($driverFiles as $file) {
            $className = basename($file, '.php');

            if ($className === 'BaseDriver') {
                continue;
            }

            $fullClassName = 'humhub\\modules\\socialshare\\drivers\\' . $className;

            if (!class_exists($fullClassName)) {
                continue;
            }

            $config = call_user_func([$fullClassName, 'getDefaultConfig']);
            
            if (!$config || !isset($config['provider_id'])) {
                continue;
            }

            if (SocialShareProvider::findByProviderId($config['provider_id'])) {
                continue;
            }

            $provider = new SocialShareProvider();
            $provider->setAttributes($config);
            $provider->is_default = 1;
            $provider->enabled = 1;
            $provider->save();
        }
    }
}