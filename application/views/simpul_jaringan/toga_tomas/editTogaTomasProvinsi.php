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
              <li class="breadcrumb-item active">Edit Toga Tomas</li>
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
                        <form method="post" action="<?= base_url('simpul_jaringan/editTogaTomas_proses_provinsi/'.$row['id_toga_tomas']) ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?= $row['nama']?>">
                                <?php echo form_error('nama'); ?>
                            </div>
                            <div class="form-group">
                                <label>Latar Belakang</label>
                                <input type="text" name="ltr_belakang" class="form-control" value="<?= $row['ltr_belakang']?>">
                                <?php echo form_error('ltr_belakang'); ?>
                            </div>
                            <div class="form-group">
                                <label>No Telepon</label>
                                <input type="text" name="no_telp" class="form-control" value="<?= $row['no_telp']?>">
                                <?php echo form_error('no_telp'); ?>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" name="alamat" class="form-control" value="<?= $row['alamat']?>">
                                <?php echo form_error('alamat'); ?>
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