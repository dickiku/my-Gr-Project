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
                        <form method="post" action="<?= base_url('pilpres/edit_pengguna_hak_pilih_kecamatan_proses/'.$row['id_jumlah_pemilih']) ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Periode</label>
                                <?php foreach($periode as $p) : ?>
                                <input type="text" class="form-control" value="<?= $p['periode'] ?>" disabled>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label>Kabupaten/Kota</label>
                                <?php foreach($wilayahKab as $wk) : ?>
                                <input type="text" class="form-control" value="<?= $wk['nm_kab'] ?>" disabled>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <?php foreach($wilayahKec as $wkc) : ?>
                                <input type="text" class="form-control" value="<?= $wkc['nm_kec'] ?>" disabled>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label>DPT</label>
                                <input type="text" name="dpt" class="form-control" value="<?= $row['dpt']?>">
                            </div>
                            <div class="form-group">
                                <label>Pengguna Hak Pilih</label>
                                <input type="text" name="pengguna_hak_pilih" class="form-control" value="<?= $row['pengguna_hak_pilih']?>">
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