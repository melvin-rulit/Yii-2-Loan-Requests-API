<?php

namespace app\models\forms;

use yii\base\Model;

/**
 * Форма подачи заявки на займ.
 *
 * Отвечает за валидацию входящих данных при создании новой заявки.
 * Взаимодействие с базой происходит через ActiveRecord LoanRequest.
 *
 * @property int $user_id ID пользователя, подающего заявку
 * @property int $amount Сумма займа
 * @property int $term Срок займа в днях
 */
class LoanRequestForm extends Model
{
    /**
     * @var int|null ID пользователя
     */
    public ?int $user_id = null;

    /**
     * @var int|null Сумма займа
     */
    public ?int $amount = null;

    /**
     * @var int|null Срок займа
     */
    public ?int $term = null;

    /**
     * Правила валидации формы.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            [['user_id', 'amount', 'term'], 'required', 'message' => 'Поле "{attribute}" не может быть пустым'],
            [['user_id', 'amount', 'term'], 'integer', 'message' => 'Поле "{attribute}" должно быть числом'],
            [['user_id', 'amount', 'term'], 'integer', 'min' => 1, 'tooSmall' => 'Поле "{attribute}" должно быть больше или равно 1'],
        ];
    }

    /**
     * Метки атрибутов формы.
     *
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'user_id' => 'ID пользователя',
            'amount' => 'Сумма займа',
            'term' => 'Срок займа',
        ];
    }
}