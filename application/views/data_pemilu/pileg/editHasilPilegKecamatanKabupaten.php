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
                        <form method="post" action="<?= base_url('pileg/editHasilPilegKecamatanKab_proses/'.$row['id_hasil_pileg']) ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Bagian</label>
                                <input type="text" class="form-control" value="DPR-Kabupaten/Kota" disabled>
                            </div>
                            <div class="form-group">
                                <label>Periode</label>
                                <input type="text" class="form-control" value="<?= $row['periode']?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>Kabupaten/Kota</label>
                                <?php foreach($wilayahKab as $wk) : ?>
                                <input type="text" class="form-control" value="<?= $wk['nm_kab']?>" disabled>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <?php foreach($wilayahKec as $wkc) : ?>
                                <input type="text" class="form-control" value="<?= $wkc['nm_kec']?>" disabled>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label>Partai</label>
                                <select name="partai" class="form-control" disabled>
                                    <option value="">--Pilih Partai--</option>
                                    <?php $no=1; foreach($partai as $p) : ?>
                                        <?php if($p['id_partai'] == $row['id_partai']) : ?>
                                            <option value="<?= $row['id_partai'] ?>" selected><?= $row['nama_partai']?></option>
                                        <?php else : ?>
                                            <option value="<?= $p['id_partai'] ?>"><?= $p['nama_partai'] ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <?php echo form_error('partai'); ?>
                            </div>
                            <div class="form-group">
                                <label>Perolehan Suara</label>
                                <input type="text" class="form-control" name="perolehan" value="<?= $row['perolehan'] ?>">
                                <?php echo form_error('perolehan'); ?>
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