<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class PersonSeeder extends AbstractSeed
{
	public function run(): void
	{
		$personTable = $this->table('person');
		$personTable->truncate();
		$specialtyPersonTable = $this->table('specialty_person');
		$specialtyPersonTable->truncate();
		$data = [
			[
				'lastname' => 'Doe',
				'firstname' => 'John',
				'gender' => 1,
				'birthday' => '2000-03-01',
			],
			[
				'lastname' => 'Smith',
				'firstname' => 'Jane',
				'gender' => 2,
				'birthday' => '2000-02-01',
			],
			[
				'lastname' => 'Johnson',
				'firstname' => 'Jack',
				'gender' => 1,
				'birthday' => '2000-04-01',
			],
			[
				'lastname' => 'Williams',
				'firstname' => 'Jill',
				'gender' => 2,
				'birthday' => '2000-05-01',
			],
			[
				'lastname' => 'Brown',
				'firstname' => 'Joe',
				'gender' => 1,
				'birthday' => '2000-06-01',
			]
		];

		$personTable->insert($data)->save();

	}
}
