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
              <li class="breadcrumb-item active">Tambah Data</li>
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
                        <form method="post" action="<?= base_url('badan_saksi/prosesTambahSk/'.'4') ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Desa</label>
                                <?php foreach($desa as $des): ?>
                                    <input type="hidden" name="temp" class="form-control" value="<?= $des['id_desa'] ?>">
                                    <input type="text" name="" class="form-control" value="<?= $des['nm_desa'] ?>" disabled>
                                <?php endforeach ?>
                            </div>
                            <div class="form-group">
                                <label>No. SK</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="no_sk" class="form-control" value="" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal SK</label><label class="text-danger text-lg">*</label>
                                <input type="date" name="tanggal_sk" class="form-control" value="" required>
                            </div>
                            <div class="form-group">
                                <label>Scan SK</label><label class="text-danger text-lg">*</label>
                                <input type="file" name="file_pendukung" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                       </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>