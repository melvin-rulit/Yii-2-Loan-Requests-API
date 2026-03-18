<?php

namespace app\commands;

use yii\base\Exception;
use yii\console\Controller;
use app\models\User;

/**
 * Консольная команда для заполнения тестовых пользователей.
 *
 * Пример использования:
 * php yii user/seed
 */
class UserController extends Controller
{
    /**
     * Создаёт 10 тестовых пользователей.
     *
     * @return void
     * @throws Exception
     */
    public function actionSeed(): void
    {
        echo "Начинаем создание пользователей...\n";

        for ($i = 1; $i <= 10; $i++) {
            $user = new User();
            $user->username = "user$i";
            $user->email = "user$i@example.com";
            $user->password = password_hash("pass$i", PASSWORD_DEFAULT);
            $user->auth_key = \Yii::$app->security->generateRandomString(32);
            if ($user->save()) {
                echo "✅ User {$user->username} создан успешно.\n";
            } else {
                echo "❌ Не удалось создать пользователя {$user->username}:\n";
                foreach ($user->errors as $attribute => $messages) {
                    echo " - {$attribute}: " . implode(', ', $messages) . "\n";
                }
            }
        }

        echo "Готово! Созданы 10 тестовых пользователей.\n";
    }
}