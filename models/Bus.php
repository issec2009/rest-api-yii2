<?php

namespace issec2009\api\models;

use Yii;

/**
 * This is the model class for table "bus".
 *
 * @property int $id
 * @property int $driver_id
 * @property string $name
 * @property int $avg_speed
 *
 * @property Driver $driver
 */
class Bus extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bus';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'avg_speed'], 'required'],
            [['driver_id', 'avg_speed'], 'integer'],
            [['name'], 'string'],
            [['driver_id'], 'exist', 'skipOnError' => true, 'targetClass' => Driver::className(), 'targetAttribute' => ['driver_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'driver_id' => 'Driver ID',
            'name' => 'Name',
            'avg_speed' => 'Avg Speed',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriver()
    {
        return $this->hasOne(Driver::className(), ['id' => 'driver_id']);
    }
}
