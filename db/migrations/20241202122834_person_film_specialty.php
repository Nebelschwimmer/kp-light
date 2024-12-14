<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class PersonFilmSpecialty extends AbstractMigration
{
    public function change(): void
    {
        $this->table('person_film_specialty', ['id' => false, 'primary_key' => ['person_id', 'film_id', 'specialty_id']])
            ->addColumn('person_id', 'integer')
            ->addColumn('film_id', 'integer')
            ->addColumn('specialty_id', 'integer')
            ->create();


    }
}
