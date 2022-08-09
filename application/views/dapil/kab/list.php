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
              <li class="breadcrumb-item active">Dapil Kab</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="container ml-2 mb-2">
    <?= $this->session->flashdata('pesan') ?>
</div>

<div class="container ml-2">
    <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#tambahDapilRi">+ Tambah Data Dapil Kab</a>
</div>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <?php foreach($kabupaten as $kab) : ?>
                    <h3 class="card-title">Daftar Wilayah Dapil DPRD Kab <?= $kab['nm_kab']?></h3>
                    <?php endforeach; ?>
                </div>
                <div class="card-body col-md-8 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" width="20px">#</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Wilayah</th>
                                <th class="text-center" width="100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($list as $kp) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $kp['nama_dapil_kab']?></td>
                                <td><?= $kp['wilayah']?></td>
                                <td>
                                    <a href="<?= base_url('dapil/showEditKab/'.$kp['id_dapil_kab']) ?>" class="btn btn-warning btn-md">
                                        Edit
                                    </a>
                                    <a href="<?= base_url('dapil/hapusKab/'.$kp['id_dapil_kab'].'/'.$kp['id_kab']) ?>" class="btn btn-danger btn-md" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">
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
<div class="modal fade" id="tambahDapilRi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Dapil DPRD Kab</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="<?= base_url('dapil/tambah_dapil_kab') ?>" method="post">
            <div class="form-group">
                <label>Kabupaten</label>
                <?php foreach($kabupaten as $kab): ?>
                <input type="text" name="kab" value="<?= $kab['nm_kab']?>" class="form-control" required="required" disabled>
                <input type="hidden" name="id_kab" value="<?= $kab['id_kab']?>">
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Nama dapil</label><label class="text-danger text-lg">*</label>
                <input type="text" name="nama" value="" class="form-control" required="required">
            </div>
            <div class="form-group">
                <label>Wilayah</label><label class="text-danger text-lg">*</label>
                <input type="text" name="wilayah" value="" class="form-control" required="required">
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