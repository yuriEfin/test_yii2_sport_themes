<?php

use yii\db\Migration;

class m160228_214052_create_table_user extends Migration
{

    public function up()
    {
        $this->createTable('wq3_user',
                [
            'id' => $this->primaryKey(),
            'username' => 'string COMMENT "Имя пользователя"',
            'email' => 'string COMMENT "Эл. почта"',
            'password_hash' => 'string COMMENT "hash пароля"',
            'status' => 'string COMMENT "Статус пользователя"',
            'created_at' => 'datetime COMMENT "Добавлено дата.время"',
            'updated_at' => 'datetime COMMENT "Обнолвено дата.время"',
            'email_confirm_token' => 'string COMMENT "Токен email"',
        ]);

        $t = $this->getDb()->getSchema()->getTableNames('wq3_user', true);
        if ($t) {
            $this->createIndex('xusername', $t->name, 'username');
            $this->createIndex('xemail_st', $t->name, ['email', 'status']);
            $this->createIndex('xtoken', $t->name, 'email_confirm_token');
        }
    }

    public function down()
    {
        $this->dropTable('wq3_user');
    }

}
