<?php

namespace App\Repositories\Admin\Product;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Throwable;

class ProductRepository implements ProductInterface{

    /*
     * Support Function
     */

    /**
     * @param $req
     * @param $productName
     * @param $productPrice
     * @param $productDescription
     * @param $categoryId
     * @param $validated
     * @return void
     */
    protected static function insertProcedure($req, &$productName, &$productPrice, &$productDescription, &$categoryId, &$validated): void
    {
        $productName = $req->input('product_name');
        $productPrice = $req->input('product_price');
        $productDescription = $req->input('product_description');
        $categoryId = $req->input('category_id');

        if (is_null($productDescription) or empty($productDescription)) {
            $productDescription = 'Produk tidak memiliki deskripsi';
        }

        $validated = Validator::make($req->all(), [
            'product_name' => 'required|string|unique:product_models,product_name|max:255',
            'product_price' => 'required|max:255',
            'product_image' => 'file|max:3100|mimes:jpg,png,heic,jpeg',
            'category_id' => 'required|exists:category_models,id'
        ],
            [
                'product_name.required' => 'Nama produk belum diisi, silahkan isi nama produk',
                'product_name.unique' => 'Data produk sudah tersedia sebelumnya',
                'product_price.required' => 'Harga produk belum diisi, silahkan isi harga produk',
                //'product_image.required' => 'Gambar produk belum diisi, silahkan isi gambar produk',
                'product_image.file' => 'Gambar produk harus berbentuk file (JPG/PNG/HEIC,JPEG)',
                'product_image.max' => 'Batas ukuran gambar produk tidak boleh diatas 3MB',
                'category_id.required' => 'Kategori belum diisi, silahkan isi kategori',
                'category_id.exists' => 'Kategori tidak tersedia'
            ]);
    }

    protected function storeFiles($req): array
    {
        try{

            $productImage = $req->file('product_image');

            if(is_null($productImage) OR empty($productImage) OR $req->hasFile('product_image')==false){
                throw new Exception("Gambar produk tidak terdeteksi");
            }

            $randomName = md5(Carbon::now().$productImage->getClientOriginalName().Auth::user()->email);
            $imageName = $randomName.".".$productImage->getClientOriginalExtension();

            if(!$req->file('product_image')->move(public_path('assets/images/product'),$imageName)){
                throw new Exception("Gagal melakukan upload file");
            }else{
                $response = array(
                  'status' => true,
                  'msg' => 'Successfully upload file',
                  'data' => $imageName
                );
            }

        }catch (Throwable $err){
            $response = array(
              'status' => false,
              'msg' => $err->getMessage(),
              'data' => null
            );
        }

        return $response;
    }

    protected function deleteFiles($imageName): array
    {
        try{

            if(is_null($imageName) OR empty($imageName)){
                throw new Exception("Gambar produk tidak terdeteksi");
            }

            $imagePath = public_path('assets/images/product/'.$imageName);

            if(!file_exists($imagePath)){
                throw new Exception("Gambar produk tidak terdeteksi");
            }else{
                if(!unlink($imagePath)){
                    throw new Exception("Gagal menghapus gambar produk");
                }else{
                    $response = array(
                      'status' => true,
                      'msg' => 'Successfully delete image',
                      'data' => null
                    );
                }
            }

        }catch (Throwable $err){
            $response = array(
                'status' => false,
                'msg' => $err->getMessage(),
                'data' => null
            );
        }

        return $response;
    }

    /**
     * @param $idProduct
     * @return void
     * @throws Exception
     */
    protected function deleteProcedure($idProduct): void
    {
        $checkedProduct = DB::table('product_models')
            ->where('id', '=', $idProduct)
            ->first();

        if (!$checkedProduct or empty($checkedProduct) or is_null($checkedProduct)) {
            throw new Exception("Data produk tidak tersedia", 404);
        }

        $listImage = DB::table('product_images')
                                ->where('product_id','=',$idProduct)
                                ->get();

        $listImageTotal = DB::table('product_images')
            ->where('product_id','=',$idProduct)
            ->count();


        if((int)$listImageTotal != 0){
            foreach ($listImage as $item){
                $massDelete = $this->deleteFiles($item->img_src);
                if ($massDelete['status'] == false) {
                    throw new Exception($massDelete['msg'], 500);
                }
            }
            $deleteProductImage = $this->deleteFiles($checkedProduct->product_image);
            if ($deleteProductImage['status'] == false) {
                throw new Exception($deleteProductImage['msg'], 500);
            }
        }else{
            $deleteProductImage = $this->deleteFiles($checkedProduct->product_image);
            if ($deleteProductImage['status'] == false) {
                throw new Exception($deleteProductImage['msg'], 500);
            }
        }
    }

