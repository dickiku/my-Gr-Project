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
              <li class="breadcrumb-item active">Edit Kepengurusan Fraksi</li>
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
                        <form method="post" action="<?= base_url('fraksi_gerindra/editKepengurusan_proses_ri/'.$row['id_pengurus_fraksi_gerindra']) ?>" enctype="multipart/form-data">
                            <!-- <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?= $row['nama'] ?>">
                                <?php echo form_error('nama'); ?>
                            </div> -->
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="hidden" name="id_keanggotaan" value="<?= $row['id_keanggotaan']?> ">
                                <input type="text" name="keanggotaan" class="form-control" value="<?= $row['nama']?>" disabled>
                                <?php echo form_error('keanggotaan'); ?>
                            </div>
                            <div class="form-group">
                                <label>Jabatan Fraksi</label>
                                <select name="id_jabatan_fraksi" class="form-control">
                                    <option value="">--Pilih Jabatan Fraksi--</option>
                                <?php foreach($jabatan_fraksi as $jf) : ?>
                                    <?php if($jf['id_jabatan_fraksi'] == $row['id_jabatan_fraksi']) : ?>
                                        <option value="<?= $row['id_jabatan_fraksi'] ?>" selected><?= $row['nama_jabatan_fraksi'] ?></option>
                                    <?php else : ?>
                                        <option value="<?= $jf['id_jabatan_fraksi'] ?>"><?= $jf['nama_jabatan_fraksi'] ?></option>
                                    <?php endif; ?>
                                    
                                <?php endforeach; ?>
                                </select>
                                <?php echo form_error('id_jabatan_fraksi'); ?>
                            </div>
                            <div class="form-group">
                                <label>Jabatan AKD</label>
                                <select name="id_jabatan_3" class="form-control">
                                    <option value="">--Pilih Jabatan--</option>
                                <?php foreach($jabatan as $j) : ?>
                                    <?php if($j['id_jabatan_3'] == $row['id_jabatan_3']) : ?>
                                        <option value="<?= $row['id_jabatan_3'] ?>" selected><?= $row['nama_jabatan_3'] ?></option>
                                    <?php else : ?>
                                        <option value="<?= $j['id_jabatan_3'] ?>"><?= $j['nama_jabatan_3'] ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </select>
                                <?php echo form_error('id_jabatan_3'); ?>
                            </div>
                            <div class="form-group">
                                <label>Jabatan AKD Lain Lama</label>
                                <select name="id_jabatan_lama" class="form-control">
                                    <option value="">--Pilih Jabatan Lama--</option>
                                <?php foreach($jabatan_lama as $jl) : ?>
                                    <?php if($jl['id_jabatan_lama'] == $row['id_jabatan_lama']) : ?>
                                        <option value="<?= $row['id_jabatan_lama'] ?>" selected><?= $row['nama_jabatan_lama'] ?></option>
                                    <?php else : ?>
                                        <option value="<?= $jl['id_jabatan_lama'] ?>"><?= $jl['nama_jabatan_lama'] ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                </select>
                                <?php echo form_error('id_jabatan_lama'); ?>
                            </div>
                            <div class="form-group">
                                <label>Perolehan Suara</label>
                                <input type="text" name="perolehan_suara" class="form-control" value="<?= $row['perolehan_suara']?> ">
                                <?php echo form_error('perolehan_suara') ?>
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