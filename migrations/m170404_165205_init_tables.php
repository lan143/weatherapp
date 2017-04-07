<?php

use yii\db\Migration;

class m170404_165205_init_tables extends Migration
{
    public function safeUp()
    {
        $this->createTable('cities', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'postal_code' => $this->integer(6)->unsigned()->notNull(),
            'country_code' => $this->string(10)->notNull()
        ]);

        $this->createTable('weather_data', [
            'id' => $this->primaryKey(),
            'city_id' => $this->integer(11)->unsigned()->notNull(),
            'date' => $this->integer(11)->unsigned()->notNull(),
            'temp' => $this->decimal(5, 2)->notNull(),
        ]);

        $this->createIndex('idx_city_id', 'weather_data', 'city_id');
        $this->createIndex('idx_city_date', 'weather_data', ['city_id', 'date']);
    }

    public function safeDown()
    {
        $this->dropTable('cities');
        $this->dropTable('weather_data');
    }
}
