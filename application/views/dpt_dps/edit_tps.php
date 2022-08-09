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
              <li class="breadcrumb-item active">Edit Data DPS</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
            <?= $this->session->flashdata('pesan'); ?>
                <div class="card mb-3 mx-auto">
                    <hr>
                    <div class="card-body">
                        <form method="post" action="<?= base_url('dpt_dps/prosesEditTps/') ?>" enctype="multipart/form-data">
                            <?php foreach($data as $dat) : ?>
                                <input type="hidden" name="id_tps" value="<?= $dat['id_tps']?>">
                                <div class="form-group">
                                    <label>Desa</label>
                                    <?php foreach($desa as $des) : ?>
                                    <input type="hidden" name="id_desa" value="<?= $des['id_desa']?>">
                                    <input type="text" value="<?= $des['nm_desa']?>" class="form-control" required="required" disabled>
                                    <?php endforeach; ?>
                                </div>
                                <div class="form-group">
                                    <label>Nama TPS</label>
                                    <input type="text" name="nama" value="<?= $dat['nama_tps']?>" class="form-control" required="required">
                                </div>
                            <?php endforeach; ?>
                            <button type="submit" class="btn btn-primary">Edit</button>
                       </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>