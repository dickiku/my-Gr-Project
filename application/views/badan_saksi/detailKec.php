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
              <li class="breadcrumb-item active">Kepengurusan Badan saksi</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<?php foreach($kecamatan as $kec) : ?>
    <?php $cek = $this->Badan_saksi_model->getDataBsSk(3,$kec['id_kec']); ?>
<?php endforeach ?>
<?php if($cek->num_rows() > 0) { ?>
    
<?php } else { ?>
    <div class="container ml-2">
        <?php foreach($kecamatan as $kec) : ?>
            <a href="<?= base_url('badan_saksi/tambahDataSk/'.'3'.'/'.$kec['id_kec']) ?>" class="btn btn-primary mb-3">+ Tambah Data</a>
        <?php endforeach ?>
    </div>
<?php } ?>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
            <?= $this->session->flashdata('pesan_data'); ?>
                <div class="card mb-3 mx-auto">
                    <div class="card-body">
                        <?php foreach($keterangan as $ket) : ?>
                            <a href="<?= base_url('badan_saksi/showEditSk/'.$ket['id_badan_saksi_sk'].'/'.'3') ?>" class="btn btn-lg btn-warning mb-2">Edit</a>
                        <?php endforeach; ?>
                        <table class="table table-bordered table-striped table-hover" id="myTable">
                            <tbody>
                                <?php foreach($keterangan as $ket) : ?>
                                <tr>
                                    <td><strong>Kecamatan</strong></td>
                                    <td><?= $ket['nm_kec']?></td>
                                </tr>
                                <tr>
                                    <td><strong>No. SK</strong></td>
                                    <td><?= $ket['no_sk']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal SK</strong></td>
                                    <td><?= $ket['tanggal']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Scan SK</strong></td>
                                    <td><?= $ket['scan_sk']?>
        								<a href="<?php echo base_url()."download/file/".$ket['scan_sk'];?>">
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


<div class="container ml-2 mb-2">
    <?= $this->session->flashdata('pesan') ?>
</div>

<div class="container ml-2">
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahPengurusBSKec">+ Tambah Data Kepengurusan Badan Saksi</a>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <?php foreach($kecamatan as $kec) : ?>
                    <h3 class="card-title">Susunan Kepengurusan Badan Saksi Kec <?= $kec['nm_kec']?></h3>
                    <?php endforeach; ?>
                </div>
                <div class="card-body col-md-8 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="20px">Kolom</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center" width="100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data as $kp) : ?>
                            <tr>
                                <td><?= $kp['kolom'] ?></td>
                                <td><?= $kp['nama']?></td>
                                <td><?= $kp['jabatan']?></td>
                                <td>
                                <?php if($user['level'] == 'Super Admin') : ?>
                                    <a href="<?= base_url('badan_saksi/showEdit/'.$kp['id_badan_saksi_kec'].'/'.'1'.'/'.$kp['id_kec']) ?>" class="btn btn-warning btn-md">
                                        Edit
                                    </a>
                                    <a href="<?= base_url('badan_saksi/hapus_pengurus_kec/'.$kp['id_badan_saksi_kec']. '/' .$kp['id_kec']) ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">
                                        Hapus
                                    </a>
                                <?php elseif($user['level'] == 'Admin' ) : ?>
                                    <a href="<?= base_url('badan_saksi/showEdit/'.$kp['id_badan_saksi_kec'].'/'.'1'.'/'.$kp['id_kec']) ?>" class="btn btn-warning btn-md">
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
<div class="modal fade" id="tambahPengurusBSKec" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kepengurusan Badan Saksi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('badan_saksi/tambah_pengurus_kec') ?>" method="post">
            <div class="form-group">
                <label>Kolom</label><label class="text-danger text-lg">*</label>
                <input type="text" name="kolom" value="" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Kecamatan</label>
                <?php foreach($kecamatan as $kec) : ?>
                <input type="hidden" name="id_kec" value="<?= $kec['id_kec']?>" required="required">
                <select class="form-control" disabled>
                    <option value="<?= $kec['id_kec']?>"><?= $kec['nm_kec']?></option>
                </select>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Nama Keanggotaan</label><label class="text-danger text-lg">*</label>
                <input list="keanggotaan" name="keanggotaan" class="form-control" required="required">
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
            <div class="form-group">
                <label>Jabatan</label><label class="text-danger text-lg">*</label>
                <input type="text" name="jabatan" value="" class="form-control" required>
                <!-- <select class="form-control" name="jabatan" required>
                    <option value="">--Pilih Jabatan--</option>
                    <?php foreach($jabatan as $jb) : ?>
                        <option value="<?= $jb['id_jabatan_bs'] ?>"><?= $jb['nama_jabatan'] ?></option>
                    <?php endforeach; ?>
                </select> -->
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