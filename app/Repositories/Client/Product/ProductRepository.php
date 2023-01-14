<?php

namespace App\Repositories\Client\Product;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use function standardFailedFormatter;
use function standardSuccessFormatter;

class ProductRepository implements ProductInterface{

    protected function categoryName($idCategory)
    {
        return DB::table('category_models')
            ->where('id','=',$idCategory)
            ->select('category_name')
            ->first();
    }

    public function allData(): array
    {
        try{
            DB::beginTransaction();
            $query = DB::table('product_models')->get();

            $this->loopResponse($query, $response);

        }catch (\Throwable $err){
            $response = standardFailedFormatter(null,$err->getMessage());
        }
        return $response;

    }

    public function limitData(): array
    {

        try{
            $query = DB::table('product_models')->limit(8)->get();

            $this->loopResponse($query, $response);

        }catch (\Throwable $err){
            $response = standardFailedFormatter(null,$err->getMessage());
        }
        return $response;

    }

    public function searchData($keyword): array
    {
        try {

            $keywordFind = $keyword;

            if(is_null($keywordFind) OR empty($keywordFind)){
                throw new \Exception("Gagal ! Produk tidak ditemukan");
            }

            $query = DB::table('product_models')
                ->where('product_name','like','%'.$keywordFind.'%')
                ->get();

            if($query->isEmpty()){
                throw new \Exception("Gagal ! Produk tidak ditemukan");
            }else{
                $this->loopResponse($query, $response);
            }

        }catch (\Throwable $err){
            $response = array(
                'status' => false,
                'msg' => $err->getMessage(),
                'data' => null
            );
        }

        return $response;
    }

    public function singleData($keyword): array
    {
        try{
            $query = DB::table('product_models')->where('id','=',$keyword)->first();
            $query2 = DB::table('product_images')->where('product_id','=',$keyword)->get();

            if(!$query){
                throw new \Exception("Gagal ! Produk yang anda cari tidak ada");
            }

            if(empty($query) OR is_null($query)){
                throw new \Exception("Gagal ! Produk yang anda cari tidak ada");
            }

            $data = $query;

            $listImage = [];
            $listImage[] = $data->product_image;

            if($query2->count()!=0){
                foreach ($query2 as $item){
                    array_push($listImage,$item->img_src);
                }
            }

            $categoryName = $this->categoryName($query->category_id);

            $response = array(
                'product_name' => $data->product_name,
                'product_description' => $data->product_description,
                'product_category' => $categoryName->{'category_name'},
                'product_category_id' => $data->category_id,
                'product_image' => $listImage,
                'product_price' => $data->product_price,
                'product_id' => $data->id
            );

            $response = standardSuccessFormatter($response,'Successfully get data');

        }catch (\Throwable $err){
            $response = standardFailedFormatter(null,$err->getMessage());
        }
        return $response;
    }

    /**
     * @param Collection $query
     * @param $response
     * @return void
     * @throws \Exception
     * Helper function to avoid duplicate
     */
    protected function loopResponse(Collection $query, &$response): void
    {
        if (!$query) {
            throw new \Exception("Failed to get data");
        } else {
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

            $response = standardSuccessFormatter($loopData, 'Successfully get data');
        }
    }

    public function searchDataMobile($keyword): array
    {
        try{
            $query = DB::table('product_models')
                ->where('product_name','like','%'.$keyword.'%')
                ->limit(2)
                ->get();

            $queryCount = DB::table('product_models')
                ->where('product_name','like','%'.$keyword.'%')
                ->count();

            if(!$query OR !$queryCount){
                throw new \Exception("Gagal memperoleh data");
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

            $data = array(
                'product_total' => $queryCount,
                'product_keyword' => $keyword,
                'product_data' => $loopData,
            );

            $response = standardSuccessFormatter($data,'Successfully get data');

        }catch (\Throwable $err){
            $response = standardFailedFormatter(null,$err->getMessage());
        }

        return $response;
    }

}
