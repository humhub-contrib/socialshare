<?php

namespace humhub\modules\socialshare\services;

use yii\helpers\Html;
use humhub\modules\ui\icon\widgets\Icon;

/**
 * SocialShareService provides methods for sharing content to various social media platforms.
 */
class SocialShareService
{
    /**
     * List of supported social media platforms
     */
    public const PLATFORM_FACEBOOK = 'facebook';
    public const PLATFORM_TWITTER = 'twitter';
    public const PLATFORM_LINKEDIN = 'linkedin';
    public const PLATFORM_LINE = 'line';
    public const PLATFORM_BLUESKY = 'bluesky';

    /**
     * Default sharing options
     * 
     * @var array
     */
    protected $defaultOptions = [
        'class' => '',
        'target' => '_blank',
        'rel' => 'noopener noreferrer'
    ];

    /**
     * Platform configurations for sharing URLs and icons
     * 
     * @var array
     */
    protected $platforms = [];

    /**
     * Class constructor
     */
    public function __construct()
    {
        $this->platforms = [
            self::PLATFORM_FACEBOOK => [
                'urlPattern' => 'https://www.facebook.com/sharer/sharer.php?u={url}&description={text}',
                'iconClass' => 'facebook',
                'iconColor' => '#3a5795',
            ],
            self::PLATFORM_TWITTER => [
                'urlPattern' => 'https://twitter.com/intent/tweet?text={text}&url={url}',
                'iconClass' => 'twitter',
                'iconColor' => '#55acee',
            ],
            self::PLATFORM_LINKEDIN => [
                'urlPattern' => 'https://www.linkedin.com/shareArticle?summary=&mini=true&source=&title={text}&url={url}&ro=false',
                'iconClass' => 'linkedin-square',
                'iconColor' => '#0177b5',
            ],
            self::PLATFORM_LINE => [
                'urlPattern' => 'https://social-plugins.line.me/lineit/share?&text={text}&url={url}',
                'iconClass' => 'share',
                'iconColor' => '#00c300',
            ],
            self::PLATFORM_BLUESKY => [
                'urlPattern' => 'https://bsky.app/intent/compose?text={text}',
                'iconClass' => 'share',
                'iconColor' => '#4f9bd9',
            ],
        ];
    }

    /**
     * Get sharing URL for the specified platform
     * 
     * @param string $platform Platform identifier (use class constants)
     * @param string $permalink Permalink to the content
     * @param string $description Content description/text
     * @param array $additionalParams Additional URL parameters for the share URL
     * @return string The sharing URL
     */
    public function getSharingUrl($platform, $permalink, $description, $additionalParams = [])
    {
        $permalink = (string)$permalink;
        $description = (string)$description;

        if (!isset($this->platforms[$platform])) {
            throw new \InvalidArgumentException("Unsupported platform: {$platform}");
        }

        $encodedPermalink = urlencode($permalink);
        $encodedDescription = urlencode($description);

        if ($platform === self::PLATFORM_BLUESKY) {
            $encodedText = urlencode($description . ' ' . $permalink);
            $url = str_replace(
                ['{url}', '{text}'], 
                ['', $encodedText], 
                $this->platforms[$platform]['urlPattern']
            );
        } else {
            $url = str_replace(
                ['{url}', '{text}'], 
                [$encodedPermalink, $encodedDescription], 
                $this->platforms[$platform]['urlPattern']
            );
        }

        if (!empty($additionalParams)) {
            $url .= '&' . http_build_query($additionalParams);
        }

        return $url;
    }

    /**
     * Get only the platforms that are enabled in the module settings
     *
     * @return array List of enabled platform identifiers
     */
    public function getEnabledPlatforms()
    {
        $config = \Yii::$app->getModule('socialshare')->settings;
        $enabledPlatforms = [];

        if ($config->get('facebook_enabled', true)) {
            $enabledPlatforms[] = self::PLATFORM_FACEBOOK;
        }

        if ($config->get('twitter_enabled', true)) {
            $enabledPlatforms[] = self::PLATFORM_TWITTER;
        }

        if ($config->get('linkedin_enabled', true)) {
            $enabledPlatforms[] = self::PLATFORM_LINKEDIN;
        }

        if ($config->get('line_enabled', true)) {
            $enabledPlatforms[] = self::PLATFORM_LINE;
        }

        if ($config->get('bluesky_enabled', true)) {
            $enabledPlatforms[] = self::PLATFORM_BLUESKY;
        }

        return $enabledPlatforms;
    }

    /**
     * Generate share link HTML for a specific platform
     * 
     * @param string $platform Platform identifier
     * @param string $permalink Permalink to the content
     * @param string $description Content description
     * @param array $options Rendering options
     * @return string HTML link tag
     */
    public function createShareLink($platform, $permalink, $description, $options = [])
    {
        if (!isset($this->platforms[$platform])) {
            throw new \InvalidArgumentException("Unsupported platform: {$platform}");
        }

        $options = array_merge($this->defaultOptions, $options);

        $url = $this->getSharingUrl($platform, $permalink, $description);
        $icon = $this->getPlatformIcon($platform);

        return Html::a($icon, $url, $options);
    }

    /**
     * Generate HTML for all enabled share links
     * 
     * @param mixed $object Content object that provides getContentDescription()
     * @param string $permalink Permalink to the content
     * @param array $options Rendering options
     * @return string HTML with all enabled share links
     */
    public function renderShareLinks($object, $permalink, $options = [])
    {
        $description = method_exists($object, 'getContentDescription') 
            ? $object->getContentDescription() 
            : '';

        $links = [];
        $enabledPlatforms = $this->getEnabledPlatforms();

        foreach ($enabledPlatforms as $platform) {
            $links[] = $this->createShareLink($platform, $permalink, $description, $options);
        }

        return implode("\n", $links);
    }

    /**
     * Get HTML for the platform icon
     * 
     * @param string $platform Platform identifier
     * @return string HTML icon
     */
    protected function getPlatformIcon($platform)
    {
        if (!isset($this->platforms[$platform])) {
            throw new \InvalidArgumentException("Unsupported platform: {$platform}");
        }

        $iconClass = $this->platforms[$platform]['iconClass'];
        $iconColor = $this->platforms[$platform]['iconColor'];

        return Icon::get($iconClass)->color($iconColor)->style('font-size:16px');
    }

    /**
     * Add a custom sharing platform
     * 
     * @param string $platformId Platform identifier
     * @param string $shareUrlPattern URL pattern with {url} and {text} placeholders
     * @param string $iconClass CSS class for the icon
     * @param string $iconColor Hex color code for the icon
     * @return self
     */
    public function addPlatform($platformId, $shareUrlPattern, $iconClass, $iconColor = '#000000')
    {
        $this->platforms[$platformId] = [
            'urlPattern' => $shareUrlPattern,
            'iconClass' => $iconClass,
            'iconColor' => $iconColor,
        ];

        return $this;
    }

    /**
     * Remove a sharing platform
     * 
     * @param string $platformId Platform identifier
     * @return self
     */
    public function removePlatform($platformId)
    {
        if (isset($this->platforms[$platformId])) {
            unset($this->platforms[$platformId]);
        }

        return $this;
    }

    /**
     * Get all available platform IDs
     * 
     * @return array List of platform identifiers
     */
    public function getAvailablePlatforms()
    {
        return array_keys($this->platforms);
    }
}
