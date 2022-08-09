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
              <li class="breadcrumb-item active">Edit Kepengurusan</li>
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
                        <form method="post" action="<?= base_url('badan_saksi/editPengurus_proses/'.$row['id_badan_saksi_desa'].'/'.'2') ?>" enctype="multipart/form-data">
                            <input type="hidden" name="temp" value="<?= $row['id_desa']?>">
                            <div class="form-group">
                                <label>Kolom</label>
                                <input type="text" name="kolom" value="<?= $row['kolom']?>" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Desa</label>
                                <?php foreach($desa as $des) : ?>
                                <input type="hidden" name="id_desa" value="<?= $des['id_desa']?>" required="required">
                                <select class="form-control" disabled>
                                    <option value="<?= $des['id_desa']?>"><?= $des['nm_desa']?></option>
                                </select>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="hidden" name="id_keanggotaan" value="<?= $row['id_keanggotaan']?> ">
                                <input type="text" name="keanggotaan" class="form-control" value="<?= $row['nama']?>" disabled>
                                <?php echo form_error('keanggotaan'); ?>
                            </div>
                            <div class="form-group">
                                <label>Jabatan</label>
                                <input type="text" name="jabatan" value="<?= $row['jabatan']?>" class="form-control" required>
                                <!-- <select name="jabatan" class="form-control">
                                    <option value="">--Pilih Jabatan--</option>
                                    <?php foreach($jabatan as $jb) : ?>
                                        <?php if($jb['id_jabatan_bs'] == $row['id_jabatan_bs']) : ?>
                                            <option value="<?= $row['id_jabatan_bs'] ?>" selected><?= $row['nama_jabatan']?></option>
                                        <?php else : ?>
                                            <option value="<?= $jb['id_jabatan_bs'] ?>"><?= $jb['nama_jabatan']?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <?php echo form_error('jabatan'); ?> -->
                            </div>
                            <div class="form-group">
                                <label>TPS</label>
                                <input type="text" name="tps" class="form-control" value="<?= $row['tps']?>" required="required">
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