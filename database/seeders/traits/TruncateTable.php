<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 2/28/2024
 * @time: 4:19 PM
 */

namespace Database\Seeders\traits;

use Illuminate\Support\Facades\DB;

trait TruncateTable
{
    protected function truncate(string $model): void
    {
        $model::truncate();
    }
}
