<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use app\components\ApiResponseHelper;
use app\models\forms\LoanRequestForm;
use yii\base\InvalidConfigException;
use app\services\LoanRequestService;

class LoanRequestController extends Controller
{
    public $enableCsrfValidation = false;
    private LoanRequestService $loanService;


    public function __construct($id, $module, LoanRequestService $loanService, $config = [])
    {
        $this->loanService = $loanService;
        parent::__construct($id, $module, $config);
    }

    /**
     * Подача новой заявки на займ.
     *
     * При успешном создании возвращает HTTP 201 и массив с result и id.
     * В случае ошибки валидации или бизнес-правил возвращает HTTP 400 и массив с result: false.
     *
     * @return array
     * @throws InvalidConfigException
     */
    public function actionCreate(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $form = new LoanRequestForm();
        $data = Yii::$app->request->getBodyParams();
        $form->load($data, '');

        if (!$form->validate()) {
            return ApiResponseHelper::error();
        }

        if ($this->loanService->hasApprovedRequest($form->user_id)) {
            return ApiResponseHelper::error();
        }

        $loan = $this->loanService->createRequest($form);

        if ($loan) {
            return ApiResponseHelper::success(['id' => $loan->id], 201);
        }

        return ApiResponseHelper::error();
    }

    /**
     * Запуск обработки заявок на займ.
     *
     * При успешной обработке всех необработанных заявок возвращает HTTP 200 и массив с result: true.
     * Параметр delay можно передавать в GET-запросе: /processor?delay=5
     * Если delay не указан, берется из конфигурации Yii::$app->params['loanProcessingDelay'].
     *
     * @return array
     */
    public function actionProcess(): array
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $delay = (int)Yii::$app->request->get('delay', Yii::$app->params['loanProcessingDelay']);
        $requests = $this->loanService->getPendingRequests();

        foreach ($requests as $request) {
            sleep($delay);

            $request->status = $this->loanService->decideStatus($request->user_id);
            $request->save(false);
        }

        return ApiResponseHelper::success();
    }
}