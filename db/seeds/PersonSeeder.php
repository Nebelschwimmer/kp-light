<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class PersonSeeder extends AbstractSeed
{
	public function run(): void
	{
		$personTable = $this->table('person');
		$personTable->truncate();
		$data = [
			[
				'lastname' => 'Doe',
				'firstname' => 'John',
				'gender' => 1,
				'birthday' => '2000-03-01',
				'specialties' => "[1]"
			],
			[
				'lastname' => 'Smith',
				'firstname' => 'Jane',
				'birthday' => '1991-02-01',
				'gender' => 2,
				'specialties' => "[1, 2]"
			],
			[
				'lastname' => 'Johnson',
				'firstname' => 'Jack',
				'birthday' => '1993-02-01',
				'gender' => 1,
				'specialties' => "[3]"
			],
			[
				'lastname' => 'Williams',
				'firstname' => 'Jill',
				'gender' => 2,
				'birthday' => '1997-05-01',
				'specialties' => "[4]"
			],
			[
				'lastname' => 'Brown',
				'firstname' => 'Joe',
				'gender' => 1,
				'birthday' => '1977-06-01',
				'specialties' => "[5, 1]"
			],
			[
				'lastname' => 'Пупкин',
				'firstname' => 'Василий',
				'gender' => 1,
				'birthday' => '1987-03-01',
				'specialties' => "[5, 1, 2]"
			]
		];

		$personTable->insert($data)->save();

	}
}
