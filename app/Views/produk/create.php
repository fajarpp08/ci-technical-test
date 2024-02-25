<?= $this->extend('templates/dashboard-template') ?>

<?= $this->section('styles') ?>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
        <h1>Tambah Produk</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="/produk">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="/produk">Produk</a></div>
            <div class="breadcrumb-item">Tambah Produk</div>
        </div>
    </div>

    <?= $this->include('templates/partials/alert') ?>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <form action="<?= base_url('produk/tambah-produk/save') ?>" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="nama" class="col-sm-2 col-form-label">Nama Produk</label>
                                <div class="col-sm-10">
                                    <input type="text" name="nama" class="form-control" id="nama" placeholder="Masukkan nama produk" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="harga" class="col-sm-2 col-form-label">Kategori</label>
                                <div class="col-sm-10">
                                    <select name="kategori" class="form-control" required="">
                                        <?php if (!$kategori) : ?>
                                            <option>Harap tambah Kategori dahulu!</option>
                                        <?php endif; ?>
                                        <?php
                                        if ($kategori) :
                                            foreach ($kategori as $kat) :
                                        ?>
                                                <option value="<?= $kat['id_kategori'] ?>"><?= $kat['nama'] ?></option>
                                        <?php
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="harga" class="col-sm-2 col-form-label">Deskripsi</label>
                                <div class="col-sm-10">
                                    <textarea class="summernote-simple" name="deskripsi" id="deskripsi" required=""></textarea>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="namavariasi" class="col-sm-2 col-form-label">Variasi Produk</label>
                                <div class="col-sm-10">
                                    <input type="text" name="variasi[0][nama]" class="form-control" id="namavariasi" placeholder="XL" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="stok" class="col-sm-2 col-form-label">Harga Variasi Produk</label>
                                <div class="col-sm-10">
                                    <input type="number" name="variasi[0][harga]" class="form-control" id="stok" placeholder="400000" required="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="stok" class="col-sm-2 col-form-label">Stok Variasi Produk</label>
                                <div class="col-sm-10">
                                    <input type="number" name="variasi[0][stok]" class="form-control" id="stok" placeholder="10" required="">
                                </div>
                            </div>
                            <tambah></tambah>
                            <div class="form-group row">
                                <button type="button" class="col-sm-6 offset-sm-3 btn btn-outline-primary" onclick="tambahVariasi();"><i class="fas fa-plus"></i> Tambah Variasi</button>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="foto" class="col-sm-2 col-form-label">Foto</label>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div id="image-preview1" class="image-preview">
                                            <label for="image-upload1" id="image-label1">Pilih Foto 1</label>
                                            <input type="file" name="foto1" id="image-upload1" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="image-preview2" class="image-preview">
                                            <label for="image-upload2" id="image-label2">Pilih Foto 2</label>
                                            <input type="file" name="foto2" id="image-upload2" />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div id="image-preview3" class="image-preview">
                                            <label for="image-upload3" id="image-label3">Pilih Foto 3</label>
                                            <input type="file" name="foto3" id="image-upload3" />
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="invalid-feedback"></div> -->
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary form-control" type="submit"><i class="fas fa-plus-square"></i> Tambah </button>


                </form>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="/assets/js/jquery.uploadPreview.min.js"></script>
<script>
    let jmlVariasiNow = 1;

    function tambahVariasi() {
        if (jmlVariasiNow > 9) {
            alert("Maksimal variasi yang dapat ditambahkan adalah 10!")
        } else {
            $('tambah').append(`
            <hr>
            <div class="form-group row">
                <label for="namavariasi" class="col-sm-2 col-form-label">Variasi Produk</label>
                <div class="col-sm-10">
                    <input type="text" name="variasi[${jmlVariasiNow}][nama]" class="form-control" id="namavariasi" placeholder="XL" required="">
                </div>
            </div>
            <div class="form-group row">
                <label for="stok" class="col-sm-2 col-form-label">Harga Variasi Produk</label>
                <div class="col-sm-10">
                    <input type="number" name="variasi[${jmlVariasiNow}][harga]" class="form-control" id="stok" placeholder="400000" required="">
                </div>
            </div>
            <div class="form-group row">
                <label for="stok" class="col-sm-2 col-form-label">Stok Variasi Produk</label>
                <div class="col-sm-10">
                    <input type="number" name="variasi[${jmlVariasiNow}][stok]" class="form-control" id="stok" placeholder="10" required="">
                </div>
            </div>
            `);
            jmlVariasiNow += 1;
        }
    }
    $(document).ready(function() {
        for (let i = 1; i <= 8; i++) {
            $.uploadPreview({
                input_field: "#image-upload" + i,
                preview_box: "#image-preview" + i,
                label_field: "#image-label" + i,
                label_default: "Pilih Foto " + i,
                label_selected: "Ganti Foto " + i,
                no_label: false,
                success_callback: null
            });
        }
    });
</script>
<?= $this->endSection() ?>