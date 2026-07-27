<?php

namespace humhub\modules\socialshare\drivers;

use Yii;

/**
 * Mastodon Driver
 *
 * Mastodon is a federated network with no single domain.
 * This driver defaults to mastodon.social as a fallback,
 * but the instance hostname should be made configurable via
 * the admin settings for this provider if needed.
 *
 * The share URL structure is the same across all Mastodon instances.
 */
class MastodonDriver extends BaseDriver
{
    /**
     * Default Mastodon instance to use when none is configured.
     */
    public const DEFAULT_INSTANCE = 'mastodon.social';

    /**
     * Combines text and permalink into the Mastodon compose intent URL,
     * using the configured or default instance hostname.
     *
     * @inheritdoc
     */
    protected function buildShareUrl($permalink, $text)
    {
        $instance = $this->getInstanceHost();
        $combinedText = trim($text . ' ' . $permalink);

        $replacements = [
            '{instance}' => $instance,
            '{url}' => '',
            '{text}' => urlencode($combinedText),
        ];

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            $this->provider->url_pattern,
        );
    }

    /**
     * Resolves the Mastodon instance host from the stored url_pattern
     * or falls back to the default instance.
     *
     * @return string
     */
    protected function getInstanceHost()
    {
        // Allow the admin to override by storing the instance in custom_settings JSON
        $settings = $this->provider->custom_settings
            ? json_decode($this->provider->custom_settings, true)
            : [];

        return $settings['instance'] ?? static::DEFAULT_INSTANCE;
    }

    /**
     * @inheritdoc
     */
    public function hasCustomLogic()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public static function getCustomSettingsFields(): array
    {
        return [
            [
                'key' => 'instance',
                'label' => Yii::t('SocialshareModule.base', 'Mastodon Instance'),
                'hint' => Yii::t('SocialshareModule.base', 'The hostname of your preferred Mastodon instance, e.g. {example}.', ['example' => 'mastodon.social']),
                'type' => 'text',
                'default' => self::DEFAULT_INSTANCE,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function getDefaultConfig()
    {
        return [
            'provider_id' => 'mastodon',
            'name' => 'Mastodon',
            // {instance} is resolved at runtime via getInstanceHost()
            'url_pattern' => 'https://{instance}/share?text={text}',
            'icon_class' => 'share',
            'icon_color' => '#6364ff',
            'sort_order' => 600,
        ];
    }
}
