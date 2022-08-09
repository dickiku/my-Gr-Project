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
              <li class="breadcrumb-item active">Edit Periode Pilbup</li>
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
                        <form method="post" action="<?= base_url('cabup/prosesEditPeriode/') ?>" enctype="multipart/form-data">
                            <input type="hidden" name="id_tahun" value="<?= $row['id_tahun']?>">
                            <div>
                                <label>Kabupaten/Kota</label>
                                <input type="hidden" name="id_kab" value="<?= $row['id_kab'] ?>">
                                <input type="text" name="" value="<?= $row['nm_kab'] ?>" class="form-control" required="required" disabled>
                            </div>
                            <div class="form-group">
                                <label>Periode Pilgub</label>
                                <input type="text" name="tahun" value="<?= $row['tahun'] ?>" class="form-control" required="required">
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