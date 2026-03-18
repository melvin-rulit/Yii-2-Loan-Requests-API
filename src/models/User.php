<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Модель пользователя
 *
 * Колонки таблицы: id, username, email, password, auth_key, created_at, updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * Название таблицы в базе данных
     */
    public static function tableName(): string
    {
        return '{{%users}}';
    }

    /**
     * Находим пользователя по ID
     *
     * @param int $id
     * @return static|null
     */
    public static function findIdentity($id): ?self
    {
        return static::findOne($id);
    }

    /**
     * Находим пользователя по токену доступа
     *
     * @param string $token
     * @param null $type
     * @return static|null
     */
    public static function findIdentityByAccessToken($token, $type = null): ?self
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * Находим пользователя по username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername(string $username): ?self
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey(): string
    {
        return $this->auth_key;
    }

    /**
     * Проверка токена авторизации
     *
     * @param string $authKey
     * @return bool
     */
    public function validateAuthKey($authKey): bool
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Проверка пароля
     *
     * @param string $password
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}