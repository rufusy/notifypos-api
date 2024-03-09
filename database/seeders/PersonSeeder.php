<?php

namespace Database\Seeders;

use App\Models\Person;
use Database\Seeders\traits\DisableForeignKeys;
use Database\Seeders\traits\TruncateTable;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();

        $this->truncate(Person::class);

        $this->enableForeignKeys();
    }
}
