<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommonController extends Controller
{
    public function getComfirmExport()
    {
       try {
            $html = view ('common.form_confirm_export')->render();

            return response()->json(['result' => true, 'html' => $html]);
       } catch (\Exception $e) {
            return response()->json(['result' => false]);
       }
    }
}
