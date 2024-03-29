<?= $this->extend('templates/dashboard-template') ?>

<?= $this->section('styles') ?>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<section class="section">
    <div class="section-header">
    <h1><?= $title ?></h1>
    <div class="section-header-breadcrumb">
        <div class="breadcrumb-item active"><a href="/produk">Dashboard</a></div>
        <div class="breadcrumb-item"><a href="/produk"><?= $title ?></a></div>
        <div class="breadcrumb-item"><?= $title ?></div>
    </div>
    </div>

    <?= $this->include('templates/partials/alert') ?>

    <div class="section-body">
        <div class="card">
            <div class="card-body">
                <?= form_open() ?>
                    <?= csrf_field() ?>
                    <div class="form-group row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama Kategori</label>
                        <div class="col-sm-10">
                            <input type="text" name="nama_kategori" class="form-control" id="nama" placeholder="Masukkan nama kategori"  value="<?= $data_kategori['nama'] ?>">
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Update</button>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection() ?>