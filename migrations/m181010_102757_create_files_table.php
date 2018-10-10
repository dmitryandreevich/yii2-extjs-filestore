<?php

use yii\db\Migration;

/**
 * Handles the creation of table `files`.
 */
class m181010_102757_create_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

        $this->createTable('files', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'extension' => $this->string(),
            'size' => $this->integer(),
            'created' => $this->integer(),
            'content' => $this->binary()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('files');
    }
}
