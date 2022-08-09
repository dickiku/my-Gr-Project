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
              <?php foreach($data as $row) : ?>
              <li class="breadcrumb-item"><?= $row['nm_kab']?></li>
              <li class="breadcrumb-item active"><?= $row['nm_kec']?></li>
              <?php endforeach; ?>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3 mx-auto">
                    <div class="card-body">
                        <?php foreach($data as $row) : ?>
                            <a href="<?= base_url('pac/edit/').$row['id_pac'] ?>" class="btn btn-lg btn-warning mb-2">Edit</a>
                        <?php endforeach; ?>
                        <table class="table table-bordered table-striped table-hover" id="myTable">
                            <tbody>
                                <?php foreach($data as $row) : ?>
                                <tr>
                                    <td><strong>Kabupaten/Kota</strong></td>
                                    <td><?= $row['nm_kab'] ?></td>
                                </tr>
                                <tr>
                                    <td><strong>Kecamatan</strong></td>
                                    <td><?= $row['nm_kec'] ?></td>
                                </tr>
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
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahKepengurusanPAC">+ Tambah Data Kepengurusan PAC</a>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <?php foreach($data as $row) : ?>
                        <h3 class="card-title">Susunan Kepengurusan <?= $row['nm_kec']?></h3>
                    <?php endforeach; ?>
                </div>
                <div class="card-body col-md-8 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="20px">#</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Jabatan</th>
                                <th class="text-center" width="100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($kepengurusan as $kp) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $kp['nama']?></td>
                                <td><?= $kp['nama_jabatan']?></td>
                                <td>
                                    <a href="<?= base_url('pac/editKepengurusan/').$kp['id_pengurus_pac'] ?>" class="btn btn-warning btn-md">
                                        Edit
                                    </a>
                                    <a href="<?= base_url('pac/hapusKepengurusan/').$kp['id_pengurus_pac'] ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">
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

<!-- Modal Tambah-->
<div class="modal fade" id="tambahKepengurusanPAC" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Kepengurusan PAC</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('pac/tambah_kepengurusan_proses') ?>" method="post">
            <div class="form-group">
                <label>Kabupaten/Kota</label>
                <?php foreach($data as $row) : ?>
                <select class="form-control" disabled>
                    <option value="<?= $row['id_kab']?>"><?= $row['nm_kab']?></option>
                </select>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Kecamatan</label>
                <?php foreach($data as $row) : ?>
                <input type="hidden" name="kecamatan" value="<?= $row['id_kec']?>">
                <select class="form-control" disabled>
                    <option value="<?= $row['id_kec']?>"><?= $row['nm_kec']?></option>
                </select>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Nama Keanggotaan</label>
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
            <div class="form-group">
                <label>Jabatan</label>
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