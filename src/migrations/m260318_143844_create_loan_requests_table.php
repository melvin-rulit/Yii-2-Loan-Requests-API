<?php

use yii\db\Migration;

/**
 * Миграция для создания таблицы заявок на займ (loan_requests).
 */
class m260318_143844_create_loan_requests_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp(): void
    {
        $this->createTable('{{%loan_requests}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'amount' => $this->integer(),
            'term' => $this->integer(),
            'status' => $this->string(),
            'created_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->timestamp()->defaultExpression('CURRENT_TIMESTAMP'),
        ]);

        $this->createIndex(
            'idx-loan_requests-user_id',
            '{{%loan_requests}}',
            'user_id'
        );

        $this->addForeignKey(
            'fk-loan_requests-user_id',
            '{{%loan_requests}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown(): void
    {
        $this->dropForeignKey('fk-loan_requests-user_id', '{{%loan_requests}}');
        $this->dropIndex('idx-loan_requests-user_id', '{{%loan_requests}}');
        $this->dropTable('{{%loan_requests}}');
    }
}