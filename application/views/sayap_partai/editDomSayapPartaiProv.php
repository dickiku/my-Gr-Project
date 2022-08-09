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
              <li class="breadcrumb-item active">Edit</li>
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
                        <form method="post" action="<?= base_url('sayap_partai/editDomSayapPartaiProv_proses/'.$row['id_dom_sayap_partai']) ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" name="alamat" class="form-control" value="<?= $row['alamat']?>" >
                                <?php echo form_error('alamat'); ?>
                            </div>
                            <div class="form-group">
                                <label>No. Telp</label>
                                <input type="text" name="no_telp" class="form-control" value="<?= $row['no_telp']?>" >
                                <?php echo form_error('no_telp'); ?>
                            </div>
                            <div class="form-group">
                                <label>Ubah Scan SK</label>
                                <input type="file" name="scan_sk" class="form-control">
                                <input type="hidden" name="scan_lama" class="form-control" value="<?= $row['scan_sk']?>">
                            </div>
                            <div class="form-group">
                                <label>Ubah Foto Kantor</label>
                                <input type="file" name="foto_kantor" class="form-control">
                                <input type="hidden" name="foto_lama" class="form-control" value="<?= $row['foto_kantor']?>">
                            </div>
                            <button type="submit" class="btn btn-primary">Ubah Data</button>
                       </form>
                       <?php endforeach; ?>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>