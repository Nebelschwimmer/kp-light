<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class GenreEnumMigration extends AbstractMigration
{
    public function change(): void
    {

        // $this->table('genre')->drop()->save();
        // $this->table('film')->removeColumn('genre_id')
        // ->addColumn('genres', 'json', ['null' => true])
        // ->update();

    }
}
