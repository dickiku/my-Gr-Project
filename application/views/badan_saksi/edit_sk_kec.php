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
              <li class="breadcrumb-item active">Edit Data</li>
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
                        <form method="post" action="<?= base_url('badan_saksi/prosesEditSk/'.'3') ?>" enctype="multipart/form-data">
                            <?php foreach($data as $row): ?>
                            <input type="hidden" name="id_data" value="<?= $row['id_badan_saksi_sk'] ?>">
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <input type="hidden" name="temp" class="form-control" value="<?= $row['id_kec'] ?>">
                                <input type="text" name="" class="form-control" value="<?= $row['nm_kec'] ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>No. SK</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="no_sk" class="form-control" value="<?= $row['no_sk'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Tanggal SK</label><label class="text-danger text-lg">*</label>
                                <input type="date" name="tanggal_sk" class="form-control" value="<?= $row['tanggal'] ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Scan SK</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="" value="File tertera : <?= $row['scan_sk'] ?>" class="form-control" disabled>
                                <input type="hidden" name="file_lama" value="<?= $row['scan_sk'] ?>" class="form-control">
                                <input type="file" name="file_pendukung" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-warning">Edit</button>
                            <?php endforeach; ?>
                       </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>