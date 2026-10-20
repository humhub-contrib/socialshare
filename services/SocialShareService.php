<?php

namespace humhub\modules\socialshare\services;

use cebe\markdown\GithubMarkdown;
use humhub\helpers\Html;
use humhub\modules\content\components\ContentActiveRecord;
use humhub\modules\socialshare\drivers\BaseDriver;
use humhub\modules\socialshare\models\SocialShareProvider;
use yii\helpers\Url;

/**
 * SocialShareService handles business logic for social sharing.
 */
class SocialShareService
{
    /**
     * Default HTML options for share links.
     *
     * @var array
     */
    protected $defaultOptions = [
        'class' => 'share-link-item',
        'target' => '_blank',
        'rel' => 'noopener noreferrer',
    ];

    /**
     * Cache for driver instances.
     *
     * @var BaseDriver[]
     */
    protected $drivers = [];

    /**
     * Get a driver instance for a provider.
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
     * Create a driver instance for a provider.
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
     * Get all enabled providers.
     *
     * @return SocialShareProvider[]
     */
    public function getEnabledProviders()
    {
        return SocialShareProvider::getEnabled();
    }

    /**
     * Get the sharing URL for a provider.
     *
     * @param SocialShareProvider $provider
     * @param string $permalink
     * @param string $text
     * @param array $additionalParams
     * @return string
     */
    public function getShareUrl(SocialShareProvider $provider, $permalink, $text = '', $additionalParams = [])
    {
        return $this->getDriver($provider)->getShareUrl(
            $permalink,
            $text,
            $additionalParams,
        );
    }

    /**
     * Create a share link for a provider.
     *
     * @param SocialShareProvider $provider
     * @param string $permalink
     * @param string $text
     * @param array $options
     * @return string
     */
    public function createShareLink(SocialShareProvider $provider, $permalink, $text = '', $options = [])
    {
        $options = array_merge($this->defaultOptions, $options);

        return Html::a(
            $this->getDriver($provider)->getIcon(),
            $this->getShareUrl($provider, $permalink, $text),
            $options,
        );
    }

    /**
     * Convert a Markdown description to plain text.
     *
     * Markdown is parsed into HTML first, then its markup is removed.
     * This avoids manually stripping Markdown syntax with regular expressions.
     *
     * @param string|null $description
     * @return string
     */
    protected function convertDescriptionToPlainText($description)
    {
        if ($description === null || $description === '') {
            return '';
        }

        // Use GithubMarkdown to parse Markdown syntax before sharing, as HumHub's configured
        // rich-text converter leaves Markdown markers in the plain-text description.
        $parser = new GithubMarkdown();
        $html = $parser->parse($description);

        $text = html_entity_decode(
            strip_tags($html),
            ENT_QUOTES | ENT_HTML5,
            'UTF-8',
        );

        return trim(preg_replace('/\s+/u', ' ', $text) ?? $text);
    }

    /**
     * Renders share links for a content object using its plain-text description.
     *
     * @param ContentActiveRecord $object Content object to share
     * @param array $options HTML options applied to the share links
     * @return string Rendered HTML share links
     */
    public function renderShareLinks(ContentActiveRecord $object, array $options = []): string
    {
        $permalink = Url::to(['/content/perma', 'id' => $object->content->id], true);

        $description = mb_substr(
            $this->convertDescriptionToPlainText($object->getContentDescription()),
            0,
            1000,
        );

        $links = [];

        foreach ($this->getEnabledProviders() as $provider) {
            $links[] = $this->createShareLink(
                $provider,
                $permalink,
                $description,
                $options,
            );
        }

        return implode("\n", $links);
    }
}
