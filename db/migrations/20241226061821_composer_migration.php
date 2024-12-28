<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ComposerMigration extends AbstractMigration
{

    public function change(): void
    {
        $table = $this->table('film');
        $table->removeColumn('is_new')->update();
        $table->addColumn('composer_id', 'integer', ['null' => true])->update();
        
    }
}
