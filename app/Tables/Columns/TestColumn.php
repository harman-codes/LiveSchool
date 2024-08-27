<?php

namespace App\Tables\Columns;

use Filament\Tables\Columns\Column;

class TestColumn extends Column
{
    protected string $view = 'tables.columns.test-column';

    public static function randomnumber($val)
    {
        return $val.' - '.rand(1,100);
    }
}
