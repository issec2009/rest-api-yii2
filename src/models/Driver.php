<?php

namespace issec2009\api\models;

use Yii;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "driver".
 *
 * @property int $id
 * @property string $name
 * @property string $birth_date
 *
 * @property Bus[] $buses
 */
class Driver extends ActiveRecord
{
    public $buses;
    public $age;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'driver';
    }

    public function fields() {

        return ['id', 'name', 'birth_date', 'age'];
    }

    public function behaviors()
    {
        return [
            [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['birth_date']
                ],
                'value' => function ($event) {
                    return date('Y-m-d', strtotime($this->birth_date));
                },
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'birth_date', 'buses'], 'required'],
            [['name'], 'string'],
            [['birth_date', 'age'], 'safe'],
            [['birth_date'], 'date', 'format' => 'm.d.Y'],
            [['buses'], 'busesValidator']
        ];
    }

    /**
     * @param $attribute
     * @param $params
     */
    public function busesValidator($attribute, $params)
    {
        if (is_array($this->buses)) {
            $bus_model = new Bus();
            foreach ($this->buses as $bus) {
                $bus_model->attributes = $bus;
                if (!$bus_model->validate()) {
                    $this->addError($attribute, 'Некорректный автобус');
                    break;
                }
            }
        }
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     */
    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);

        foreach ($this->buses as $bus) {
            $bus_model = new Bus();
            $bus_model->attributes = $bus;
            $bus_model->driver_id = $this->id;
            $bus_model->save();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'age' => 'Аge',
            'birth_date' => 'Birth Date',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuses()
    {
        return $this->hasMany(Bus::className(), ['driver_id' => 'id']);
    }
}
