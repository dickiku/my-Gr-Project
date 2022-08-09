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
              <li class="breadcrumb-item active">Edit Hasil Pilkada</li>
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
                        <form method="post" action="<?= base_url('pilkada/pilgub_ProsesEditHasilPilkadaKabupaten/') ?>" enctype="multipart/form-data">
                            <input type="hidden" name="id_data" value="<?= $row['id_hasil_pilgub']?>">
                            <div class="form-group">
                                <label>Periode</label>
                                <input type="hidden" class="form-control" name="id_tahun" value="<?= $row['id_tahun'] ?>">
                                <input type="text" class="form-control" value="<?= $row['tahun'] ?>" disabled>
                            </div>
                            <div class="form-group">
                                <?php foreach($wilayahKab as $wk) : ?>
                                <label>Kabupaten/Kota</label>
                                <input type="hidden" name="id_kab" class="form-control" value="<?= $wk['id_kab'] ?>">
                                <input type="text" class="form-control" value="<?= $wk['nm_kab'] ?>" disabled>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label>Calon Gubernur</label>
                                <input type="hidden" class="form-control" name="cagub" value="<?= $row['id_cagub'] ?>">
                                <input type="text" class="form-control" name="" value="<?= $row['nama_cagub'] ?>" required="required" disabled>
                            </div>
                            <div class="form-group">
                                <label>Calon Wakil Gubernur</label>
                                <input type="text" class="form-control" name="" value="<?= $row['nama_cawagub'] ?>" required="required" disabled>
                            </div>
                            <div class="form-group">
                                <label>Perolehan</label>
                                <input type="text" class="form-control" name="perolehan" value="<?= $row['perolehan'] ?>" required="required">
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