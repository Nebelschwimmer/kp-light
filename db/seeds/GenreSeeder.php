<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class GenreSeeder extends AbstractSeed
{
	public function run(): void
	{
		$table = $this->table('genre');
		$table->truncate();
		$data = [
			[
				'name' => 'drama'
			],
			[
				'name' => 'action'
			],
			[
				'name' => 'comedy'
			],
			[
				'name' => 'sci-fi'
			],
		];
		$table->insert($data)->save();

	}
}
