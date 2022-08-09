<?php
    $user = $this->session->userdata('userdata');
    $id_kab = $this->session->userdata('id_kab');
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
              <li class="breadcrumb-item active">Kabupaten/Kota</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<?php foreach($wilayah as $w) : ?>
<?php foreach($sayap as $row) : ?>
    <?php $cekKabupaten = $this->Sayap_partai_model->getDataSayapPartaiDomKab($w['id_kab'],$row['id_sayap_partai']); ?>
<?php endforeach; ?>
<?php endforeach; ?>
<?php if($cekKabupaten->num_rows() > 0) { ?>
    
<?php } else { ?>
    <div class="container ml-2">
        <a href="<?= base_url('sayap_partai/tambahDomSayapPartaiKab') ?>" class="btn btn-primary mb-3">+ Tambah Data</a>
    </div>
<?php } ?>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
            <?= $this->session->flashdata('pesan') ?>
                <div class="card mb-3 mx-auto">
                    <div class="card-body">
                        <?php foreach($dom as $row) : ?>
                        <a href="<?= base_url('sayap_partai/editDomSayapPartaiKab/').$row['id_dom_sayap_partai'] ?>" class="btn btn-lg btn-warning mb-2">Edit</a>
                        <table class="table table-bordered table-striped table-hover" id="myTable">
                            <tbody>
                                <tr>
                                    <td><strong>Wilayah</strong></td>
                                    <td>Sayap Partai Kabupaten</td>
                                </tr>
                                <?php foreach($sayap as $s) : ?>
                                <tr>
                                    <td><strong>Nama Sayap Partai</strong></td>
                                    <td><?= $s['nama_sayap_partai']?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php foreach($wilayah as $w) : ?>
                                <tr>
                                    <td><strong>Kabupaten/Kota</strong></td>
                                    <td><?= $w['nm_kab']?></td>
                                </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td><strong>Alamat</strong></td>
                                    <td><?= $row['alamat']?></td>
                                </tr>
                                <tr>
                                    <td><strong>No Telp</strong></td>
                                    <td><?= $row['no_telp']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Scan SK</strong></td>
                                    <td><?= $row['scan_sk']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Foto Kantor</strong></td>
                                    <td>
                                        <img src="<?= base_url('uploads/').$row['foto_kantor'] ?>" class="card-img-top card-img img-thumbnail mt-2" style="max-width: 140px;">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <?php endforeach; ?>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container ml-2">
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahKepengurusanSayapPartai">+ Tambah Data Kepengurusan Sayap Partai</a>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Susunan Kepengurusan Kabupaten/Kota</h3>
                </div>
                <div class="card-body col-md-8 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <!-- <th class="text-center" width="20px">#</th> -->
                                <th class="text-center" width="20px">Kolom</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center" width="100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($kepengurusan as $kp) : ?>
                            <tr>
                                <!-- <td><?= $no++ ?></td> -->
                                <td><?= $kp['kolom']?></td>
                                <td><?= $kp['nama']?></td>
                                <td><?= $kp['nama_jabatan']?></td>
                                <td>
                                <?php if($user['level'] == 'Super Admin') : ?>
                                    <a href="<?= base_url('sayap_partai/editKepengurusanKabupaten/').$kp['id_pengurus_sayap_partai'] ?>" class="btn btn-warning btn-md">
                                        Edit
                                    </a>
                                    <a href="<?= base_url('sayap_partai/hapusKepengurusanKabupaten/').$kp['id_pengurus_sayap_partai'] ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">
                                        Hapus
                                    </a>
                                <?php elseif($user['level'] == 'Admin' ) : ?>
                                    <a href="<?= base_url('sayap_partai/editKepengurusanKabupaten/').$kp['id_pengurus_sayap_partai'] ?>" class="btn btn-warning btn-md">
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
<div class="modal fade" id="tambahKepengurusanSayapPartai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kepengurusan Sayap Partai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('sayap_partai/tambah_kepengurusan_proses_kabupaten') ?>" method="post">
            <div class="form-group">
                <input type="hidden" name="id_prov" value="33">
            </div>
            <div class="form-group">
                <label>Kabupaten/Kota</label>
                <?php foreach($wilayah as $w) : ?>
                <input type="hidden" name="id_kab" value="<?= $w['id_kab']?>" class="form-control">
                <input type="text" value="<?= $w['nm_kab']?>" class="form-control" disabled>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Sayap Partai</label>
                <?php foreach($sayap as $s) : ?>
                <input type="hidden" name="id_sayap_partai" value="<?= $s['id_sayap_partai']?>" class="form-control">
                <input type="text" value="<?= $s['nama_sayap_partai']?>" class="form-control" disabled>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Kolom</label>
                <input type="text" name="kolom" class="form-control">
            </div>
            <div class="form-group">
                <label>Nama Keanggotaan</label><label class="text-danger text-lg">*</label>
                <input list="keanggotaan" name="keanggotaan" class="form-control">
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