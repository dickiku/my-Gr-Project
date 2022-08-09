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
                        <form method="post" action="<?= base_url('pac/edit_proses/'.$row['id_pac']) ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Nama Kab/Kota</label>
                                <input type="text" class="form-control" value="<?= $row['nm_kab']?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>Nama PAC</label>
                                <input type="text" class="form-control" value="<?= $row['nm_kec']?>" disabled>
                            </div>
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
                                <label>No. SK</label>
                                <input type="text" name="no_sk" class="form-control" value="<?= $row['no_sk']?>" >
                                <?php echo form_error('no_sk'); ?>
                            </div>
                            <div class="form-group">
                                <label>Tanggal SK</label>
                                <input type="date" name="tanggal_sk" class="form-control" value="<?= $row['tanggal_sk']?>">
                            </div>
                            <div class="form-group">
                                <label>Admin</label>
                                <input type="text" name="admin" class="form-control" value="<?= $row['admin']?>">
                            </div>
                            <div class="form-group">
                                <label>Link Facebook</label>
                                <input type="text" name="link_facebook" class="form-control" value="<?= $row['link_facebook']?>" >
                            </div>
                            <div class="form-group">
                                <label>Link Instagram</label>
                                <input type="text" name="link_instagram" class="form-control" value="<?= $row['link_instagram']?>" >
                            </div>
                            <div class="form-group">
                                <label>Link Tiktok</label>
                                <input type="text" name="link_tiktok" class="form-control" value="<?= $row['link_tiktok']?>" >
                            </div>
                            <div class="form-group">
                                <label>Ubah Foto Kantor</label>
                                <input type="file" name="foto_kantor" class="form-control">
                                <input type="hidden" name="foto_kantor_lama" class="form-control" value="<?= $row['foto_kantor']?>">
                            </div>
                            <div class="form-group">
                                <label>Ubah Foto Kantor 1</label>
                                <input type="file" name="foto_kantor_1" class="form-control">
                                <input type="hidden" name="foto_kantor_lama_1" class="form-control" value="<?= $row['foto_kantor_1']?>">
                            </div>
                            <div class="form-group">
                                <label>Ubah Foto Kantor 2</label>
                                <input type="file" name="foto_kantor_2" class="form-control">
                                <input type="hidden" name="foto_kantor_lama_2" class="form-control" value="<?= $row['foto_kantor_2']?>">
                            </div>
                            <div class="form-group">
                                <label>Ubah File Scan SK</label>
                                <input type="file" name="scan_sk" class="form-control">
                                <input type="hidden" name="scan_sk_lama" class="form-control" value="<?= $row['scan_sk']?>">
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