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
                        <form method="post" action="<?= base_url('anggota_dewan/prosesEditDPRDKab/') ?>" enctype="multipart/form-data">
                            <input type="hidden" name="temp" value="<?= $row['id_anggota_dewan']?>">
                            <div class="form-group">
                                <label>Kabupaten</label>
                                <?php foreach($kabupaten as $kab) : ?>
                                <input type="hidden" name="id_kab" value="<?= $kab->id_kab ?>" class="form-control" required="required">
                                <input type="text" name="" value="<?= $kab->nm_kab ?>" class="form-control" required="required" disabled>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label>Periode</label>
                                <?php foreach($periode as $pr) : ?>
                                <input type="hidden" name="id_periode" value="<?= $pr->id_periode_pemilu ?>" class="form-control" required="required">
                                <input type="text" name="" value="<?= $pr->periode ?>" class="form-control" required="required" disabled>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="hidden" name="id_keanggotaan" value="<?= $row['id_keanggotaan']?> ">
                                <input type="text" name="keanggotaan" class="form-control" value="<?= $row['nama']?>" disabled>
                            </div>
                            <div class="form-group">
                                <label>Dapil</label>
                                <select class="form-control" name="dapil" required>
                                    <option value="">--Pilih Dapil--</option>
                                    <?php foreach($dapil as $dp) : ?>
                                        <?php if($dp['id_dapil_kab'] == $row['id_dapil']) : ?>
                                            <option value="<?= $row['id_dapil'] ?>" selected><?= $row['nama_dapil_kab']?></option>
                                        <?php else : ?>
                                            <option value="<?= $dp['id_dapil_kab'] ?>"><?= $dp['nama_dapil_kab']?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Komisi</label>
                                <input type="text" name="komisi" value="<?= $row['komisi']?>" class="form-control" required="required">
                            </div>
                            <div class="form-group">
                                <label>Jabatan</label>
                                <select class="form-control" name="jabatan" required>
                                    <option value="">--Pilih Jabatan--</option>
                                    <?php foreach($jabatan as $jb) : ?>
                                        <?php if($jb['id_jabatan_3'] == $row['jabatan']) : ?>
                                            <option value="<?= $row['id_jabatan_3'] ?>" selected><?= $row['nama_jabatan_3']?></option>
                                        <?php else : ?>
                                            <option value="<?= $jb['id_jabatan_3'] ?>"><?= $jb['nama_jabatan_3']?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
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