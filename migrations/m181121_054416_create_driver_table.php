<?php

use yii\db\Migration;

/**
 * Handles the creation of table `driver`.
 */
class m181121_054416_create_driver_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%driver}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text()->notNull(),
            'birth_date' => $this->date()->defaultValue(NULL),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('driver');
    }
}
