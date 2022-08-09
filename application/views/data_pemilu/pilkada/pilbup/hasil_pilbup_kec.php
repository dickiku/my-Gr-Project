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
                                <?php foreach($tahun as $p) : ?>
                                <tr>
                                    <td><strong>PERIODE</strong></td>
                                    <td><?= $p['tahun'] ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php foreach($wilayahKec as $wk) : ?>
                                <tr>
                                    <td><strong>KECAMATAN</strong></td>
                                    <td><?= $wk['nm_kec']?></td>
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
                    <h3 class="card-title">Tabel Pilpres</h3>
                </div>
                <div class="card-body col-md-12 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px;">#</th>
                                <th class="text-center" >Nama Cagub</th>
                                <th class="text-center" >Nama Cawagub</th>
                                <th class="text-center" >Perolehan Suara</th>
                                <th class="text-center" style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($data as $row) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama_cabup'] ?></td>
                                <td><?= $row['nama_cawabup'] ?></td>
                                <td><?= number_format($row['perolehan'],0,',','.') ?></td>
                                <td>
                                    <a href="<?= base_url('pilkada/pilbup_showhasilPerolehanKec/'). $row['id_hasil_pilbup'].'/'.$row['id_kec'] ?>" class="btn btn-warning">Edit</a>
                                    <a href="<?= base_url('pilkada/pilbup_hapusHasilPilbupKec/'). $row['id_hasil_pilbup'].'/'.$row['id_kec'] ?>" class="btn btn-danger" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">Hapus</a>
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
        <form method="post" action="<?= base_url('pilkada/pilbub_tambahHasilPerolehanKec_proses') ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label>Periode</label>
                <?php foreach($tahun as $p) : ?>
                  <input type="hidden" class="form-control" name="id_tahun" value="<?= $p['id_tahun'] ?>">
                  <input type="text" class="form-control" value="<?= $p['tahun'] ?>" disabled>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Kecamatan</label>
                <?php foreach($wilayahKec as $wk) : ?>
                <input type="hidden" name="id_kec" class="form-control" value="<?= $wk['id_kec'] ?>">
                <input type="text" class="form-control" value="<?= $wk['nm_kec'] ?>" disabled>
                <?php endforeach; ?>
            </div>
            <div class="form-group">
                <label>Cabup & Cawabup</label>
                <select name="cabup" class="form-control" required="required">
                    <option value="">--Pilih Cabup & Cawabup--</option>
                    <?php $no=1; foreach($calon as $c) : ?>
                    <option value="<?= $c['id_cabup'] ?>">
                        <?= $no++ .'.  '. $c['nama_cabup'] ." & ". $c['nama_cawabup'] ?> 
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Perolehan Suara</label>
                <input type="text" class="form-control" name="perolehan" value="<?= set_value('perolehan') ?>">
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