    /*
     * End Support Function
     */

    /*
     * Main Function | Implement Interface
     */

    public function allData(): array
    {
        try{
          $query = DB::table('product_models')
                        ->join('category_models','category_models.id','=','product_models.category_id')
                        ->select('product_models.product_name as product_name','product_models.product_price as product_price','product_models.id as id',
                                    'product_models.product_description as product_description','category_models.category_name as category_name')
                        ->get();
          if(!$query OR $query->isEmpty()){
              throw new Exception("Gagal mendapatkan informasi produk",404);
          }else{
              foreach ($query as $index => $val){
                  $data [] = array(
                        'product_id' => $val->id,
                        'product_name' => $val->product_name,
                        'product_price' => $val->product_price,
                        'product_description' => Str::limit($val->product_description,20),
                        'category_name' => $val->category_name
                  );
              }
              return apiStandardSuccessFormatter($data,'Successfully get data',200);
          }
        }catch (Throwable $err){
            return apiStandardFailedFormatter(null,$err->getMessage(),$err->getCode());
        }
    }

    public function insertData($req): array
    {
       try{

           self::insertProcedure($req, $productName, $productPrice, $productDescription, $categoryId, $validated);

           if($validated->fails()){
               throw new Exception($validated->errors(),400);
           }else{

               $storeImage = $this->storeFiles($req);

               if($storeImage['status']==false){
                   throw new Exception('Gagal mengupload foto produk',500);
               }

               DB::beginTransaction();
               $query = DB::table('product_models')->insert([
                    'product_name' => $productName,
                    'product_price' => $productPrice,
                    'product_description' => $productDescription,
                    'product_image' => $storeImage['data'],
                    'category_id' => $categoryId,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
               ]);
               if(!$query){
                   throw new Exception("Terjadi kesalahan pada database",500);
               }

               DB::commit();
               return apiStandardSuccessFormatter(null,'Berhasil menyimpan produk',200);

           }

       }catch (Throwable $err){
           DB::rollBack();
           return apiStandardFailedFormatter(null,$err->getMessage(),$err->getCode());
       }
    }

    public function updateData($req,$idProduct): array
    {
        try{
            self::insertProcedure($req, $productName, $productPrice, $productDescription, $categoryId, $validated);

            if($validated->fails()){
                throw new Exception($validated->errors(),400);
            }else{


                if($req->hasFile('product_image')){
                    $this->deleteProcedure($idProduct);
                    $storeImage = $this->storeFiles($req);

                    if($storeImage['status']==false){
                        throw new Exception('Gagal mengupload foto produk',500);
                    }

                    $queryUpdate = array(
                      'product_name' => $productName,
                      'product_description' => $productDescription,
                      'product_price' => $productPrice,
                      'product_image' => $storeImage['data'],
                      'category_id' => $categoryId,
                      'updated_at' => Carbon::now()
                    );
                }else{
                    $queryUpdate = array(
                        'product_name' => $productName,
                        'product_description' => $productDescription,
                        'product_price' => $productPrice,
                        'category_id' => $categoryId,
                        'updated_at' => Carbon::now()
                    );
                }

                DB::beginTransaction();
                $updateProduct = DB::table('product_models')
                                        ->where('id','=',$idProduct)
                                        ->update($queryUpdate);
                if(!$updateProduct){
                    throw new Exception("Gagal melakukan update data",500);
                }else{
                    DB::commit();
                    return apiStandardSuccessFormatter(null,'Berhasil melakukan update produk',200);
                }

            }
        }catch (Throwable $err){
            return apiStandardFailedFormatter(null,$err->getMessage(),$err->getCode());
        }
    }

    public function deleteData($idProduct): array
    {
        try {

            $this->deleteProcedure($idProduct);

            DB::beginTransaction();

            $queryDelete = DB::table('product_models')
                            ->where('id','=',$idProduct)
                            ->delete();


            $countData = countDb('product_images',['product_id'=>$idProduct]);

            if($countData !=0){
                $queryDeleteImg = DB::table('product_images')
                    ->where('product_id','=',$idProduct)
                    ->delete();
                if(!$queryDeleteImg){
                    throw new Exception("Gagal menghapus data produk",500);
                }
            }

            if(!$queryDelete){
                throw new Exception("Gagal menghapus data produk",500);
            }else{
                DB::commit();
                return apiStandardSuccessFormatter(null,"Berhasil menghapus produk",200);
            }

        }catch (Throwable $err){
            DB::rollBack();
            return apiStandardFailedFormatter(null,$err->getMessage(),$err->getCode());
        }
    }

