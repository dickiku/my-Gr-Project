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
              <li class="breadcrumb-item active">Edit Calon Gubernur</li>
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
                        <form method="post" action="<?= base_url('cagub/prosesEditCalon/') ?>" enctype="multipart/form-data">
                            <input type="hidden" name="id_cagub" value="<?= $row['id_cagub']?>">
                            <div class="form-group">
                                <label>Periode</label>
                                <input type="hidden" class="form-control" name="id_tahun" value="<?= $row['id_tahun'] ?>">
                                <input type="text" class="form-control" value="<?= $row['tahun'] ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>Nama Calon Gubernur</label>
                                <input type="text" class="form-control" name="nama_cagub" value="<?= $row['nama_cagub'] ?>" required="required">
                            </div>
                            <div class="form-group">
                            <label>Jenis Kelamin Cagub</label>
                            <select name="jkcalon" class="form-control" required="required">
                                <option value="">--Pilih Jenis Kelamin--</option>
                                <!-- <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option> -->
                                <option value="Laki-Laki" <?php if($row['jkcalon'] == 'Laki-Laki'){echo "selected";} ?> >Laki-Laki</option>
                                <option value="Perempuan" <?php if($row['jkcalon'] == 'Perempuan'){echo "selected";} ?> >Perempuan</option>
                            </select>
                            </div>
                            <div class="form-group">
                                <label>Nama Calon Wakil Gubernur</label>
                                <input type="text" class="form-control" name="nama_cawagub" value="<?= $row['nama_cawagub'] ?>" required="required">
                            </div>
                            <div class="form-group">
                            <label>Jenis Kelamin Cawagub</label>
                            <select name="jkwakil" class="form-control" required="required">
                                <option value="">--Pilih Jenis Kelamin--</option>
                                <option value="Laki-Laki" <?php if($row['jkwakil'] == 'Laki-Laki'){echo "selected";} ?> >Laki-Laki</option>
                                <option value="Perempuan" <?php if($row['jkwakil'] == 'Perempuan'){echo "selected";} ?> >Perempuan</option>
                            </select>
                            </div>
                            <div class="form-group">
                                <label>Partai Pengusung</label>
                                <!-- <input type="text" class="form-control" name="partai_pengusung" value="" required="required"> -->
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