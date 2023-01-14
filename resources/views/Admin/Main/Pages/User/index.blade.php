@extends('Admin.Main.main')

@section('main')
    <div class="content-body">
        <div class="container-fluid">
            <div class="form-head d-flex flex-wrap mb-sm-4 mb-3 align-items-center">
                <div class="mr-auto  d-lg-block mb-3">
                    <h2 class="text-black mb-0 font-w700">Pengguna</h2>
                    <p class="mb-0">Halaman admin untuk pengguna</p>
                </div>
            </div>


            <div class="row">
                <div class="col-xl-6 col-xxl-12">
                    <div class="row">
                        <div class="col-xl-12 col-xxl-12">
                            <div class="card widget-media">
                                <div class="card-header border-0 pb-3 ">
                                    <div class="mr-auto pr-3">
                                        <h4 class="text-black font-w700 fs-24">Data Pengguna</h4>
                                    </div>
                                    <div class="dropdown ml-auto text-right">
                                        <button type="button" class="btn btn-rounded btn-info" onclick="insertUserModal()"><span
                                                class="btn-icon-left text-info"><i class="fa fa-plus color-info"></i>
                                    </span>Tambah</button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive align-content-center">
                                        <table id="tableUser" class="display" style="min-width: 845px">
                                            <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Aksi</th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('Admin.Main.Pages.User.modal')
