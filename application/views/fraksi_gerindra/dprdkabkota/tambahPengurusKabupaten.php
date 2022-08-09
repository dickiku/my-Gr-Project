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
                    <div class="card-body">
                        <form method="post" action="<?= base_url('fraksi_gerindra/tambahPengurus_proses_kabupaten') ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Kabupaten/Kota</label>
                                <?php foreach($wilayahKab as $wk) : ?>
                                <input type="hidden" name="id_kab" class="form-control" value="<?= $wk['id_kab']?>">
                                <input type="text" class="form-control" value="<?= $wk['nm_kab'] ?>" disabled>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label>Nama Fraksi</label>
                                <input type="text" name="nama_fraksi" class="form-control" value="<?= set_value('nama_fraksi')?>">
                                <?php echo form_error('nama_fraksi'); ?>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" name="alamat" class="form-control" value="<?= set_value('alamat')?>">
                                <?php echo form_error('alamat'); ?>
                            </div>
                            <div class="form-group">
                                <label>Tenaga Ahli</label>
                                <input type="text" name="tenaga_ahli" class="form-control" value="<?= set_value('tenaga_ahli')?>">
                                <?php echo form_error('tenaga_ahli'); ?>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                       </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>