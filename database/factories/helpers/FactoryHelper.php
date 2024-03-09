<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 2/28/2024
 * @time: 3:41 PM
 */

namespace Database\Factories\helpers;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class FactoryHelper
{
    /**
     * Get Random id from database
     * @param string | HasFactory $model
     * @return int
     */
    public static function getRandomModelId(string $model): int
    {
        $count = $model::query()->count();

        if($count === 0) {
            return $model::factory()->create()->id;
        } else {
            return rand(1, $count);
        }
    }
}
