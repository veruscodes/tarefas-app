<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ExportTasksCsv;
use Illuminate\Support\Facades\Storage;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    // dispara a exportação
    public function export()
    {
        ExportTasksCsv::dispatch(auth('api')->id());

        return response()->json([
            'message' => 'Exportação iniciada. Verifique a pasta /storage/app/exports após processamento.'
        ]);
    }

    // baixa o arquivo depois de pronto
    public function download($filename)
    {
        $path = 'exports/' . $filename;

        if (!Storage::exists($path)) {
            return response()->json(['message' => 'Arquivo não encontrado'], 404);
        }

        return response()->download(storage_path('app/' . $path));
    }
}
