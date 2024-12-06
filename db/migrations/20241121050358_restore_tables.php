<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class RestoreTables extends AbstractMigration
{
	public function change(): void
	{
		$this->table('film')
			->addColumn('name', 'string')
			->addColumn('genre_id', 'integer')
			->addColumn('release_year', 'string')
			->addColumn('director_id', 'integer')
			->addColumn('description', 'text')
			->addColumn('rating', 'integer')
			->create();
		$this->table('film_person', ['id' => false, 'primary_key' => ['film_id', 'person_id']])
			->addColumn('film_id', 'integer')
			->addColumn('person_id', 'integer')
			->create();
		$this->hastable('genre') ?: $this->table('genre')
			->addColumn('name', 'string')
			->create();
		$this->hasTable('person') ?: $this->table('person')
			->addColumn('lastname', 'string')
			->addColumn('firstname', 'string')
			->addColumn('gender', 'smallinteger')
			->addColumn('birthday', 'datetime')
			->addColumn('photo', 'string', ['null' => true])
			->create();
		$this->table('specialty')
			->addColumn('name', 'string')
			->create();
		$this->table('specialty_person', ['id' => false, 'primary_key' => ['specialty_id', 'person_id']])
			->addColumn('specialty_id', 'integer')
			->addColumn('person_id', 'integer')
			->create();
	}
}
