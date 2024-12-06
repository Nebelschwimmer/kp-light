<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RemovePersonType extends AbstractMigration
{
    public function change(): void
    {
        // $this->table('person')
        //     ->removeColumn('type')
        //     ->update();
    }
}
