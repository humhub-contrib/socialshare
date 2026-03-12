<?php

namespace humhub\modules\socialshare\services;

use humhub\modules\socialshare\drivers\BaseDriver;
use humhub\modules\socialshare\models\SocialShareProvider;
use yii\helpers\Html;

class SocialShareService
{
    protected array $defaultOptions = [
        'class' => 'share-link',
        'target' => '_blank',
        'rel' => 'noopener noreferrer',
    ];

    /**
     * @var BaseDriver[]
     */
    protected array $drivers = [];

    protected function getDriver(SocialShareProvider $provider): BaseDriver
    {
        if (!isset($this->drivers[$provider->id])) {
            $this->drivers[$provider->id] = $this->createDriver($provider);
        }

        return $this->drivers[$provider->id];
    }

    protected function createDriver(SocialShareProvider $provider): BaseDriver
    {
        $driverClass = $provider->getDriverClass();

        return new $driverClass($provider);
    }

    /**
     * @return SocialShareProvider[]
     */
    public function getEnabledProviders(): array
    {
        return SocialShareProvider::getEnabled();
    }

    public function getShareUrl(SocialShareProvider $provider, string $permalink, string $text = '', array $additionalParams = []): string
    {
        return $this->getDriver($provider)->getShareUrl($permalink, $text, $additionalParams);
    }

    public function createShareLink(SocialShareProvider $provider, string $permalink, string $text = '', array $options = []): string
    {
        $driver = $this->getDriver($provider);

        return Html::a($driver->getIcon(), $driver->getShareUrl($permalink, $text), array_merge($this->defaultOptions, $options));
    }

    public function renderShareLinks(object $object, string $permalink, array $options = []): string
    {
        $description = method_exists($object, 'getContentDescription')
            ? (string) $object->getContentDescription()
            : '';

        $links = [];
        foreach ($this->getEnabledProviders() as $provider) {
            $links[] = $this->createShareLink($provider, $permalink, $description, $options);
        }

        return implode("\n", $links);
    }
}
