<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Exception;
use App\Imports\ProductsImport;

class ProductImportController extends Controller
{
    public function import()
    {
        try {
            if (request()->has('file')) {
                Excel::import(new ProductsImport(), request()->file('file'));
                return response()->json(['message' => 'Данные успешно импортированы.']);
            } else {
                return response()->json(['error' => 'Не удалось загрузить файл.'], 400);
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Произошла ошибка при импорте данных.'], 500);
        }
    }
}