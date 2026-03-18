<?php

namespace app\components;

use Yii;
use yii\web\Response;

class ApiResponseHelper
{
    /**
     * Возвращает успешный ответ.
     *
     * @param array $data Дополнительные данные
     * @param int $statusCode HTTP код
     * @return array
     */
    public static function success(array $data = [], int $statusCode = 200): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = $statusCode;
        return array_merge(['result' => true], $data);
    }

    /**
     * Возвращает ошибочный ответ.
     *
     * @param array $data Дополнительные данные
     * @param int $statusCode HTTP код
     * @return array
     */
    public static function error(array $data = [], int $statusCode = 400): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->statusCode = $statusCode;
        return array_merge(['result' => false], $data);
    }
}