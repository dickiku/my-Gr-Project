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
              <li class="breadcrumb-item active">Edit Calon Bupati</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container">
    <?= $this->session->flashdata('pesan'); ?>
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3 mx-auto">
                    <div class="card-body">
                        <?php foreach($data as $row) : ?>
                        <form method="post" action="<?= base_url('cabup/prosesEditCalon/') ?>" enctype="multipart/form-data">
                            <input type="hidden" name="id_cabup" value="<?= $row['id_cabup']?>">
                            <div class="form-group">
                                <label>Periode</label>
                                <input type="hidden" class="form-control" name="id_tahun" value="<?= $row['id_tahun'] ?>">
                                <input type="text" class="form-control" value="<?= $row['tahun'] ?>" disabled>
                            </div>
                            <div>
                                <label>Kabupaten/Kota</label>
                                <input type="hidden" name="id_kab" value="<?= $row['id_kab'] ?>">
                                <input type="text" name="" value="<?= $row['nm_kab'] ?>" class="form-control" required="required" disabled>
                            </div>
                            <div class="form-group">
                                <label>Nama Calon Bupati</label>
                                <input type="text" class="form-control" name="nama_cabup" value="<?= $row['nama_cabup'] ?>" required="required">
                            </div>
                            <div class="form-group">
                            <label>Jenis Kelamin Cabup</label>
                            <select name="jkcalon" class="form-control" required="required">
                                <option value="">--Pilih Jenis Kelamin--</option>
                                <option value="Laki-Laki" <?php if($row['jkcalon'] == 'Laki-Laki'){echo "selected";} ?> >Laki-Laki</option>
                                <option value="Perempuan" <?php if($row['jkcalon'] == 'Perempuan'){echo "selected";} ?> >Perempuan</option>
                            </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Calon Wakil Bupati</label>
                                <input type="text" class="form-control" name="nama_cawabup" value="<?= $row['nama_cawabup'] ?>" required="required">
                            </div>
                            <div class="form-group">
                            <label>Jenis Kelamin Cawabup</label>
                            <select name="jkwakil" class="form-control" required="required">
                                <option value="">--Pilih Jenis Kelamin--</option>
                                <option value="Laki-Laki" <?php if($row['jkwakil'] == 'Laki-Laki'){echo "selected";} ?> >Laki-Laki</option>
                                <option value="Perempuan" <?php if($row['jkwakil'] == 'Perempuan'){echo "selected";} ?> >Perempuan</option>
                            </select>
                            </div>
                            <div class="form-group">
                                <label>Partai Pengusung</label>
                                <textarea name="partai_pengusung" id="parpol" cols="30" rows="5" class="ckeditor form-control" required="required"><?= $row['partai_pengusung'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Kursi</label>
                                <input type="text" class="form-control" name="jumlah_kursi" value="<?= $row['jumlah_kursi'] ?>" required="required">
                            </div>
                            <button type="submit" class="btn btn-primary mt-4">Ubah Data</button>
                       </form>
                       <?php endforeach; ?>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>