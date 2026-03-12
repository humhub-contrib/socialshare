<?php

use humhub\components\Migration;

class uninstall extends Migration
{
    public function up()
    {
        $this->safeDropTable('socialshare_provider');
    }

    public function down()
    {
        echo "uninstall does not support migration down.\n";
        return false;
    }
}
