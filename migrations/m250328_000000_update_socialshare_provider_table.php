<?php

use humhub\components\Migration;
use humhub\modules\socialshare\drivers\BaseDriver;

/**
 * Adds custom_settings column to socialshare_provider table
 * and installs any newly added default providers.
 */
class m250328_000000_update_socialshare_provider_table extends Migration
{
    /**
     * @inheritdoc
     */
    protected string $table = 'socialshare_provider';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        if ($this->db->schema->getTableSchema($this->table, true) === null) {
            return true;
        }

        $this->safeAddColumn(
            $this->table,
            'custom_settings',
            $this->text()->null()->after('is_default'),
        );

        BaseDriver::initializeDefaults();

        return true;
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        if ($this->db->schema->getTableSchema($this->table, true) === null) {
            return true;
        }

        $this->safeDropColumn($this->table, 'custom_settings');

        return true;
    }
}
