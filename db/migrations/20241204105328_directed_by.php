<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class DirectedBy extends AbstractMigration
{

    public function change(): void
    {
        $this->table('film')->truncate();
        $this->table('film')->renameColumn('director_id', 'directed_by_id')->update();

    }
}
