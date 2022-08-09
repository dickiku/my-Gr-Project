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
              <li class="breadcrumb-item active">Tambah Data DPS</li>
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
                        <form method="post" action="<?= base_url('dpt_dps/tambahDPS') ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Desa</label>
                                <?php foreach($desa as $des) : ?>
                                <input type="hidden" name="id_desa" value="<?= $des['id_desa']?>" class="form-control" required="required">
                                <input type="text" name="" value="<?= $des['nm_desa']?>" class="form-control" required="required" disabled>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label>TPS</label>
                                <?php foreach($tps as $t) : ?>
                                <input type="hidden" name="id_tps" value="<?= $t['id_tps']?>" class="form-control" required="required">
                                <input type="text" name="" value="<?= $t['nama_tps']?>" class="form-control" required="required" disabled>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label>Tahun</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="tahun" value="" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Jumlah Laki - Laki</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="laki" value="" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Jumlah Perempuan</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="perempuan" value="" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>File Pendukung</label><label class="text-danger text-lg">*</label>
                                <input type="file" name="file_pendukung" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Nama Asesor</label><label class="text-danger text-lg">*</label>
                                <input list="keanggotaan" name="keanggotaan" class="form-control" required="required">
                                <datalist id="keanggotaan">
                                    <option value="">--Pilih Keanggotaan--</option>
                                    <?php if($user['id_kab']) { ?>
                                        <?php foreach($keanggotaanKab as $kgk) : ?>
                                            <option value="<?= $kgk['id_keanggotaan'] ?>"> 
                                                <?= $kgk['nama'] ?> | 
                                                <?= $kgk['no_kta'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php } else { ?>
                                        <?php foreach($keanggotaan as $kg) : ?>
                                            <option value="<?= $kg['id_keanggotaan'] ?>"> 
                                                <?= $kg['nama'] ?> | 
                                                <?= $kg['no_kta'] ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php } ?>
                                </datalist>
                            </div>
                            <div class="form-group">
                                <label>Keterangan (optional)</label>
                                <input type="text" name="ket" value="" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                       </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>