<div class="modal fade" id="modalCategory" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" onclick="closeModal()"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="insertCategoryForm">
                    <div id="idUpdate"></div>
                <div class="col-lg-12 mb-2">
                    <div class="form-group">
                        <label class="text-label">Kategori</label>
                        <input type="text" id="category_name" name="category_name" class="form-control" placeholder="Masukan nama kategori" required>
                    </div>
                </div>
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label class="text-label">Gambar Kategori</label>
                        <div class="custom-file">
                            <input type="file" id="category_image" name="category_image" class="custom-file-input">
                            <label class="custom-file-label">Pilih Gambar</label>
                            <label class="small text-danger">*Kosongkan jika tidak memiliki ikon kategori</label>
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

<div class="modal fade" id="modalCategoryDetail" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Kategori</h5>
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

