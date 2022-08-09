<?php $user = $this->session->userdata('userdata'); ?>

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?= $title ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?= $title ?></li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-3 mx-auto">
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover" id="myTable">
                            <tbody>
                                <?php foreach($periode as $p) : ?>
                                <tr>
                                    <td><strong>PERIODE</strong></td>
                                    <td><?= $p['periode'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php foreach($wilayahKab as $wk) : ?>
                                <tr>
                                    <td><strong>KABUPATEN/KOTA</strong></td>
                                    <td><?= $wk['nm_kab']?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>

<button type="button" class="btn btn-primary ml-3 mb-3" data-toggle="modal" data-target="#exampleModal">
  + Tambah Data
</button>
<section class="content">
    <div class="row">
        <div class="col-md-12">
        <?= $this->session->flashdata('pesan') ?>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Perolehan Kursi</h3>
                </div>
                <div class="card-body col-md-8 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px;">#</th>
                                <th class="text-center" >Nama Partai</th>
                                <th class="text-center" >Jumlah Kursi</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($wilayah as $row ) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama_partai'] ?></td>
                                <td><?= $row['jumlah_kursi'] ?></td>
                                <td>
                                    <a href="<?= base_url('perolehan_kursi/editPerolehanKursi/'). $row['id_perolehan_kursi'] ?>" class="btn btn-warning btn-md">
                                        Edit
                                    </a>
                                    <a href="<?= base_url('perolehan_kursi/hapusPerolehanKursi/'). $row['id_perolehan_kursi'] ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Perolehan Kursi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?= base_url('perolehan_kursi/tambahPerolehanKursi_proses') ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Partai</label><label class="text-danger text-lg">*</label>
                <?php foreach($periode as $p) : ?>
                <input type="hidden" name="id_periode" class="form-control" value="<?= $p['id_periode_pemilu']?>">
                <?php endforeach; ?>
                <?php foreach($wilayahKab as $wk) : ?>
                <input type="hidden" name="id_kab" class="form-control" value="<?= $wk['id_kab']?>">
                <?php endforeach; ?>
                <input type="text" name="nama_partai" class="form-control" value="<?= set_value('nama_partai')?>">
                <?php echo form_error('nama_partai'); ?>
            </div>
            <div class="form-group">
                <label>Jumlah Kursi</label><label class="text-danger text-lg">*</label>
                <input type="text" name="jumlah_kursi" class="form-control" value="<?= set_value('jumlah_kursi')?>">
                <?php echo form_error('jumlah_kursi'); ?>
            </div>
            <button type="submit" class="btn btn-primary">Tambah</button>
        </form>
      </div>
    </div>
  </div>
</div>