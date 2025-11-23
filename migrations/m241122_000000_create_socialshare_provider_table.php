<?php

use humhub\components\Migration;
use humhub\modules\socialshare\drivers\BaseDriver;

/**
 * Handles the creation of table `socialshare_provider`.
 */
class m241122_000000_create_socialshare_provider_table extends Migration
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
        if ($this->db->schema->getTableSchema($this->table, true) !== null) {
            return true;
        }

        $this->safeCreateTable($this->table, [
            'id' => $this->primaryKey(),
            'provider_id' => $this->string(50)->notNull()->unique(),
            'name' => $this->string(100)->notNull(),
            'url_pattern' => $this->string(500)->notNull(),
            'icon_class' => $this->string(100)->notNull(),
            'icon_color' => $this->string(7)->notNull()->defaultValue('#000000'),
            'enabled' => $this->boolean()->notNull()->defaultValue(1),
            'sort_order' => $this->integer()->notNull()->defaultValue(0),
            'is_default' => $this->boolean()->notNull()->defaultValue(0),
            'created_at' => $this->dateTime(),
            'created_by' => $this->integer(),
            'updated_at' => $this->dateTime(),
            'updated_by' => $this->integer(),
        ]);

        $this->safeCreateIndex(
            'idx-socialshare_provider-enabled',
            $this->table,
            'enabled'
        );

        $this->safeCreateIndex(
            'idx-socialshare_provider-sort_order',
            $this->table,
            'sort_order'
        );

        $this->safeAddForeignKeyCreatedBy();
        $this->safeAddForeignKeyUpdatedBy();

        BaseDriver::initializeDefaults();

        return true;
    }
}