<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Library;
use Excel;

class ReportController extends Controller
{
    public function importFileExcel($nameFile)
    {
        $url = base_path().'/public/Upload/'.$nameFile;

        return Excel::load($url, function($reader) {
            $reader->all();
        })->get();
    }
}
