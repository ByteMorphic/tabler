<?php

namespace bytemorphic\Tabler\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array getData(string $table, array $request)
 * @method static array getConfig(string $table)
 *
 * @see \App\Table\TableManager
 */
class Tabler extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tabler';
    }
}

/**
 * @see \bytemorphic\Tabler\Tabler
 */
// class Tabler extends Facade
// {
//     protected static function getFacadeAccessor(): string
//     {
//         return \bytemorphic\Tabler\Tabler::class;
//     }
// }
