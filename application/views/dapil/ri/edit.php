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
              <li class="breadcrumb-item active">Edit Dapil RI</li>
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
                        <form method="post" action="<?= base_url('dapil/editRi_proses/') ?>" enctype="multipart/form-data">
                            <input type="hidden" name="id_dapil" value="<?= $row['id_dapil_ri']?>">
                            <div class="form-group">
                                <label>Nama Dapil</label>
                                <input type="text" name="nama" class="form-control" value="<?= $row['nama_dapil_ri']?>" required="required">
                            </div>
                            <div class="form-group">
                                <label>Wilayah</label>
                                <input type="text" name="wilayah" class="form-control" value="<?= $row['wilayah']?>" required="required">
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