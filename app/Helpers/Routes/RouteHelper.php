<?php
/**
 * @author Rufusy Idachi <idachirufus@gmail.com>
 * @date: 4/14/2024
 * @time: 11:57 AM
 */

namespace App\Helpers\Routes;

class RouteHelper
{
    public static function includeRouteFiles(string $folder): void
    {
        $dirIterator = new \RecursiveDirectoryIterator($folder);

        /** @var \RecursiveDirectoryIterator | \RecursiveIteratorIterator $it */
        $it = new \RecursiveIteratorIterator($dirIterator);

        while ($it->valid()){
            if(!$it->isDot()
                && $it->isFile()
                && $it->isReadable()
                && $it->current()->getExtension() === 'php')
            {
                require $it->key();
            }
            $it->next();
        }
    }
}
