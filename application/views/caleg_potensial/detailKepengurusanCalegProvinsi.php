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

<div class="container ml-2 mb-2">
    <?= $this->session->flashdata('pesan') ?>
</div>

<button type="button" class="btn btn-primary ml-3 mb-3" data-toggle="modal" data-target="#exampleModal">
  + Tambah Data Caleg Potensial
</button>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Caleg Potensial </h3>
                </div>
                <div class="card-body col-md-8 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                            <?php if($user['level'] == 'Super Admin') : ?>
                                <th class="text-center" style="width: 10px;">#</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">No. HP</th>
                                <th class="text-center" style="width: 60px;">Aksi</th>
                            <?php elseif($user['level'] == 'Admin' ) : ?>
                                <th class="text-center" style="width: 10px;">#</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Alamat</th>
                                <th class="text-center">No. HP</th>
                            <?php endif;?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($data as $row) : ?>
                            <tr>
                            <?php if($user['level'] == 'Super Admin') : ?>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td><?= $row['alamat'] ?></td>
                                <td><?= $row['no_hp'] ?></td>
                                <td>
                                    <a href="<?= base_url('caleg_potensial/hapusDataKepengurusanCalegProvinsi/').$row['id_caleg_potensial'] ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">
                                        Hapus
                                    </a>
                                </td>
                            <?php elseif($user['level'] == 'Admin' ) : ?>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td><?= $row['alamat'] ?></td>
                                <td><?= $row['no_hp'] ?></td>
                            <?php endif;?>
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
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Caleg Potensial</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?= base_url('caleg_potensial/tambahCalegPotensial_proses_provinsi') ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label>Nama Dapil</label>
                <?php foreach($dapil as $row) : ?>
                <input type="hidden" name="id_dapil_prov" class="form-control" value="<?= $row['id_dapil_prov']?>">
                <input type="text" class="form-control" value="<?= $row['nama_dapil_prov']?>" disabled>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Nama Keanggotaan</label><label class="text-danger text-lg">*</label>
                <input list="keanggotaan" name="keanggotaan" class="form-control">
                <datalist id="keanggotaan">
                    <option value="">--Pilih Keanggotaan--</option>
                    <?php foreach($keanggotaan as $kg) : ?>
                        <option value="<?= $kg['id_keanggotaan'] ?>"> 
                            <?= $kg['nama'] ?> | 
                            <?= $kg['no_kta'] ?>
                        </option>
                    <?php endforeach; ?>
                </datalist>
                <?php echo form_error('keanggotaan'); ?>
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