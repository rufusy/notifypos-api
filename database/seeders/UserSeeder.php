<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 2/28/2024
 * @time: 4:12 PM
 */

namespace Database\Seeders;

use App\Models\Person;
use App\Models\User;
use Database\Seeders\traits\DisableForeignKeys;
use Database\Seeders\traits\TruncateTable;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKeys();

        $this->truncate(User::class);

        User::factory(20)->create();

        $this->enableForeignKeys();
    }
}
