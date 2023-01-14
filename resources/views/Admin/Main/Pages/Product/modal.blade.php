<div class="modal fade" id="modalProduct" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" onclick="closeModal()"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="insertProductForm">
                    <div id="idUpdate"></div>
                    <div id="exampleAppendForm">


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

<div class="modal fade" id="modalProductDetail" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Produk</h5>
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

<div class="modal fade" id="modalProductImage" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"></h5>
                <button type="button" class="close" onclick="closeModal()"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="insertImageForm">
                    <div id="idUpdateImage"></div>
                    <div class="col-lg-12 mb-3">
                        <div class="form-group">
                            <label class="text-label">Gambar Produk</label>
                            <div class="custom-file">
                                <input type="file" id="product_image" name="product_image" class="custom-file-input">
                                <label class="custom-file-label">Pilih Gambar</label>
                                <label class="small text-danger">*Wajib mengisi gambar</label>
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

<div class="modal fade" id="modalImageDetail" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Gambar Produk</h5>
                <button type="button" class="close" onclick="closeModal()"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body" id="detailImageBodyModal">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-interest">
                            <h5 class="text-primary d-inline">Detail Gambar Produk</h5>
                            <div class="mt-4" id="listImageProduct">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal" onclick="closeModal()">Tutup</button>
            </div>
        </div>
    </div>
</div>
