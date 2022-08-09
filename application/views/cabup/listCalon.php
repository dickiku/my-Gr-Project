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
<div class="container ml-2 mb-2 mt-2">
    <?= $this->session->flashdata('pesan') ?>
</div>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary ml-3 mb-2" data-toggle="modal" data-target="#tambahcalonCabup">
  + Tambah Data
</button>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <?php foreach($kabupaten as $kab): 
                          foreach($periode as $per):?>
                          <h3 class="card-title">Calon Bupati <?= $kab['nm_kab'] ?> | Periode : <?= $per['tahun'] ?></h3>
                        <?php endforeach; endforeach; ?>
                    </div>
                    <div class="card-body col-md-12 mx-auto">
                        <table id="example1" class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th width="10px">#</th>
                                    <th>Nama Calon Bupati</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Nama Calon Wakil Bupati</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Partai Pengusung</th>
                                    <th>Jumlah kursi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <?php $no=1; foreach($data as $row) : ?>
                            <tbody>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $row['nama_cabup'] ?></td>
                                    <td><?= $row['jkcalon'] ?></td>
                                    <td><?= $row['nama_cawabup'] ?></td>
                                    <td><?= $row['jkwakil'] ?></td>
                                    <td><?= $row['partai_pengusung'] ?></td>
                                    <td><?= $row['jumlah_kursi'] ?></td>
                                    <td width="150px" class="text-center">
                                        <a href="<?= base_url('cabup/showEditCalon/'). $row['id_cabup'] ?>" class="btn btn-warning">Edit</a>
                                        <a href="<?= base_url('cabup/hapusCalon/'). $row['id_cabup'].'/'.$row['id_tahun'].'/'.$row['id_kab'] ?>" class="btn btn-danger" onclick="return confirm('Apakah yakin anda ingin menghapus data ini?')">Hapus</a>
                                    </td>
                                </tr>
                            </tbody>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
<div class="modal fade" id="tambahcalonCabup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Cagub</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" action="<?= base_url('cabup/tambahCalon') ?>" enctype="multipart/form-data">                             
            <div class="form-group">
              <label>Kabupaten</label>
                <?php foreach($kabupaten as $kab) : ?>
                <input type="hidden" name="id_kab" value="<?= $kab['id_kab'] ?>" class="form-control" required="required">
                <input type="text" name="" value="<?= $kab['nm_kab'] ?>" class="form-control" required="required" disabled>
              <?php endforeach; ?>
              <label>Periode</label>
              <?php foreach($periode as $p) : ?>
                <input type="hidden" class="form-control" name="id_tahun" value="<?= $p['id_tahun'] ?>">
                <input type="text" class="form-control" value="<?= $p['tahun'] ?>" disabled>
              <?php endforeach; ?>
            </div>
            <div class="form-group">
              <label>Nama Calon Bupati</label>
              <input type="text" class="form-control" name="nama_cabup" value="" required="required">
            </div>
            <div class="form-group">
            <label>Jenis Kelamin Cabup</label>
            <select name="jkcalon" class="form-control" required="required">
              <option value="">--Pilih Jenis Kelamin--</option>
              <option value="Laki-Laki" >Laki-Laki</option>
              <option value="Perempuan" >Perempuan</option>
            </select>
            </div>
            <div class="form-group">
              <label>Nama Calon Wakil Bupati</label>
              <input type="text" class="form-control" name="nama_cawabup" value="" required="required">
            </div>
            <div class="form-group">
            <label>Jenis Kelamin Cawabup</label>
            <select name="jkwakil" class="form-control" required="required">
              <option value="">--Pilih Jenis Kelamin--</option>
              <option value="Laki-Laki" >Laki-Laki</option>
              <option value="Perempuan" >Perempuan</option>
            </select>
            </div>
            <div class="form-group">
              <label>Partai Pengusung</label>
              <textarea name="partai_pengusung" id="parpol" cols="30" rows="5" class="ckeditor form-control" required="required"></textarea>
            </div>
            <div class="form-group">
              <label>Jumlah Kursi</label>
              <input type="text" class="form-control" name="jumlah_kursi" value="" required="required">
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