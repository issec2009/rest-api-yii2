<?php

use yii\db\Migration;

/**
 * Handles the creation of table `bus`.
 * Has foreign keys to the tables:
 *
 * - `driver`
 */
class m181121_145454_create_bus_table extends Migration
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

        $this->createTable('{{%bus}}', [
            'id' => $this->primaryKey(),
            'driver_id' => $this->integer()->notNull(),
            'name' => $this->text()->notNull(),
            'avg_speed' => $this->integer()->notNull(),
        ], $tableOptions);

        // creates index for column `driver_id`
        $this->createIndex(
            'idx-bus-driver_id',
            'bus',
            'driver_id'
        );

        // add foreign key for table `driver`
        $this->addForeignKey(
            'fk-bus-driver_id',
            'bus',
            'driver_id',
            'driver',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `driver`
        $this->dropForeignKey(
            'fk-bus-driver_id',
            'bus'
        );

        // drops index for column `driver_id`
        $this->dropIndex(
            'idx-bus-driver_id',
            'bus'
        );

        $this->dropTable('bus');
    }
}
