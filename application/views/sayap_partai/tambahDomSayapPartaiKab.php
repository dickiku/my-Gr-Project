<?php 
    $user = $this->session->userdata('userdata');
?>
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
            <?= $this->session->flashdata('pesan'); ?>
                <div class="card mb-3 mx-auto">
                    <!-- <img src="<?= base_url('uploads/').$keanggotaan['foto_profil'] ?>" class="card-img-top card-img img-circle img-thumbnail mx-auto mt-2" style="max-width: 140px;"> -->
                    <hr>
                    <div class="card-body">
                        <form method="post" action="<?= base_url('sayap_partai/tambahDomSayapPartaiKab_proses') ?>" enctype="multipart/form-data">
                            <?php foreach($wilayah as $w) : ?>
                            <div class="form-group">
                                <label>Wilayah</label>
                                <input type="hidden" class="form-control" name="id_kab" value="<?= $w['id_kab']?>" readonly>
                                <input type="text" class="form-control" value="Sayap Partai <?= $w['nm_kab']?>" disabled>
                            </div>
                            <?php endforeach; ?>
                            <?php foreach($sayap as $row) : ?>
                            <div class="form-group">
                                <label>Nama Sayap Partai</label>
                                <input type="hidden" class="form-control" name="id_sayap_partai" value="<?= $row['id_sayap_partai']?>" readonly>
                                <input type="text" class="form-control" value="<?= $row['nama_sayap_partai'] ?>" disabled>
                            </div>
                            <?php endforeach; ?>
                            <div class="form-group">
                                <label>Alamat</label><label class="text-danger text-lg">*</label>
                                <textarea name="alamat" class="form-control" cols="3" rows="3"></textarea>
                                <?php echo form_error('alamat'); ?>
                            </div>
                            <div class="form-group">
                                <label>No. Telp</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="no_telp" class="form-control" value="<?= set_value('no_telp')?>">
                                <?php echo form_error('no_telp'); ?>
                            </div>
                            <div class="form-group">
                                <label>Scan SK</label><label class="text-danger text-lg">*</label>
                                <input type="file" name="scan_sk" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Foto Kantor</label><label class="text-danger text-lg">*</label>
                                <input type="file" name="foto_kantor" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                       </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>