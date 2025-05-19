<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function getOffices(){
        $offices = Office::all();
        //json shows office name and corresonding id
        $offices = $offices->map(function ($office) {
            return [
                'id' => $office->id,
                'name' => $office->name,
            ];
        });
        return response()->json($offices);
    }
}
