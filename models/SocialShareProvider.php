<?php

namespace humhub\modules\socialshare\models;

use Yii;
use yii\helpers\Inflector;
use humhub\components\ActiveRecord;
use humhub\modules\socialshare\drivers\BaseDriver;

/**
 * SocialShareProvider ActiveRecord
 *
 * @property int $id
 * @property string $provider_id Unique identifier for the provider
 * @property string $name Display name
 * @property string $url_pattern URL pattern with placeholders
 * @property string $icon_class CSS icon class
 * @property string $icon_color Hex color code
 * @property int $enabled Whether the provider is enabled
 * @property int $sort_order Display order
 * @property int $is_default Whether this is a default provider
 * @property string|null $custom_settings JSON-encoded driver-specific settings
 * @property string $created_at
 * @property int $created_by
 * @property string $updated_at
 * @property int $updated_by
 */
class SocialShareProvider extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'socialshare_provider';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['provider_id', 'name', 'url_pattern', 'icon_class'], 'required'],
            ['provider_id', 'string', 'max' => 50],
            ['provider_id', 'unique'],
            ['provider_id', 'match', 'pattern' => '/^[a-z0-9_]+$/', 'message' => Yii::t('SocialshareModule.base', 'Provider ID can only contain lowercase letters, numbers, and underscores.')],
            [['name'], 'string', 'max' => 100],
            [['url_pattern'], 'string', 'max' => 500],
            [['icon_class'], 'string', 'max' => 100],
            [['icon_color'], 'string', 'max' => 7],
            ['icon_color', 'match', 'pattern' => '/^#[0-9A-Fa-f]{6}$/', 'message' => Yii::t('SocialshareModule.base', 'Icon color must be a valid hex color code.')],
            ['icon_color', 'default', 'value' => '#000000'],
            [['enabled', 'is_default'], 'boolean'],
            [['sort_order'], 'integer'],
            [['sort_order'], 'default', 'value' => 100],
            [['enabled'], 'default', 'value' => 1],
            [['is_default'], 'default', 'value' => 0],
            [['custom_settings'], 'string'],
            [['custom_settings'], 'validateCustomSettings'],
        ];
    }

    /**
     * Validates that custom_settings contains valid JSON when present.
     *
     * @param string $attribute
     */
    public function validateCustomSettings($attribute)
    {
        $value = $this->$attribute;

        if ($value === null || $value === '') {
            return;
        }

        json_decode($value);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->addError($attribute, Yii::t('SocialshareModule.base', 'Custom settings must be valid JSON.'));
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('SocialshareModule.base', 'ID'),
            'provider_id' => Yii::t('SocialshareModule.base', 'Provider ID'),
            'name' => Yii::t('SocialshareModule.base', 'Name'),
            'url_pattern' => Yii::t('SocialshareModule.base', 'URL Pattern'),
            'icon_class' => Yii::t('SocialshareModule.base', 'Icon Class'),
            'icon_color' => Yii::t('SocialshareModule.base', 'Icon Color'),
            'enabled' => Yii::t('SocialshareModule.base', 'Enabled'),
            'sort_order' => Yii::t('SocialshareModule.base', 'Sort Order'),
            'is_default' => Yii::t('SocialshareModule.base', 'Default Provider'),
            'custom_settings' => Yii::t('SocialshareModule.base', 'Custom Settings'),
        ];
    }

    /**
     * Get all enabled providers ordered by sort_order
     *
     * @return static[]
     */
    public static function getEnabled()
    {
        return static::find()
            ->where(['enabled' => 1])
            ->orderBy(['sort_order' => SORT_ASC, 'name' => SORT_ASC])
            ->all();
    }

    /**
     * Get provider by provider_id
     *
     * @param string $providerId
     * @return static|null
     */
    public static function findByProviderId($providerId)
    {
        return static::findOne(['provider_id' => $providerId]);
    }

    /**
     * Get all default providers
     *
     * @return static[]
     */
    public static function getDefaults()
    {
        return static::find()
            ->where(['is_default' => 1])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();
    }

    /**
     * Decode and return custom_settings as an associative array.
     *
     * @return array
     */
    public function getCustomSettings(): array
    {
        if (empty($this->custom_settings)) {
            return [];
        }

        $decoded = json_decode($this->custom_settings, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * Get a single custom setting value by key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getCustomSetting(string $key, $default = null)
    {
        return $this->getCustomSettings()[$key] ?? $default;
    }

    /**
     * Set a single custom setting value and re-encode the JSON.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setCustomSetting(string $key, $value): void
    {
        $settings = $this->getCustomSettings();
        $settings[$key] = $value;
        $this->custom_settings = json_encode($settings);
    }

    /**
     * Replace all custom settings from an associative array.
     *
     * @param array $settings
     * @return void
     */
    public function setCustomSettings(array $settings): void
    {
        $this->custom_settings = empty($settings)
            ? null
            : json_encode($settings);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if ($this->is_default) {
            Yii::$app->session->setFlash('error', Yii::t('SocialshareModule.base', 'Cannot delete default providers.'));

            return false;
        }

        return true;
    }

    /**
     * Get the driver class for this provider.
     *
     * @return string
     */
    public function getDriverClass()
    {
        $className = Inflector::id2camel($this->provider_id, '_') . 'Driver';
        $customDriverClass = 'humhub\\modules\\socialshare\\drivers\\' . $className;

        if (class_exists($customDriverClass)) {
            return $customDriverClass;
        }

        return BaseDriver::class;
    }

    /**
     * Instantiate and return the driver for this provider.
     *
     * @return BaseDriver
     */
    public function getDriver(): BaseDriver
    {
        $class = $this->getDriverClass();

        return new $class($this);
    }

    /**
     * Return the custom settings field definitions declared by this provider's driver.
     * Returns an empty array for drivers with no custom settings.
     *
     * @return array
     */
    public function getDriverCustomSettingsFields(): array
    {
        return call_user_func([$this->getDriverClass(), 'getCustomSettingsFields']);
    }
}
