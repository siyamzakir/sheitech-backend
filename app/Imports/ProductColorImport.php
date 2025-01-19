<?php

namespace App\Imports;

use App\Models\Product\Category;
use App\Models\Product\Product;
use App\Models\Product\ProductColor;
use App\Models\ProductFeatureKey;
use App\Models\ProductFeatureValue;
use App\Models\ProductMetaKey;
use App\Models\ProductMetaValue;
use App\Models\SubCategory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductColorImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $product = Product::where("product_code", $row[0])->first();
        if ($product) {
//            $count_color = ProductColor::where('product_id', $product->id)->get();
//            if (count($count_color) > 0) {
//                return null;
//    
            $p_feature_key = ProductFeatureKey::updateOrCreate([
                'product_id' => $product->id,
                'key' => 'Warranty'
            ], [
                'product_id' => $product->id,
                'key' => 'Warranty'
            ]);
//            $p_specification = [];
//            warranty block
//            dd($row[10],$row[11],$row[12]);
            if (isset($row[10]) && isset($row[11]) && isset($row[12])) {
                ProductFeatureValue::create([
                    "product_feature_key_id" => $p_feature_key->id,
                    "value" => $row[10],
                    "price" => $row[11],
                    "stock" => $row[12],
                ]);
            }
            if (isset($row[13]) && isset($row[14]) && isset($row[15])) {
                ProductFeatureValue::create([
                    "product_feature_key_id" => $p_feature_key->id,
                    "value" => $row[13],
                    "price" => $row[14],
                    "stock" => $row[15],
                ]);
            }
//            product specification
//                sub category missing
            $Subcategory = SubCategory::where('category_id', $product->category_id)->first();
            if ($Subcategory) {
                $p_meta_key = ProductMetaKey::updateOrCreate([
                    'category_id' => $Subcategory->category_id,
                    'sub_category_id' => $Subcategory->id,
                    'key' => 'Size'
                ], [
                    'category_id' => $Subcategory->category_id,
                    'sub_category_id' => $Subcategory->id,
                    'key' => 'Size'
                ]);

                if (!empty($row[16])) {
                    ProductMetaValue::create([
                        'product_meta_key_id' => $p_meta_key->id,
                        'product_id' => $product->id,
                        'value' => $row[17],
                    ]);
                }
                if (!empty($row[17])) {
                    ProductMetaValue::create([
                        'product_meta_key_id' => $p_meta_key->id,
                        'product_id' => $product->id,
                        'value' => $row[17],
                    ]);
                }
            }
//            product color create
            return new ProductColor([
                "product_id" => $product->id,
                "name" => $row[1],
                "color_code" => $row[2],
                "price" => $row[3],
                "stock" => $row[4],
            ]);
        } else {
            return null;
        }
    }

    public function startRow(): int
    {
        return 2;
    }
}
