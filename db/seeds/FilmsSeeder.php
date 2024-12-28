<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class FilmsSeeder extends AbstractSeed
{
	public function run(): void
	{
		$this->table('film')->truncate();
		$this->table('film_person')->truncate();
		
		$data = [
			[
				'name' => 'The Shawshank Redemption',
				'release_year' => '1994',
				'genres' => "[1, 2]",
				'description' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
				'rating' => 0.0,
				'duration'=> '2:22:00',
				'age' => 18,
			],
			[
				'name' => 'The Godfather',
				'release_year' => '1972',
				'genres' => "[1, 2]",
				'description' => 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.',
				'rating' => 2.2,
				'duration'=> '2:55:00',
				'age' => 18,
			],
			[
				'name' => 'The Dark Knight',
				'release_year' => '2008',
				'genres' => "[2]",
				'description'=> 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of his greatest challenges as a hero: to prevent crimes of mass destruction.',
				'rating' => 4.1,
				'duration'=> '2:32:00',
				'age' => 16,
			],
			[
				'name' => 'Dumb and Dumber',
				'release_year' => '1994',
				'genres' => "[3]",
				'description' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
				'rating' => 1.3,
				'duration'=> '1:53:00',
				'age' => 13,
			],
			[
				'name' => 'The Matrix',
				'release_year' => '1999',
				'genres' => "[2, 7]",
				'description' => 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war on reality.',
				'rating' => 5.0,
				'duration'=> '2:16:00',
				'age' => 16,
			]
		];
		$this->table('film')->insert($data)->save();

	}
}
