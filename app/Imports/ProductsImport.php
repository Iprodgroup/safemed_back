<?php

namespace App\Imports;

use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {


        // $category_names = explode(' / ', $row['vlozennost_tovara']);
        // $brand = $this->findOrCreateBrand($row['manufacturer']);
        // $category = $this->findOrCreateCategory($category_names[1] ?? $row['vlozennost_tovara']);

        // return new Product([
        //     'title' => $row['naimenovanie_tovara'],
        //     'brand_id' => $brand ? $brand->id : null,
        //     'category_id' => $category->id,
        //     'image_url' => $row['foto_tovara'],
        //     'description' => $row['kratkoe_opisanie'],
        //     'characteristics' => $row['xarakteristiki'],
        //     'type'          => 'medical'
        // ]);

        $category_names = explode(' / ', $row['put_do_tovara']);
        $brand = $this->findOrCreateBrand($row['brend']);
        $category = $this->findOrCreateCategory($category_names[1] ?? $row['put_do_tovara']);

        return new Product([
            'title' => $row['naimenovanie_tovara'],
            'brand_id' => $brand ? $brand->id : null,
            'category_id' => $category->id,
            'image_url' => $row['foto_tovara'],
            'description' => "",
            'characteristics' => $row['xarakteristiki_i_opisanie'],
            'type'          => 'safety'
        ]);
    }

    private function findOrCreateBrand($title)
    {
        $brand = Brand::where('title', $title)->first();

        if (!$brand) {
            $brand = Brand::create(['title' => $title]);
        }

        return $brand;
    }

    private function findOrCreateCategory($title)
    {
        $category = Category::where('title', $title)->first();

        if (!$category) {
            $category = Category::create(['title' => $title]);
        }

        return $category;
    }

}
