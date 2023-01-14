<?php

namespace App\Repositories\Client\Category;

use Illuminate\Support\Facades\DB;
use function standardFailedFormatter;
use function standardSuccessFormatter;

class CategoryRepository implements CategoryInterface{

    protected function categoryName($idCategory){
        return DB::table('category_models')
            ->where('id','=',$idCategory)
            ->select('category_name')
            ->first();
    }

    public function allData(): array
    {
        try{
            DB::beginTransaction();
            $query = DB::table('category_models')->get();

            if(!$query){
                throw new \Exception("Failed to get data");
            }else{
                DB::commit();

                foreach ($query as $data){
                    $loopData[] = array(
                        'category_name' => $data->category_name,
                        'category_image' => $data->category_image,
                        'category_id' => $data->id
                );
                }

                $response = standardSuccessFormatter($loopData,'Successfully get data');
            }

        }catch (\Throwable $err){
            DB::rollBack();
            $response = standardFailedFormatter(null,$err->getMessage());
        }
        return $response;
    }

    public function findProduct($keyword): array
    {
        try{
            $query = DB::table('product_models')->where('category_id','=',$keyword)->get();
            if(!$query){
                throw new \Exception("Gagal ! Terjadi kesalahan koneksi, silahkan coba lagi");
            }
            if($query->isEmpty()){
                throw new \Exception("Gagal ! Data produk tidak ditemukan");
            }

            foreach ($query as $data) {

                $categoryName = $this->categoryName($data->category_id);

                $loopData[] = array(
                    'product_name' => $data->product_name,
                    'product_description' => $data->product_description,
                    'product_category' => $categoryName->{'category_name'},
                    'product_category_id' => $data->category_id,
                    'product_image' => $data->product_image,
                    'product_price' => $data->product_price,
                    'product_id' => $data->id
                );
            }

            $response = standardSuccessFormatter($loopData,"Successfully get data");
        }catch (\Throwable $err){
            $response = standardFailedFormatter(null,$err->getMessage());
        }
        return $response;
    }

}
