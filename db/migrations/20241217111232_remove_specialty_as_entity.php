<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RemoveSpecialtyAsEntity extends AbstractMigration
{
    public function change(): void
    {

        // $this->table('specialty')
        //     ->drop()
        //     ->save();
        // $this->table('specialty_person')->drop()->save();
        // $this->table('person')->addColumn('specialties', 'json', ['null' => true])->update();
    }
}
