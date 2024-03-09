<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Database\Seeders\traits\DisableForeignKeys;
use Database\Seeders\traits\TruncateTable;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();

        $this->truncate(Supplier::class);

        Supplier::factory(100)->create();

        $this->enableForeignKeys();
    }
}
