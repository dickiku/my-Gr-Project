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
              <li class="breadcrumb-item active">Edit Data Anngota Dewan</li>
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
                        <form method="post" action="<?= base_url('anggota_dewan/prosesEditDPRDProv/') ?>" enctype="multipart/form-data">
                            <input type="hidden" name="temp" value="<?= $row['id_anggota_dewan']?>">
                            <div class="form-group">
                                <label>Periode</label>
                                <?php foreach($periode as $pr) : ?>
                                <input type="hidden" name="id_periode" value="<?= $pr->id_periode_pemilu ?>" class="form-control" required="required">
                                <input type="text" name="" value="<?= $pr->periode ?>" class="form-control" required="required" disabled>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="<?= $row['nama_dewan'] ?>" required="required">
                            </div>
                            <div class="form-group">
                                <label>Dapil</label>
                                <select class="form-control" name="dapil" required>
                                    <option value="">--Pilih Dapil--</option>
                                    <?php foreach($dapil as $dp) : ?>
                                        <?php if($dp['id_dapil_prov'] == $row['id_dapil']) : ?>
                                            <option value="<?= $row['id_dapil'] ?>" selected><?= $row['nama_dapil_prov']?></option>
                                        <?php else : ?>
                                            <option value="<?= $dp['id_dapil_prov'] ?>"><?= $dp['nama_dapil_prov']?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-control" required="required">
                                    <option value="">--Pilih Jenis Kelamin--</option>
                                    <option value="Laki-Laki" <?php if($row['jenis_kelamin'] == 'Laki-Laki'){echo "selected";} ?> >Laki-Laki</option>
                                    <option value="Perempuan" <?php if($row['jenis_kelamin'] == 'Perempuan'){echo "selected";} ?> >Perempuan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Partai</label>
                                <input type="text" name="partai" value="<?= $row['partai'] ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>No HP</label>
                                <input type="text" name="no_hp" value="<?= $row['no_hp_dewan'] ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <textarea name="alamat" id="alamat" cols="30" rows="3" class="form-control"><?= $row['alamat'] ?></textarea>
                            </div>
                            <div class="form-group">
                                <label>Perolehan Suara</label>
                                <input type="text" name="perolehan_suara" value="<?= $row['perolehan_suara'] ?>" class="form-control">
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