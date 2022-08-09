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
              <li class="breadcrumb-item active">Edit Data Pemilih</li>
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
                        <form method="post" action="<?= base_url('pilkada/pilbup_editDptDesa_proses/') ?>" enctype="multipart/form-data">
                            <input type="hidden" name="id_data" value="<?= $row['id_jumlah_pemilih_pilkada']?>">
                            <div class="form-group">
                                <label>Periode</label>
                                <?php foreach($tahun as $p) : ?>
                                <input type="hidden" class="form-control" name="id_tahun" value="<?= $p['id_tahun'] ?>">
                                <input type="text" class="form-control" value="<?= $p['tahun'] ?>" disabled>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label>Desa</label>
                                <input type="hidden" name="id_desa" class="form-control" value="<?= $row['id_desa'] ?>">
                                <input type="text" class="form-control" value="<?= $row['nm_desa'] ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>DPT</label>
                                <input type="text" class="form-control" name="dpt" value="<?= $row['dpt'] ?>" required="required">
                            </div>
                            <div class="form-group">
                                <label>Pengguna Hak Pilih</label>
                                <input type="text" class="form-control" name="pengguna_hak_pilih" value="<?= $row['pengguna_hak_pilih'] ?>" required="required">
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