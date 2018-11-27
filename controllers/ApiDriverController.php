<?php

namespace issec2009\api\controllers;

use app\models\Bus;
use app\models\Driver;
use app\models\DriverBus;
use Yii;
use yii\rest\ActiveController;

class ApiDriverController extends ActiveController
{
    public $modelClass = 'app\models\Driver';
    public $response = ['status' => false, 'error' => '', 'data' => ''];

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['create'], $actions['index']);
        return $actions;
    }

    /**
    * Creates a new Driver model.
    * If creation is successful, be returned the Driver id.
    * @return array
    */
    public function actionIndex(){
        $count = Yii::$app->request->post('count') ?? 10;
        $page_num = Yii::$app->request->post('page_num') ?? 0;

        $driver_models = Driver::find()
            ->select("
                `id`,
                `name`, 
                `birth_date`,
                (YEAR(CURRENT_DATE)-YEAR(`birth_date`))-(RIGHT(CURRENT_DATE,5)<RIGHT(`birth_date`,5)
                ) AS `age`
            ")
            ->limit($count)
            ->offset($page_num * $count)
            ->orderBy('name DESC')
            ->all();

        return $driver_models;
    }

    /**
    * Creates a new Driver model.
    * If creation is successful, be returned the Driver id.
    * @return array
    */
    public function actionCreate(){
        $driver_model = new Driver();
        $driver_model->attributes = Yii::$app->request->post();

        if ($driver_model->validate() && $driver_model->save()) {
            $this->response["status"] = true;
            $this->response['data'] = $driver_model;
        } else {
            $this->response['error'] = $driver_model->getErrors();
        }
        return $this->response;
    }
}