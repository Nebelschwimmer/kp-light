<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class PersonSeeder extends AbstractSeed
{
	public function run(): void
	{
		$table = $this->table('person');
		$table->truncate();
		$data = [
			[
				'lastname' => 'Doe',
				'firstname' => 'John',
				'gender' => 1,
				'birthday' => '2000-03-01',
				'type' => 1
			],
			[
				'lastname' => 'Smith',
				'firstname' => 'Jane',
				'gender' => 2,
				'birthday' => '2000-02-01',
				'type' => 2
			],
			[
				'lastname' => 'Johnson',
				'firstname' => 'Jack',
				'gender' => 1,
				'birthday' => '2000-04-01',
				'type' => 1
			],
			[
				'lastname' => 'Williams',
				'firstname' => 'Jill',
				'gender' => 2,
				'birthday' => '2000-05-01',
				'type' => 2
			],
			[
				'lastname' => 'Brown',
				'firstname' => 'Joe',
				'gender' => 1,
				'birthday' => '2000-06-01',
				'type' => 1
			]
		];

		$table->insert($data)->save();

	}
}
