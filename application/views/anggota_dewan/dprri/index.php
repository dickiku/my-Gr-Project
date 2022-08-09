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
              <li class="breadcrumb-item"><?= $title ?></li>
              <li class="breadcrumb-item active">DATA PERIODE DPR-RI</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="container ml-2">
    <a href=" " class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahDprRi">+ Tambah Data PERIODE DPR-RI</a>
</div>
<div class="container ml-2 mb-2">
    <?= $this->session->flashdata('pesan') ?>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <?php foreach($periode as $pr) : ?>
                        <h3 class="card-title">DPRD RI Periode tahun <?= $pr->periode ?></h3>
                    <?php endforeach ?>
                </div>
                <div class="card-body col-md-12 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Dapil</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jenis Kelamin</th>
                                <th class="text-center">Partai</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">No Telefon</th>
                                <th class="text-center">Perolehan Suara</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($data as $row): ?>

                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $row['nama_dapil_ri'] ?></td>
                                        <td><?= $row['nama_dewan'] ?></td>
                                        <td><?= $row['jenis_kelamin'] ?></td>
                                        <td><?= $row['partai'] ?></td>
                                        <td><?= $row['alamat'] ?></td>
                                        <td><?= $row['no_hp_dewan'] ?></td>
                                        <td><?= $row['perolehan_suara'] ?></td>

                                        <?php if($user['level'] == 'Super Admin') : ?>
                                            <td width="300px">
                                                <a href="<?= base_url('anggota_dewan/showEditRi/'.$row['id_anggota_dewan'].'/'.$row['id_periode']) ?>" class="btn btn-info btn-md">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <a href="<?= base_url('anggota_dewan/hapusData/'.$row['id_anggota_dewan'].'/'.$row['id_periode'].'/'.$row['id_role']) ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus');" >
                                                    <i class="fa fa-trash"></i> Hapus
                                                </a>
                                            </td>
                                        <?php elseif($user['level'] == 'Admin' ) : ?>
                                            <td width="300px">
                                                <a href="<?= base_url('anggota_dewan/showEditRi/'.$row['id_anggota_dewan'].'/'.$row['id_periode']) ?>" class="btn btn-info btn-md">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <a href="<?= base_url('anggota_dewan/hapusData/'.$row['id_anggota_dewan'].'/'.$row['id_periode'].'/'.$row['id_role']) ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah Anda Yakin Ingin Menghapus');" >
                                                    <i class="fa fa-trash"></i> Hapus
                                                </a>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                            
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah-->
<div class="modal fade" id="tambahDprRi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data PERIODE DPR-RI</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('anggota_dewan/tambah_dprri/') ?>" method="post">
            <div class="form-group">
                <label>Periode</label>
                <?php foreach($periode as $pr) : ?>
                <input type="hidden" name="id_periode" value="<?= $pr->id_periode_pemilu ?>" class="form-control" required="required">
                <input type="text" name="" value="<?= $pr->periode ?>" class="form-control" required="required" disabled>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Dapil</label>
                <select class="form-control" name="dapil" required>
                    <option value="">--Pilih Dapil--</option>
                    <?php foreach($dapil as $dp) : ?>
                        <option value="<?= $dp['id_dapil_ri'] ?>"> 
                            <?= $dp['nama_dapil_ri'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required="required">
            </div>
            <div class="form-group">
                <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-control" required="required">
                    <option value="">--Pilih Jenis Kelamin--</option>
                    <option value="Laki-Laki" >Laki-Laki</option>
                    <option value="Perempuan" >Perempuan</option>
                </select>
            </div>
            <div class="form-group">
                <label>Partai</label>
                <input type="text" name="partai" value="" class="form-control" required="required">
            </div>
            <div class="form-group">
                <label>No HP</label>
                <input type="text" name="no_hp" value="" class="form-control">
            </div>
            <div class="form-group">
                <label>Alamat</label>
                <textarea name="alamat" id="alamat" cols="30" rows="3" class="form-control"></textarea>
            </div>
            <div class="form-group">
                <label>Perolehan Suara</label>
                <input type="text" name="perolehan_suara" value="" class="form-control">
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