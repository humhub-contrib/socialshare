<?php

namespace humhub\modules\socialshare\models;

use humhub\components\ActiveRecord;
use Yii;

/**
 * @property int $id
 * @property string $provider_id
 * @property string $name
 * @property string $url_pattern
 * @property string $icon_class
 * @property string $icon_color
 * @property bool $enabled
 * @property int $sort_order
 * @property bool $is_default
 */
class SocialShareProvider extends ActiveRecord
{
    public static function tableName()
    {
        return 'socialshare_provider';
    }

    public function rules()
    {
        return [
            [['provider_id', 'name', 'url_pattern', 'icon_class', 'icon_color'], 'trim'],
            ['provider_id', 'filter', 'filter' => 'strtolower'],
            [['provider_id', 'name', 'url_pattern', 'icon_class'], 'required'],
            ['provider_id', 'string', 'max' => 50],
            ['provider_id', 'unique'],
            ['provider_id', 'match', 'pattern' => '/^[a-z0-9_]+$/', 'message' => Yii::t('SocialshareModule.base', 'Provider ID can only contain lowercase letters, numbers, and underscores.')],
            ['name', 'string', 'max' => 100],
            ['url_pattern', 'string', 'max' => 500],
            ['url_pattern', 'match', 'pattern' => '/^https?:\/\//i', 'message' => Yii::t('SocialshareModule.base', 'URL pattern must start with http:// or https://.')],
            ['url_pattern', 'validateUrlPattern'],
            ['icon_class', 'string', 'max' => 100],
            ['icon_class', 'match', 'pattern' => '/^[a-z0-9-]+$/i', 'message' => Yii::t('SocialshareModule.base', 'Icon class can only contain letters, numbers and dashes.')],
            ['icon_color', 'string', 'max' => 7],
            ['icon_color', 'match', 'pattern' => '/^#[0-9A-Fa-f]{6}$/', 'message' => Yii::t('SocialshareModule.base', 'Icon color must be a valid hex color code.')],
            ['icon_color', 'default', 'value' => '#000000'],
            [['enabled', 'is_default'], 'boolean'],
            ['sort_order', 'integer'],
            ['sort_order', 'default', 'value' => 100],
            ['enabled', 'default', 'value' => true],
            ['is_default', 'default', 'value' => false],
        ];
    }

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
        ];
    }

    /**
     * @return static[]
     */
    public static function getEnabled(): array
    {
        return static::find()
            ->where(['enabled' => true])
            ->orderBy(['sort_order' => SORT_ASC, 'name' => SORT_ASC])
            ->all();
    }

    public static function findByProviderId(string $providerId): ?self
    {
        return static::findOne(['provider_id' => $providerId]);
    }

    /**
     * @return static[]
     */
    public static function getDefaults(): array
    {
        return static::find()
            ->where(['is_default' => true])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();
    }

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

    public function beforeSave($insert)
    {
        if (!$insert) {
            $this->provider_id = (string) $this->getOldAttribute('provider_id');
            $this->is_default = (bool) $this->getOldAttribute('is_default');
        }

        return parent::beforeSave($insert);
    }

    public function getDriverClass(): string
    {
        $driverMap = [
            'bluesky' => 'BlueSkyDriver',
        ];
        $driverName = $driverMap[$this->provider_id]
            ?? str_replace(' ', '', ucwords(str_replace('_', ' ', $this->provider_id))) . 'Driver';
        $driverClass = 'humhub\\modules\\socialshare\\drivers\\' . $driverName;

        return class_exists($driverClass) ? $driverClass : 'humhub\\modules\\socialshare\\drivers\\BaseDriver';
    }

    public function validateUrlPattern(string $attribute): void
    {
        if (
            strpos($this->$attribute, '{url}') === false
            && strpos($this->$attribute, '{text}') === false
        ) {
            $this->addError($attribute, Yii::t('SocialshareModule.base', 'URL pattern must contain at least one placeholder: {url} or {text}.'));
        }
    }
}
