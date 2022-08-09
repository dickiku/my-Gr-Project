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
              <li class="breadcrumb-item active">Tambah Admin</li>
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
                        <form method="post" action="<?= base_url('admin/manajemen_admin/tambah_admin_proses') ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Kabupaten/Kota</label>
                                <select name="dpc_kab_kota" class="form-control">
                                        <option value="">--Pilih Wilayah--</option>
                                        <?php foreach($wilayahKab as $row) : ?>
                                        <option value="<?= $row->id_kab ?>"><?= $row->nm_kab ?></option>
                                        <?php endforeach; ?>
                                </select>
                                <?php echo form_error('dpc_kab_kota'); ?>
                            </div>
                            <div class="form-group">
                                <label>NIK</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="nik" class="form-control" value="<?= set_value('nik')?>">
                                <?php echo form_error('nik'); ?>
                            </div>
                            <div class="form-group">
                                <label>Nama</label><label class="text-danger text-lg">*</label>
                                <input type="text" name="nama" class="form-control" value="<?= set_value('nama')?>">
                                <?php echo form_error('nama'); ?>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label><label class="text-danger text-lg">*</label>
                                <select name="jenis_kelamin" class="form-control">
                                    <option value="">--Pilih Jenis Kelamin--</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                <?php echo form_error('jenis_kelamin'); ?>
                            </div>
                            <div class="form-group">
                                <label>Level Admin</label><label class="text-danger text-lg">*</label>
                                <select name="level" class="form-control">
                                    <option value="">--Pilih Level Admin--</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Super Admin">Super Admin</option>
                                </select>
                                <?php echo form_error('level'); ?>
                            </div>
                            <div class="form-group">
                                <label>Password</label><label class="text-danger text-lg">*</label>
                                <input type="password" name="password1" class="form-control">
                                <?php echo form_error('password1'); ?>
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password</label><label class="text-danger text-lg">*</label>
                                <input type="password" name="password2" class="form-control">
                                <?php echo form_error('password2'); ?>
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                       </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>