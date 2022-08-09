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
              <li class="breadcrumb-item active">Detail DPD</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3 mx-auto">
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover" id="myTable">
                            <tbody>
                                <?php foreach($data as $row) : ?>
                                <tr>
                                    <td><strong>DPD Kab/Kota</strong></td>
                                    <td>DPD Prov Jateng</td>
                                </tr>
                                <tr>
                                    <td><strong>Alamat</strong></td>
                                    <td><?= $row['alamat']?></td>
                                </tr>
                                <tr>
                                    <td><strong>No. Telp</strong></td>
                                    <td><?= $row['no_telp']?></td>
                                </tr>
                                <tr>
                                    <td><strong>No. SK</strong></td>
                                    <td><?= $row['no_sk']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Tanggal SK</strong></td>
                                    <td><?= $row['tanggal_sk']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Admin</strong></td>
                                    <td><?= $row['admin']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Sosial Media</strong></td>
                                    <td>
                                        <a href="<?= $row['link_facebook']?>">Facebook</a>
                                        <a href="<?= $row['link_instagram']?>">Instagram</a>
                                        <a href="<?= $row['link_tiktok']?>">Tiktok</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Scan SK</strong></td>
                                    <td><?= $row['scan_sk']?>
        								<a href="<?php echo base_url()."download/file/".$row['scan_sk'];?>">
        									<i class="fa fa-download" aria-hidden="true"></i>
        								</a>
							        </td>
                                </tr>
                                <tr>
                                    <td><strong>Foto Kantor</strong></td>
                                    <td>
                                        <img id="myImg" src="<?= base_url('uploads/').$row['foto_kantor'] ?>" class="card-img-top card-img img-thumbnail mt-2" style="max-width: 140px;">    
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        
                    </div> 
                </div>
            </div>
        </div>
    </div>
</section>
