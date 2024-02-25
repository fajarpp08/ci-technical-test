<?= $this->extend('templates/dashboard-template') ?>
<?php helper('rupiah') ?>
<?= $this->section('content') ?>
<section class="section">
  <div class="section-header">
    <h1><?= $title ?></h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
      <div class="breadcrumb-item">Produk</div>
    </div>
  </div>
  <?= $this->include('templates/partials/alert') ?>
  <div class="section-body">
    <div class="card">
      <div class="card-body">
        <div class="table-responsive">

          <table id="tabel-produk" class="table table-striped table-bordered" style="width:100%">
            <thead>
              <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Total Stok</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Foto</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 1;
              $z = 0;
              $ukuran = "";
              foreach ($data_produk as $produk) : ?>
                <?php
                foreach ($produk['data_stok'] as $stok) {
                  if ((count($produk['data_stok']) - 1) != $z) {
                    $ukuran .= $stok['ukuran'] . "\t: " . $stok['stok'] . "</br>";
                  } else {
                    $ukuran .= $stok['ukuran'] . "\t: " . $stok['stok'];
                  }
                  $z++;
                }
                ?>
                <tr>
                  <td><?= $i++ ?></td>
                  <td><?= $produk['data_produk']['nama'] ?></td>
                  <td><?= $ukuran ?></td>
                  <td><?= $produk['data_produk']['deskripsi'] ?></td>
                  <td><?= format_rupiah($stok['harga']) ?></td>
                  <td><button class="openGambar btn btn-primary" data-toggle="modal" data-target="#fotoModal" data-alamatgambar="<?= $produk['data_produk']['gambar'] ?>"><i class="fas fa-image"></i></button></td>
                  <td>
                    <a href="<?= base_url('produk/edit/' . $produk['data_produk']['url_slug']) ?> " class="btn btn-success"><i class="fas fa-edit"></i></a> <!-- tambahin /kodeproduk -->
                    <button class="deleteProduct btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="<?= $produk['data_produk']['id'] ?>"><i class="fas fa-trash-alt"></i></button>
                  </td>
                </tr>
              <?php $ukuran = "";
              endforeach; ?>
              </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- deskripsi Modal -->
<div class="modal fade" id="deskripsiModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <p id="textDeskripsi"></p>
      </div>
    </div>
  </div>
</div>

<!-- foto Modal -->
<div class="modal fade" id="fotoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <img id="srcGambar" width="300px" height="300px" class="img-fluid">
      </div>
    </div>
  </div>
</div>

<!-- delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        Yakin ingin menghapusnya ?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
        <form id="deleteForm" method="GET"> <!-- Tambahin /id -->
          <button type="submit" class="btn btn-danger">Ya</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('javascript') ?>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.print.min.js"></script>
<script>
  $(document).ready(function() {
    // Inisialisasi DataTable dengan beberapa opsi dan tombol
    $('#tabel-produk').DataTable({
      dom: 'Bfrtip',
      buttons: [{
          extend: 'pageLength',
          className: 'btn btn-sm btn-outline-primary',
          text: '<i class="fas fa-list mr-1"></i> Page Length'
        },
        {
          extend: 'excel',
          className: 'btn btn-sm btn-outline-primary',
          text: '<i class="fas fa-file-excel mr-1"></i> Excel'
        },
        {
          extend: 'print',
          className: 'btn btn-sm btn-outline-primary',
          text: '<i class="fas fa-print mr-1"></i> Print',
          exportOptions: {
            columns: [0, 1, 2, 4] // Sesuaikan indeks kolom yang ingin di-print
          },
          customize: function(win) {
            $(win.document.body).find('table').addClass('table').css('font-size', '12px');
            $(win.document.body).find('thead tr th').addClass('bg-primary text-white');
            $(win.document.body).find('tbody tr').addClass('bg-light');
            $(win.document.body).find('td').css('white-space', 'normal'); // Agar deskripsi tidak satu baris
          }
        }
      ],
      lengthMenu: [
        [10, 25, 50, -1],
        ['10 Items', '25 Items', '50 Items', 'All Items']
      ],

    });




    $('#tabel-produk').DataTable();
    $('.openGambar').on("click", function() {
      $('#srcGambar').attr("src", "<?= base_url('assets/img/produk') ?>" + "/" + ($(this).data('alamatgambar')).toString());
    });
    $('.openDeskripsi').on("click", function() {
      $("#textDeskripsi").empty();
      $("#textDeskripsi").append($(this).data('deskripsi'));
    });
    $('.deleteProduct').on('click', function() {
      $('#deleteForm').attr("action", "<?= base_url('produk/hapus-produk') ?>/" + ($(this).data('id')));
    })
  });
</script>
<?= $this->endSection() ?>