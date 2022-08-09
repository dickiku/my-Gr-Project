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
                        <form method="post" action="<?= base_url('perolehan_kursi/editPerolehanKursi_proses/'.$row['id_perolehan_kursi']) ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Nama Partai</label>
                                <input type="text" name="nama_partai" class="form-control" value="<?= $row['nama_partai'] ?>">
                                <?php echo form_error('nama_partai'); ?>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Kursi</label>
                                <input type="text" name="jumlah_kursi" class="form-control" value="<?= $row['jumlah_kursi'] ?>">
                                <?php echo form_error('jumlah_kursi'); ?>
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