<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Library;
use Excel;

class ReportController extends Controller
{
    public static function importFileExcel($nameFile)
    {
        $url = base_path().'/public/Upload/'.$nameFile;

        return Excel::selectSheetsByIndex(0)->load($url, function($reader) {
            $reader->all();
        })->get();
    }

    public static function exportFileExcel($data, $type, $nameFile)
    {
        return Excel::create($nameFile, function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->loadView('admin.user.export_user', compact('data'));
            });

        })->export($type);
    }

    public static function exportTeamFileExcel($data, $type, $nameFile)
    {
        return Excel::create($nameFile, function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->loadView('admin.export.team.export_data', compact('data'));
            });

        })->export($type);
    }

    public static function exportFileProjectExcel($data, $type, $nameFile)
    {
        return Excel::create($nameFile, function($excel) use ($data) {
            $excel->sheet('mySheet', function($sheet) use ($data)
            {
                $sheet->loadView('admin.export.project.export_data', compact('data'));
            });

        })->export($type);
    }

}
