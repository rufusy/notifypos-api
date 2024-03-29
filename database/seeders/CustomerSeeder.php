<?php

namespace Database\Seeders;

use App\Models\Customer;
use Database\Seeders\traits\DisableForeignKeys;
use Database\Seeders\traits\TruncateTable;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();

        $this->truncate(Customer::class);

        Customer::factory(100)->create();

        $this->enableForeignKeys();
    }
}
