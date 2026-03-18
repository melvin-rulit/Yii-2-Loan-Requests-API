<?php

namespace app\services;

use app\models\forms\LoanRequestForm;
use app\models\LoanRequest;


class LoanRequestService
{
    /**
     * Проверяет, есть ли у пользователя одобренные заявки.
     */
    public function hasApprovedRequest(int $userId): bool
    {
        return LoanRequest::find()
            ->where(['user_id' => $userId, 'status' => 'approved'])
            ->exists();
    }


    /**
     * Создаёт новую заявку на займ.
     *
     * @param LoanRequestForm $form Данные формы для заявки
     * @return LoanRequest|null Возвращает объект LoanRequest при успешном сохранении, иначе null
     */
    public function createRequest(LoanRequestForm $form): ?LoanRequest
    {
        $loan = new LoanRequest();
        $loan->user_id = $form->user_id;
        $loan->amount = $form->amount;
        $loan->term = $form->term;
        $loan->status = 'pending';

        return $loan->save() ? $loan : null;
    }

    /**
     * Решает статус заявки: "approved" или "declined".
     *
     * @param int $userId
     * @return string
     */
    public function decideStatus(int $userId): string
    {
        if ($this->hasApprovedRequest($userId)) {
            return 'declined';
        }

        return (rand(1, 100) <= 10) ? 'approved' : 'declined';
    }

    /**
     * Возвращает все заявки на займ, которые ещё не обработаны.
     *
     * Заявки считаются "необработанными", если их поле `status` равно `null`.
     *
     * @return LoanRequest[] Массив объектов LoanRequest с необработанным статусом
     */
    public function getPendingRequests(): array
    {
        return LoanRequest::find()->where(['status' => 'pending'])->all();
    }
}