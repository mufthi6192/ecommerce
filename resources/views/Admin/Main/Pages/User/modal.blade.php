<div class="modal fade" id="modalUserDetail" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pengguna</h5>
                <button type="button" class="close" onclick="closeModal()"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detailBodyModal">
                {{--Modal--}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal" onclick="closeModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalUser" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" onclick="closeModal()"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="insertModalForm">
                    <div class="col-lg-12 mb-2">
                        <div class="form-group">
                            <label class="text-label">Nama</label>
                            <input type="text" id="name" name="name" class="form-control" placeholder="Masukan nama pengguna" required>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2">
                        <div class="form-group">
                            <label class="text-label">Username</label>
                            <input type="text" id="username" name="username" class="form-control" placeholder="Masukan username pengguna" required>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2">
                        <div class="form-group">
                            <label class="text-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Masukan email pengguna" required>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-2">
                        <div class="form-group">
                            <label class="text-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Masukan password pengguna" required>
                        </div>
                    </div>
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                            <label class="text-label">Gambar Pengguna</label>
                            <div class="custom-file">
                                <input type="file" id="image" name="image" class="custom-file-input">
                                <label class="custom-file-label">Pilih Gambar</label>
                                <label class="small text-danger">*Kosongkan jika tidak memiliki gambar pengguna</label>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal" onclick="closeModal()">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
    </div>
</div>
