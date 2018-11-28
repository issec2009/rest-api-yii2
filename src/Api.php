<?php

namespace issec2009\api;

use yii\base\BootstrapInterface;

/**
 * api module definition class
 */
class Api extends \yii\base\Module implements BootstrapInterface
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'issec2009\api\controllers';
//    public $defaultRoute = 'api-driver';
    public $defaultController = 'driver';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }

    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            ['class' => 'yii\rest\UrlRule', 'controller' => ['api/driver']],
        ], false);

        if ($app instanceof \yii\console\Application) {
            $this->controllerNamespace = 'issec2009\api\commands';
        }
    }
}
