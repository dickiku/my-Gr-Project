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
              <li class="breadcrumb-item active">Detail Kepengurusan Ranting</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<?php foreach($desa as $row) : ?>
    <?php $cekdesa = $this->Ranting_model->getDataRantingByIdDesa($row['id_desa']); ?>
<?php endforeach; ?>
<?php if($cekdesa->num_rows() > 0) { ?>
    
<?php } else { ?>
    <div class="container ml-2">
        <a href="<?= base_url('ranting/tambah') ?>" class="btn btn-primary mb-3">+ Tambah Data</a>
    </div>
<?php } ?>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
            <?= $this->session->flashdata('pesan') ?>
                <div class="card mb-3 mx-auto">
                    <div class="card-body">
                        <?php foreach($data as $row) : ?>
                        <a href="<?= base_url('ranting/edit/').$row['id_ranting'] ?>" class="btn btn-lg btn-warning mb-2">Edit</a>
                        <?php endforeach; ?>
                        <table class="table table-bordered table-striped table-hover" id="myTable">
                            <tbody>
                                <?php foreach($kabupaten as $row) : ?>
                                <tr>
                                    <td width="150px"><strong>Nama Kab/Kota</strong></td>
                                    <td><?= $row['nm_kab']?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php foreach($kecamatan as $row) : ?>
                                <tr>
                                    <td><strong>Nama Kecamatan</strong></td>
                                    <td><?= $row['nm_kec']?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php foreach($desa as $row) : ?>
                                <tr>
                                    <td><strong>Nama Desa</strong></td>
                                    <td><?= $row['nm_desa']?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php foreach($data as $row) : ?>
                                <tr>
                                    <td><strong>Alamat</strong></td>
                                    <td><?= $row['alamat']?></td>
                                </tr>
                                <tr>
                                    <td><strong>No. Telp</strong></td>
                                    <td><?= $row['no_telp']?></td>
                                </tr>
                                <tr>
                                    <td><strong>No. SK</strong></td>
                                    <td><?= $row['no_sk']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal SK</strong></td>
                                    <td><?= $row['tanggal_sk']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Admin</strong></td>
                                    <td><?= $row['admin']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Sosial Media</strong></td>
                                    <td>
                                        <a href="<?= $row['link_facebook']?>">Facebook</a> |
                                        <a href="<?= $row['link_instagram']?>">Instagram</a> |
                                        <a href="<?= $row['link_tiktok']?>">Tiktok</a> 
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Scan SK</strong></td>
                                    <td><?= $row['scan_sk']?>
        								<a href="<?php echo base_url()."download/file/".$row['scan_sk'];?>">
        									<i class="fa fa-download" aria-hidden="true"></i>
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
    </div>
</section>

<div class="container ml-2">
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahKepengurusanRanting">+ Tambah Data Kepengurusan Ranting</a>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Susunan Kepengurusan</h3>
                </div>
                <div class="card-body col-md-8 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 20px;">Kolom</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center" width="100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($kepengurusan as $kp) : ?>
                            <tr>
                                <td><?= $kp['kolom'] ?></td>
                                <td><?= $kp['nama']?></td>
                                <td><?= $kp['nama_jabatan']?></td>
                                <td>
                                <?php if($user['level'] == 'Super Admin') : ?>
                                    <a href="<?= base_url('ranting/editKepengurusan/').$kp['id_pengurus_ranting'] ?>" class="btn btn-warning btn-md">
                                        Edit
                                    </a>
                                    <a href="<?= base_url('ranting/hapusKepengurusan/').$kp['id_pengurus_ranting'] ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">
                                        Hapus
                                    </a>
                                <?php elseif($user['level'] == 'Admin' ) : ?>
                                    <a href="<?= base_url('ranting/editKepengurusan/').$kp['id_pengurus_ranting'] ?>" class="btn btn-warning btn-md">
                                        Edit
                                    </a>
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

<!-- Modal Tambah-->
<div class="modal fade" id="tambahKepengurusanRanting" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kepengurusan Ranting</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('ranting/tambah_kepengurusan_proses') ?>" method="post">
            <?php foreach($data as $row) : ?>
                <div class="form-group">
                    <label>Kolom</label><label class="text-danger text-lg">*</label>
                    <input type="text" name="kolom" class="form-control">
                    <?php echo form_error('kolom'); ?>
                </div>
                <div class="form-group">
                    <label>Kabupaten/Kota</label>
                    <select class="form-control" disabled>
                        <option value="<?= $row['id_kab']?>"><?= $row['nm_kab']?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kecamatan</label>
                    <select class="form-control" disabled>
                        <option value="<?= $row['id_kec']?>"><?= $row['nm_kec']?></option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kelurahan/Desa</label>
                    <input type="hidden" name="id_desa" value="<?= $row['id_desa']?>">
                    <input type="hidden" name="id_ranting" value="<?= $row['id_ranting']?>">
                    <select class="form-control" disabled>
                        <option value="<?= $row['id_desa']?>"><?= $row['nm_desa']?></option>
                    </select>
                </div>
            <?php endforeach; ?>
            <div class="form-group">
                <label>Nama Keanggotaan</label><label class="text-danger text-lg">*</label>
                <input list="keanggotaan" name="keanggotaan" class="form-control" placeholder="Pilih Keanggotaan">
                <datalist id="keanggotaan">
                    <option value="">--Pilih Keanggotaan--</option>
                    <?php if($user['id_kab']) { ?>
                        <?php foreach($keanggotaanKab as $kgk) : ?>
                            <option value="<?= $kgk['id_keanggotaan'] ?>"> 
                                <?= $kgk['nama'] ?> | 
                                <?= $kgk['no_kta'] ?>
                            </option>
                        <?php endforeach; ?>
                    <?php } else { ?>
                        <?php foreach($keanggotaan as $kg) : ?>
                            <option value="<?= $kg['id_keanggotaan'] ?>"> 
                                <?= $kg['nama'] ?> | 
                                <?= $kg['no_kta'] ?>
                            </option>
                        <?php endforeach; ?>
                    <?php } ?>
                </datalist>
                <?php echo form_error('keanggotaan'); ?>
            </div>
            <div class="form-group">
                <label>Jabatan</label><label class="text-danger text-lg">*</label>
                <select class="form-control" name="jabatan">
                    <option value="">--Pilih Jabatan--</option>
                    <?php foreach($jabatan as $jb) : ?>
                        <option value="<?= $jb['id_jabatan'] ?>"><?= $jb['nama_jabatan'] ?></option>
                    <?php endforeach; ?>
                </select>
                <?php echo form_error('jabatan'); ?>
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