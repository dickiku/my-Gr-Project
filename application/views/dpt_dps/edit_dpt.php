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
              <li class="breadcrumb-item active">Edit Data DPT</li>
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
                    <hr>
                    <div class="card-body">
                        <form method="post" action="<?= base_url('dpt_dps/prosesEdit/'.'1') ?>" enctype="multipart/form-data">
                            <?php foreach($data as $dat) : ?>
                            <input type="hidden" name="id_data" value="<?= $dat['id_dpt']?>">
                            <div class="form-group">
                                <label>Desa</label>
                                <?php foreach($desa as $des) : ?>
                                <input type="hidden" name="id_desa" value="<?= $des['id_desa']?>" class="form-control" required="required">
                                <input type="text" name="" value="<?= $des['nm_desa']?>" class="form-control" required="required" disabled>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label>TPS</label>
                                <input type="hidden" name="id_tps" value="<?= $dat['id_tps']?>" class="form-control" required="required">
                                <input type="text" name="" value="<?= $dat['nama_tps']?>" class="form-control" required="required" disabled>
                            </div>
                            <div class="form-group">
                                <label>Nama Asesor</label>
                                <input type="hidden" name="keanggotaan" value="<?= $dat['id_keanggotaan']?>" class="form-control" required="required">
                                <input type="text" name="" value="<?= $dat['nama']?>" class="form-control" required="required" disabled>
                            </div>
                            <div class="form-group">
                                <label>Tahun</label>
                                <input type="text" name="tahun" value="<?= $dat['tahun']?>" class="form-control" required="required">
                                <?php echo form_error('tahun'); ?>
                            </div>
                            <div class="form-group">
                                <label>Jumlah Laki - Laki</label>
                                <input type="text" name="laki" value="<?= $dat['laki']?>" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Jumlah Perempuan</label>
                                <input type="text" name="perempuan" value="<?= $dat['perempuan']?>" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>File Pendukung</label>
                                <input type="hidden" name="file_lama" value="<?= $dat['file']?>" class="form-control">
                                <input type="text" name="" value="File Tertera : <?= $dat['file']?>" class="form-control" disabled>
                                <input type="file" name="file_pendukung" value="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Keterangan (optional)</label>
                                <input type="text" name="ket" value="<?= $dat['ket']?>" class="form-control">
                            </div>
                            </div>
                            <?php endforeach; ?>
                            <button type="submit" class="btn btn-primary">Edit</button>
                       </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>