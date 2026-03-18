<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Модель заявки на займ.
 *
 * @property int $id Идентификатор заявки
 * @property int $user_id Идентификатор пользователя
 * @property int $amount Сумма займа
 * @property int $term Срок займа в днях
 * @property string|null $status Статус заявки: "approved", "declined" или null
 * @property string $created_at Дата и время создания
 * @property string $updated_at Дата и время последнего обновления
 */
class LoanRequest extends ActiveRecord
{
    /**
     * Название таблицы в базе данных
     */
    public static function tableName(): string
    {
        return '{{%loan_requests}}';
    }

    /**
     * Правила валидации
     */
    public function rules(): array
    {
        return [
            [['user_id', 'amount', 'term'], 'integer'],
            ['status', 'string'],
        ];
    }

    /**
     * Метки атрибутов
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID заявки',
            'user_id' => 'ID пользователя',
            'amount' => 'Сумма займа',
            'term' => 'Срок займа',
            'status' => 'Статус',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }
}