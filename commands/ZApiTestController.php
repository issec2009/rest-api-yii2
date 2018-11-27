<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace issec2009\api\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\httpclient\Client;
use yii\helpers\Url;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ZApiTestController extends Controller
{
    public $action;
    public $url = 'http://127.0.0.1';

    public function send($request)
    {
        echo "POST request \n\n\n";

        $client = new Client(['baseUrl' => $this->url, 'transport' => 'yii\httpclient\CurlTransport']);
        $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl($this->action)
            ->setData($request)
            ->setOptions([
//                CURLOPT_HTTPHEADER => "Content-type: multipart/form-data"
                CURLOPT_HTTPHEADER => "Content-Type: application/json"
            ])
            ->send();

//            var_dump($response->content);
        $response = json_decode($response->content, true);

        $request = print_r($request, true);
        echo "Запрос: $request";
        $response = print_r($response, true);
        echo "Ответ: " . $response . " \n\n";
    }

    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionCreateDriver()
    {
        $this->action = "api-drivers";

        $request = [
            "name" => "Василий",
            "birth_date" => "05.06.1856",
            "buses" => [
                [
                    "name" => "Автобус1",
                    "avg_speed" => "50"
                ],
                [
                    "name" => "Автобус2",
                    "avg_speed" => "70"
                ]
            ]
        ];

        $this->send($request);
    }


}
