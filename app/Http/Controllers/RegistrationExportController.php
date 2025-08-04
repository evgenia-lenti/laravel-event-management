<?php

namespace App\Http\Controllers;

use App\Exports\RegistrationsExport;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Exception;

class RegistrationExportController extends Controller
{
    /**
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function export()
    {
        return Excel::download(new RegistrationsExport, 'registrations.csv', \Maatwebsite\Excel\Excel::CSV);
    }
}
