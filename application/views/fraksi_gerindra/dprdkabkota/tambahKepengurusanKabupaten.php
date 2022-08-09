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
                        <form method="post" action="<?= base_url('fraksi_gerindra/tambah_proses_kabupaten') ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Kabupaten/Kota</label>
                                <?php foreach($wilayahKab as $wk) : ?>
                                <input type="hidden" name="id_kab" class="form-control" value="<?= $wk['id_kab']?>">
                                <input type="text" class="form-control" value="<?= $wk['nm_kab'] ?>" disabled>
                                <?php endforeach; ?>
                            </div>
                            <!-- <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?= set_value('nama')?>">
                                <?php echo form_error('nama'); ?>
                            </div> -->
                            <div class="form-group">
                                <label>Nama</label>
                                <input list="keanggotaan" name="keanggotaan" class="form-control" required="required">
                                <datalist id="keanggotaan">
                                    <option value="">--Pilih Keanggotaan--</option>
                                    <?php foreach($keanggotaan as $kg) : ?>
                                        <option value="<?= $kg['id_keanggotaan'] ?>"> 
                                            <?= $kg['nama'] ?> | 
                                            <?= $kg['no_kta'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </datalist>
                                <?php echo form_error('keanggotaan'); ?>
                            </div>
                            <div class="form-group">
                                <label>Jabatan Fraksi</label>
                                <select name="id_jabatan_fraksi" class="form-control">
                                    <option value="">--Pilih Jabatan Fraksi--</option>
                                <?php foreach($jabatan_fraksi as $jf) : ?>
                                    <option value="<?= $jf['id_jabatan_fraksi'] ?>"><?= $jf['nama_jabatan_fraksi'] ?></option>
                                <?php endforeach; ?>
                                </select>
                                <?php echo form_error('id_jabatan_fraksi'); ?>
                            </div>
                            <div class="form-group">
                                <label>Jabatan AKD</label>
                                <select name="id_jabatan_3" class="form-control">
                                    <option value="">--Pilih Jabatan--</option>
                                <?php foreach($jabatan as $j) : ?>
                                    <option value="<?= $j['id_jabatan_3'] ?>"><?= $j['nama_jabatan_3'] ?></option>
                                <?php endforeach; ?>
                                </select>
                                <?php echo form_error('id_jabatan_3'); ?>
                            </div>
                            <div class="form-group">
                                <label>Jabatan AKD Lain</label>
                                <select name="id_jabatan_lama" class="form-control">
                                    <option value="">--Pilih Jabatan Lain--</option>
                                <?php foreach($jabatan_lama as $jl) : ?>
                                    <option value="<?= $jl['id_jabatan_lama'] ?>"><?= $jl['nama_jabatan_lama'] ?></option>
                                <?php endforeach; ?>
                                </select>
                                <?php echo form_error('id_jabatan_lama'); ?>
                            </div>
                            <div class="form-group">
                                <label>Perolehan Suara</label>
                                <input type="text" name="perolehan_suara" class="form-control">
                                <?php echo form_error('perolehan_suara') ?>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                       </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>