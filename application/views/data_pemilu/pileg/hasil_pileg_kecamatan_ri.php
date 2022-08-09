<?php
    $user = $this->session->userdata('userdata');
?>
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
                                <tr>
                                    <td><strong>BAGIAN</strong></td>
                                    <td>DPR-RI</td>
                                </tr>
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
                                <?php foreach($wilayahKec as $wkc) : ?>
                                <tr>
                                    <td><strong>KECAMATAN</strong></td>
                                    <td><?= $wkc['nm_kec'] ?></td>
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

<button type="button" class="btn btn-primary ml-3 mb-2" data-toggle="modal" data-target="#exampleModal">
  + Tambah Data
</button>
<section class="content">
    <?= $this->session->flashdata('pesan'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Pileg</h3>
                </div>
                <div class="card-body col-md-8 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px;">#</th>
                                <th class="text-center" >Nama Partai</th>
                                <th class="text-center" >Perolehan Suara</th>
                                <th class="text-center" style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($data as $row) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama_partai'] ?></td>
                                <td><?= number_format($row['perolehan'],0,',','.') ?></td>
                                <td>
                                <?php if($user['level'] == 'Super Admin') : ?>
                                    <a href="<?= base_url('pileg/editHasilPilegKecamatanRi/'). $row['id_hasil_pileg'] ?>" class="btn btn-warning">Edit</a>
                                    <a href="<?= base_url('pileg/hapusHasilPilegKecamatanRi/'). $row['id_hasil_pileg'] ?>" class="btn btn-danger" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">Hapus</a>
                                <?php elseif($user['level'] == 'Admin' ) : ?>
                                    <a href="<?= base_url('pileg/editHasilPilegKecamatanRi/'). $row['id_hasil_pileg'] ?>" class="btn btn-warning">Edit</a>
                                <?php endif;?>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?= base_url('pileg/tambah_hasil_pileg_kecamatan_ri_proses') ?>" enctype="multipart/form-data">
            <div class="form-group">
                <div class="form-group">
                    <label>Bagian</label>
                    <input type="text" class="form-control" value="DPR-RI" disabled>
                </div>
                <label>Periode Pemilu</label>
                <?php foreach($periode as $p) : ?>
                <input type="hidden" name="id_periode_pemilu" class="form-control" value="<?= $p['id_periode_pemilu'] ?>">
                <input type="text" class="form-control" value="<?= $p['periode'] ?>" disabled>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Kabupaten/Kota</label>
                <?php foreach($wilayahKab as $wk) : ?>
                <input type="text" class="form-control" value="<?= $wk['nm_kab'] ?>" disabled>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Kecamatan</label>
                <?php foreach($wilayahKec as $wkc) : ?>
                <input type="hidden" name="id_kec" class="form-control" value="<?= $wkc['id_kec'] ?>">
                <input type="text" class="form-control" value="<?= $wkc['nm_kec'] ?>" disabled>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Nama Partai</label><label class="text-danger text-lg">*</label>
                <select name="partai" class="form-control">
                    <option value="">--Pilih Partai--</option>
                    <?php $no=1; foreach($partai as $p) : ?>
                        <option value="<?= $p['id_partai'] ?>"><?= $p['nama_partai'] ?></option>
                    <?php endforeach; ?>
                </select>
                
                <?php echo form_error('partai'); ?>
            </div>
            <div class="form-group">
                <label>Perolehan Suara</label><label class="text-danger text-lg">*</label>
                <input type="text" class="form-control" name="perolehan" value="<?= set_value('perolehan') ?>">
                <?php echo form_error('perolehan'); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>