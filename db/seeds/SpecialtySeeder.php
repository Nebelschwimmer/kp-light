<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class SpecialtySeeder extends AbstractSeed
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'actor',
            ],
            [
                'name' => 'director',
            ],
            [
                'name' => 'producer',
            ],
        ];

        $table = $this->table('specialty');
        $table->truncate();
        $table->insert($data)->save();

    }
}
