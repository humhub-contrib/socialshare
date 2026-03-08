<?php

use humhub\components\Migration;

/**
 * Fixes sort_order values for socialshare_provider table
 */
class m241210_000001_fix_socialshare_provider_sort_order extends Migration
{
    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->update('socialshare_provider', 
            ['sort_order' => new \yii\db\Expression('id * 100')], 
            ['sort_order' => 100]
        );

        $defaultProviders = [
            'facebook' => 100,
            'x' => 200,
            'linkedin' => 300,
            'line' => 400,
            'bluesky' => 500
        ];

        foreach ($defaultProviders as $providerId => $sortOrder) {
            $this->update('socialshare_provider',
                ['sort_order' => $sortOrder],
                ['provider_id' => $providerId]
            );
        }

        $this->update('socialshare_provider',
            ['sort_order' => 100],
            ['and',
                ['is_default' => 0],
                ['or',
                    ['sort_order' => 100],
                    ['sort_order' => null]
                ]
            ]
        );

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        echo "m241210_000001_fix_socialshare_provider_sort_order cannot be reverted.\n";
        return true;
    }
}