    public function detailData($idProduct): array
    {
        try{
           if(is_null($idProduct) OR empty($idProduct)){
               throw new Exception("Data produk tidak tersedia",404);
           }else{
               $query = DB::table('product_models')
                                ->join('category_models','category_models.id','=','product_models.category_id')
                                ->where('product_models.id','=',$idProduct)
                                ->select('product_models.product_name as product_name', 'product_models.product_price as product_price',
                                        'product_models.product_description as product_description', 'product_models.product_image as product_image',
                                        'product_models.updated_at as last_update','product_models.id as product_id',
                                        'category_models.category_name as category_name')
                                ->get();

               $collectionQuery = collect($query);

               if(!$query OR $collectionQuery->isEmpty() OR is_null($collectionQuery) OR empty($collectionQuery)){
                   throw new Exception("Data tidak ditemukan",404);
               }else{
                   $data = $collectionQuery->first();
                   $data = array(
                        'product_name' =>  $data->product_name,
                        'product_price' => $data->product_price,
                        'product_description' => $data->product_description,
                        'product_image' => $data->product_image,
                        'product_id' => $data->product_id,
                        'last_update' => Carbon::parse($data->last_update)->diffForHumans(),
                        'category_name' => $data->category_name
                   );
                   return apiStandardSuccessFormatter($data,'Successfully get data',200);
               }
           }
        }catch (Throwable $err){
            return apiStandardFailedFormatter(null,$err->getMessage(),$err->getCode());
        }
    }

    public function insertImageData($req,$idProduct): array
    {
        try {

            $checkedProduct = DB::table('product_models')
                                    ->where('id','=',$idProduct)
                                    ->first();

            if(is_null($checkedProduct) OR empty($checkedProduct)){
                throw new Exception("Gagagl ! Data produk tidak ditemukan",404);
            }

            $validated = Validator::make($req->all(),[
                'product_image' => 'required|file|max:3100|mimes:jpg,png,heic,jpeg',
            ],[
                'product_image.required' => 'Gambar produk belum diisi, silahkan isi gambar produk',
                'product_image.file' => 'Gambar produk harus berbentuk file (JPG/PNG/HEIC,JPEG)',
                'product_image.max' => 'Batas ukuran gambar produk tidak boleh diatas 3MB',
                'product_image.mimes' => 'Gambar produk harus berbentuk file (JPG/PNG/HEIC,JPEG)',
            ]);

            if($validated->fails()){
                throw new Exception($validated->errors(),400);
            }else{
                $saveImage = $this->storeFiles($req);
                if ($saveImage['status']!=true){
                    throw new Exception($saveImage['msg'],500);
                }else{
                    DB::beginTransaction();
                    $query = DB::table('product_images')
                                    ->insert([
                                        'img_src' => $saveImage['data'],
                                        'product_id' => $idProduct
                                    ]);
                    if(!$query){
                        throw new Exception("Gagal menyimpan ke database");
                    }else{
                        DB::commit();
                        return apiStandardSuccessFormatter(null,"Berhasil menambah foto produk",200);
                    }
                }
            }
        }catch (Throwable $err){
            DB::rollBack();
            return apiStandardFailedFormatter(null,$err->getMessage(),$err->getCode());
        }
    }

    public function detailImageData($idImage): array
    {
        try{
            if(is_null($idImage) OR empty($idImage)){
                throw new Exception("Data gambar produk tidak tersedia",404);
            }else{
                $query = DB::table('product_images')
                                ->where('product_id','=',$idImage)
                                ->get();
                if($query->isEmpty() OR is_null($query) OR empty($query) OR !$query){
                    throw new Exception("Data gambar produk tidak tersedia",404);
                }else{
                    $data = [];
                    foreach($query as $index => $item){

                        $data[] = array(
                            'index' => $index,
                            'product_image' => $item->img_src,
                            'status' => ''
                        );
                    }
                    $toCollection = collect($data);
                    $firstData = $toCollection->first();
                    $newFirstData = array(
                        'index' => 0,
                        'product_image' => $firstData['product_image'],
                        'status' => 'active'
                    );
                    $toCollection->shift();

                    $result = $toCollection->prepend($newFirstData);

                    return apiStandardSuccessFormatter($result->toArray(),"Successfully get data",200);
                }
            }
        }catch (Throwable $err){
            return apiStandardFailedFormatter(null,$err->getMessage(),$err->getCode());
        }
    }

    /*
     * End Main Function
     */
}
