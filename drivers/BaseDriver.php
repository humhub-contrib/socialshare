<?php

namespace humhub\modules\socialshare\drivers;

use humhub\modules\socialshare\models\SocialShareProvider;
use humhub\modules\ui\icon\widgets\Icon;
use Yii;

class BaseDriver
{
    protected SocialShareProvider $provider;

    public function __construct(SocialShareProvider $provider)
    {
        $this->provider = $provider;
    }

    public function getShareUrl(string $permalink, string $text = '', array $additionalParams = []): string
    {
        $url = $this->buildShareUrl($permalink, $text);

        if ($additionalParams !== []) {
            $separator = strpos($url, '?') !== false ? '&' : '?';
            $url .= $separator . http_build_query($additionalParams);
        }

        return $url;
    }

    protected function buildShareUrl(string $permalink, string $text): string
    {
        return str_replace(
            ['{url}', '{text}'],
            [urlencode($permalink), urlencode($text)],
            $this->provider->url_pattern,
        );
    }

    public function getIcon(): string
    {
        return Icon::get($this->provider->icon_class)
            ->color($this->provider->icon_color)
            ->style('font-size:16px')
            ->tooltip($this->provider->name);
    }

    public function getName(): string
    {
        return $this->provider->name;
    }

    public function getProviderId(): string
    {
        return $this->provider->provider_id;
    }

    public function hasCustomLogic(): bool
    {
        return false;
    }

    public static function getDefaultConfig(): ?array
    {
        return null;
    }

    public static function initializeDefaults(): void
    {
        $driverFiles = glob(Yii::getAlias('@socialshare/drivers') . '/*Driver.php') ?: [];

        foreach ($driverFiles as $file) {
            $className = basename($file, '.php');

            if ($className === 'BaseDriver') {
                continue;
            }

            $driverClass = 'humhub\\modules\\socialshare\\drivers\\' . $className;
            if (!class_exists($driverClass)) {
                require_once $file;
            }

            if (!class_exists($driverClass) || !is_subclass_of($driverClass, self::class)) {
                Yii::warning(sprintf('SocialShare driver %s could not be initialized.', $driverClass), 'socialshare');
                continue;
            }

            $config = $driverClass::getDefaultConfig();
            if (empty($config['provider_id']) || SocialShareProvider::findByProviderId($config['provider_id']) !== null) {
                continue;
            }

            $provider = new SocialShareProvider();
            $provider->setAttributes($config);
            $provider->is_default = true;
            $provider->enabled = true;

            if (!$provider->save()) {
                Yii::warning([
                    'message' => 'SocialShare default provider could not be saved.',
                    'provider' => $config['provider_id'],
                    'errors' => $provider->getErrors(),
                ], 'socialshare');
            }
        }
    }
}
