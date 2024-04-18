<?php

namespace App\Http\Controllers;

use App\Jobs\ExportCSVJob;
use App\Jobs\ImportCSVJob;

class CSVManagerController extends Controller
{

    public function import(): string
    {
        $fileName = 'products.csv';
        dispatch(new ImportCSVJob($fileName, 1));
        return "Importing started";
    }

    public function export(): string
    {
        $fileName = 'products-'. strtotime(now()) .'.csv';
        dispatch(new ExportCSVJob($fileName));
        return url($fileName);
    }
}
