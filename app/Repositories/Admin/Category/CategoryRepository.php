<?php

namespace App\Repositories\Admin\Category;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Throwable;

class CategoryRepository implements CategoryInterface{

    /*
     * Support Function
     */

    /**
     * @param $req
     * @param $category_name
     * @param $validated
     * @return void
     */
    protected static function insertProcedure($req, &$category_name, &$validated): void
    {
        $category_name = $req->input('category_name');

        $validated = Validator::make($req->all(), [
            'category_name' => 'required|string|unique:category_models,category_name|max:255',
            'category_image' => 'file|max:3100|mimes:jpg,png,heic,jpeg',
        ],
            [
                'category_name.required' => 'Nama kategori belum diisi, silahkan isi nama kategori',
                'category_name.unique' => 'Data kategori sudah tersedia sebelumnya',
                'category_image.file' => 'Gambar kategori harus berbentuk file (JPG/PNG/HEIC,JPEG)',
                'category_image.mimes' => 'Gambar kategori harus berbentuk file (JPG/PNG/HEIC,JPEG)',
                'category_image.max' => 'Batas ukuran gambar kategori tidak boleh diatas 3MB',
            ]);
    }

    protected function storeFiles($req): array
    {
        try{

            $categoryImage = $req->file('category_image');

            if(is_null($categoryImage) OR empty($categoryImage) OR $req->hasFile('category_image')==false){
                throw new Exception("Gagal membaca file foto");
            }

            $randomName = md5(Carbon::now().$categoryImage->getClientOriginalName().Auth::user()->username);
            $imageName = $randomName.".".$categoryImage->getClientOriginalExtension();

            if(!$req->file('category_image')->move(public_path('assets/images/categories'),$imageName)){
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
                throw new Exception("Gambar kategori tidak terdeteksi");
            }

            $imagePath = public_path('assets/images/categories/'.$imageName);

            if(!file_exists($imagePath)){
                throw new Exception("Gambar kategori tidak terdeteksi");
            }else{
                if(!unlink($imagePath)){
                    throw new Exception("Gagal menghapus gambar kategori");
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
        $checkedCategory = DB::table('category_models')
            ->where('id', '=', $idProduct)
            ->first();

        if (!$checkedCategory or empty($checkedCategory) or is_null($checkedCategory)) {
            throw new Exception("Data kategori tidak tersedia", 404);
        }

        if($checkedCategory->category_image != null){
                $deleteProductImage = $this->deleteFiles($checkedCategory->category_image);
                if ($deleteProductImage['status'] == false) {
                    throw new Exception($deleteProductImage['msg'], 500);
                }
        }
    }

    /*
     * End of Support Function
     */

    /*
     * Main Function
     */

    public function allData(): array
    {
        try{
            $query = DB::table('category_models')
                ->select('id','category_image','category_name')
                ->get();
            if(!$query OR $query->isEmpty()){
                throw new Exception("Gagal mendapatkan informasi kategori",404);
            }else{
                foreach ($query as $index => $val){
                    $data [] = array(
                        'category_id' => $val->id,
                        'category_image' => $val->category_image,
                        'category_name' => $val->category_name,
                    );
                }
                $allData = array(
                    'data' => $data
                );
                return apiStandardSuccessFormatter($allData,'Successfully get data',200);
            }
        }catch (Throwable $err){
            return apiStandardFailedFormatter(null,$err->getMessage(),$err->getCode());
        }
    }

    public function deleteData($idCategory): array
    {
        try {

            $this->deleteProcedure($idCategory);

            DB::beginTransaction();

            $queryDelete = DB::table('category_models')
                ->where('id','=',$idCategory)
                ->delete();

            if(!$queryDelete){
                throw new Exception("Gagal menghapus data kategori",500);
            }else{
                DB::commit();
                return apiStandardSuccessFormatter(null,"Berhasil menghapus kategori",200);
            }

        }catch (Throwable $err){
            DB::rollBack();
            return apiStandardFailedFormatter(null,$err->getMessage(),$err->getCode());
        }
    }

    public function insertData($req): array
    {
        try{

            self::insertProcedure($req, $categoryName, $validated);

            if($validated->fails()){
                throw new Exception($validated->errors(),400);
            }else{

                if($req->hasFile('category_image')){
                    $storeImage = $this->storeFiles($req);

                    if($storeImage['status']==false){
                        throw new Exception('Gagal mengupload foto kategori',500);
                    }

                    $queryInsert = array(
                        'category_name' => $categoryName,
                        'category_image' => $storeImage['data'],
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    );
                }else{
                    $queryInsert = array(
                        'category_name' => $categoryName,
                        'category_image' => null,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    );
                }

                DB::beginTransaction();
                $query = DB::table('category_models')->insert($queryInsert);
                if(!$query){
                    throw new Exception("Terjadi kesalahan pada database",500);
                }

                DB::commit();
                return apiStandardSuccessFormatter(null,'Berhasil menyimpan kategori',200);

            }

        }catch (Throwable $err){
            DB::rollBack();
            return apiStandardFailedFormatter(null,$err->getMessage(),$err->getCode());
        }
    }

    public function updateData($req,$idCategory): array
    {
        try{
            self::insertProcedure($req, $categoryName, $validated);

            if($validated->fails()){
                throw new Exception($validated->errors(),400);
            }else{


                if($req->hasFile('category_image')){

                    $this->deleteProcedure($idCategory);
                    $storeImage = $this->storeFiles($req);

                    if($storeImage['status']==false){
                        throw new Exception('Gagal mengupload foto kategori',500);
                    }

                    $queryUpdate = array(
                        'category_name' => $categoryName,
                        'category_image' => $storeImage['data'],
                        'updated_at' => Carbon::now()
                    );

                }else{
                    $queryUpdate = array(
                        'category_name' => $categoryName,
                        'updated_at' => Carbon::now()
                    );
                }

                DB::beginTransaction();
                $updateProduct = DB::table('category_models')
                    ->where('id','=',$idCategory)
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

    public function detailData($idCategory): array
    {
        try {
            $query = DB::table('category_models')
                            ->where('id','=',$idCategory)
                            ->first();

            if(!$query OR empty($query) OR is_null($query)){
                throw new Exception("Detail kategori tidak ditemukan",404);
            }else{
                $data = array(
                  'category_id' => $query->id,
                  'category_name' => $query->category_name,
                  'category_image' => $query->category_image,
                  'updated_at' => Carbon::parse($query->updated_at)->diffForHumans()
                );
                return apiStandardSuccessFormatter($data,'Successfully get data',200);
            }

        }catch (Throwable $err){
            return apiStandardFailedFormatter(null,$err->getMessage(),$err->getCode());
        }
    }

    /*
     * End of Main Function
     */

}
