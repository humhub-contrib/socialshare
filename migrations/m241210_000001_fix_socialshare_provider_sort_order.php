<?php

use humhub\components\Migration;

class m241210_000001_fix_socialshare_provider_sort_order extends Migration
{
    public function safeUp()
    {
        $this->update(
            'socialshare_provider',
            ['sort_order' => new \yii\db\Expression('id * 100')],
            ['sort_order' => 100],
        );

        foreach ($this->getDefaultProviders() as $providerId => $sortOrder) {
            $this->update('socialshare_provider', ['sort_order' => $sortOrder], ['provider_id' => $providerId]);
        }

        $this->update(
            'socialshare_provider',
            ['sort_order' => 100],
            ['and',
                ['is_default' => 0],
                ['or', ['sort_order' => 100], ['sort_order' => null]],
            ],
        );

        return true;
    }

    public function safeDown()
    {
        foreach ($this->getDefaultProviders() as $providerId => $sortOrder) {
            $this->update('socialshare_provider', ['sort_order' => array_search($providerId, array_keys($this->getDefaultProviders()), true) + 1], ['provider_id' => $providerId]);
        }

        $this->update(
            'socialshare_provider',
            ['sort_order' => 100],
            ['and', ['is_default' => 0], ['>=', 'sort_order', 100]],
        );

        return true;
    }

    private function getDefaultProviders(): array
    {
        return [
            'facebook' => 100,
            'x' => 200,
            'linkedin' => 300,
            'line' => 400,
            'bluesky' => 500,
        ];
    }
}
