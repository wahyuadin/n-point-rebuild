<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class UsersTemplateExport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new UsersTemplateDataSheet(),
            new UsersTemplateProviderSheet(),
        ];
    }
}
