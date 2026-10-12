<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTrelloTables extends AbstractMigration
{
    public function change(): void
    {
        $this->table('users', ['id' => 'user_id'])
            ->addColumn('email', 'string', ['limit' => 255])
            ->addColumn('password_hash', 'string', ['limit' => 255])
            ->addColumn('name', 'string', ['limit' => 255])
            ->addColumn('created_datetime', 'timestamp',
                ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_datetime', 'timestamp', ['null' => true])
            ->addIndex(['email'], ['unique' => true])
            ->create();

        $this->table('boards', ['id' => 'board_id'])
            ->addColumn('title', 'string', ['limit' => 255])
            ->addColumn('owner_user_id', 'integer')
            ->addColumn('is_public', 'boolean', ['default' => false])
            ->addColumn('created_datetime', 'timestamp',
                ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_datetime', 'timestamp', ['null' => true])
            ->addForeignKey('owner_user_id', 'users', 'user_id',
                ['delete' => 'CASCADE'])
            ->create();

        $this->table('board_columns', ['id' => 'column_id'])
            ->addColumn('board_id', 'integer')
            ->addColumn('ordinal_position', 'integer')
            ->addColumn('title', 'string', ['limit' => 255])
            ->addColumn('color', 'string',
                ['limit' => 6, 'null' => true])
            ->addIndex(['board_id'])
            ->addForeignKey('board_id', 'boards', 'board_id',
                ['delete' => 'CASCADE'])
            ->create();

        $this->table('cards', ['id' => 'card_id'])
            ->addColumn('board_id', 'integer')
            ->addColumn('column_id', 'integer')
            ->addColumn('sort_index', 'integer')
            ->addColumn('title', 'string', ['limit' => 255])
            ->addColumn('content', 'text', ['null' => true])
            ->addColumn('color', 'string',
                ['limit' => 6, 'null' => true])
            ->addColumn('is_archived', 'boolean', ['default' => false])
            ->addColumn('created_datetime', 'timestamp',
                ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_datetime', 'timestamp', ['null' => true])
            ->addIndex(['board_id', 'is_archived'])
            ->addForeignKey('board_id', 'boards', 'board_id',
                ['delete' => 'CASCADE'])
            ->addForeignKey('column_id', 'board_columns', 'column_id',
                ['delete' => 'CASCADE'])
            ->create();
    }
}
