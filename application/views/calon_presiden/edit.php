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
                        <form method="post" action="<?= base_url('calon_presiden/edit_proses/'.$row['id_capres']) ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Periode</label>
                                <?php foreach($periode as $p) : ?>
                                    <input type="text" class="form-control" value="<?= $p['periode']?>" disabled>
                                <?php endforeach; ?>
                            </div>
                            <div class="form-group">
                                <label>Nama Presiden</label>
                                <input type="text" name="nama_capres" class="form-control" value="<?= $row['nama_capres']?>">
                                <?php echo form_error('nama_capres'); ?>
                            </div>
                            <div class="form-group">
                                <label>Nama Wakil Presiden</label>
                                <input type="text" name="nama_wapres" class="form-control" value="<?= $row['nama_wapres']?>">
                                <?php echo form_error('nama_wapres'); ?>
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