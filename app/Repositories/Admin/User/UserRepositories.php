<?php

namespace App\Repositories\Admin\User;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Throwable;

class UserRepositories implements UserInterface{

    /**
     * @param $req
     * @param $productName
     * @param $productPrice
     * @param $productDescription
     * @param $categoryId
     * @param $validated
     * @return void
     * Support function
     */
    protected static function insertProcedure($req, &$name, &$username, &$email, &$password, &$validated): void
    {
        $name = $req->input('name');
        $username = $req->input('username');
        $email = $req->input('email');
        $password = $req->input('password');

        $validated = Validator::make($req->all(), [
            'username' => 'required|string|unique:users,username|max:255',
            'name' => 'required|max:255',
            'image' => 'file|max:3100|mimes:jpg,png,heic,jpeg',
            'email' => 'required|string|unique:users,email|max:255'
        ],
            [
                'username.required' => 'Username belum diisi, silahkan isi nama',
                'username.unique' => 'Username sudah tersedia sebelumnya',
                'email.required' => 'Email belum diisi, silahkan isi email',
                'email.unique' => 'Email sudah tersedia sebelumnya',
                'name.required' => 'Nama belum diisi, silahkan isi nama',
                //'product_image.required' => 'Gambar produk belum diisi, silahkan isi gambar produk',
                'image.file' => 'Gambar user harus berbentuk file (JPG/PNG/HEIC,JPEG)',
                'image.max' => 'Batas ukuran gambar user tidak boleh diatas 3MB',
                'image.mimes' => 'Gambar user harus berbentuk file (JPG/PNG/HEIC,JPEG)',
            ]);
    }

    protected function storeFiles($req): array
    {
        try{

            $userImage = $req->file('image');

            if(is_null($userImage) OR empty($userImage) OR $req->hasFile('image')==false){
                throw new Exception("Gambar pengguna tidak terdeteksi");
            }

            $randomName = md5(Carbon::now().$userImage->getClientOriginalName().Auth::user()->email);
            $imageName = $randomName.".".$userImage->getClientOriginalExtension();

            if(!$req->file('image')->move(public_path('admin/images/avatar'),$imageName)){
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
                throw new Exception("Gambar pengguna tidak terdeteksi");
            }

            $imagePath = public_path('admin/images/avatar/'.$imageName);

            if(!file_exists($imagePath)){
                throw new Exception("Gambar pengguna tidak terdeteksi");
            }else{
                if(!unlink($imagePath)){
                    throw new Exception("Gagal menghapus gambar pengguna");
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
     * @throws Exception
     */
    protected function deleteProcedure($idImage): void
    {
        $checkedUser = DB::table('user_details')
            ->where('id', '=', $idImage)
            ->first();

        if (!$checkedUser or empty($checkedUser) or is_null($checkedUser)) {
            throw new Exception("Data pengguna tidak tersedia", 404);
        }

        if($checkedUser->image != null){
            $deleteUserImage = $this->deleteFiles($checkedUser->image);
            if ($deleteUserImage['status'] == false) {
                throw new Exception($deleteUserImage['msg'], 500);
            }
        }
    }

    /**
     * @return array
     * Main Function
     */
    public function allData(): array
    {
        try{
            $query = DB::table('users')
                ->select('id','name','username','email')
                ->get();
            if(!$query OR $query->isEmpty()){
                throw new Exception("Gagal mendapatkan informasi user",404);
            }else{
                $data = [];
                foreach ($query as $index => $val){
                    $data [] = array(
                        'id' => $val->id,
                        'username' => $val->username,
                        'email' => $val->email,
                        'name' => $val->name
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
        try {
        self::insertProcedure($req, $name, $username, $email, $password, $validated);

        if($validated->fails()){
            throw new Exception($validated->errors(),400);
        }else{

            if($req->hasFile('image')){
                $storeImage = $this->storeFiles($req);
                if($storeImage['status']==false){
                    throw new Exception($storeImage['msg'],500);
                }else{
                    $userImage = $storeImage['data'];
                }
            }else{
                $userImage = null;
            }

            DB::beginTransaction();
            $query = DB::table('users')->insertGetId([
                'name' => $name,
                'email' => $email,
                'username' => $username,
                'password' => Hash::make($password),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
            if(!$query){
                throw new Exception("Terjadi kesalahan pada database",500);
            }

            $queryUserImg = DB::table('user_details')->insert([
                'user_id' => $query,
                'image' => $userImage,
                'level' => 'admin',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);

            $queryNotification = DB::table('notification_models')->insert([
                [
                    'user_id' => $query,
                    'notification_message' => 'Akun anda berhasil didaftarkan',
                    'notification_image' => 'account-created.png',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ],
                [
                    'user_id' => $query,
                    'notification_message' => 'Akun anda berhasil diaktivasi',
                    'notification_image' => 'account-activated.png',
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ]
            ]);

            if(!$queryUserImg OR !$queryNotification){
                throw new Exception("Terjadi kesalahan pada database",500);
            }

            DB::commit();
            return apiStandardSuccessFormatter(null,'Berhasil menyimpan pengguna',200);

        }
        }catch (Throwable $err){
            DB::rollBack();
            return apiStandardFailedFormatter(null,$err->getMessage(),$err->getCode());
        }
    }

    public function updateData()
    {
        // TODO: Implement updateData() method.
    }

    public function deleteData($idUser): array
    {
        try {

            $this->deleteProcedure($idUser);

            DB::beginTransaction();

            $queryDelete = DB::table('users')
                ->where('id','=',$idUser)
                ->delete();

            $queryDeleteImage = DB::table('user_details')
                ->where('user_id','=',$idUser)
                ->delete();

            if(!$queryDelete OR !$queryDeleteImage){
                throw new Exception("Gagal menghapus data pengguna",500);
            }else{
                DB::commit();
                return apiStandardSuccessFormatter(null,"Berhasil menghapus pengguna",200);
            }


        }catch (Throwable $err){
            DB::rollBack();
            return apiStandardFailedFormatter(null,$err->getMessage(),$err->getCode());
        }
    }

    public function dataDetails($idUser): array
    {
        try{
            if(is_null($idUser) OR empty($idUser)){
                throw new Exception("Data user tidak tersedia",404);
            }else{
                $query = DB::table('users')
                    ->join('user_details','user_details.user_id','=','users.id')
                    ->where('users.id','=',$idUser)
                    ->select('users.name as name','users.email as email','users.username as username',
                                'user_details.image as image','user_details.level as level')
                    ->get();

                $collectionQuery = collect($query);

                if(!$query OR $collectionQuery->isEmpty() OR is_null($collectionQuery) OR empty($collectionQuery)){
                    throw new Exception("Data tidak ditemukan",404);
                }else{
                    $data = $collectionQuery->first();
                    $data = array(
                        'name' => $data->name,
                        'email' => $data->email,
                        'username' => $data->username,
                        'image' => $data->image,
                        'level' => $data->level
                    );
                    return apiStandardSuccessFormatter($data,'Successfully get data',200);
                }
            }
        }catch (Throwable $err){
            return apiStandardFailedFormatter(null,$err->getMessage(),$err->getCode());
        }
    }
}
