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
              <li class="breadcrumb-item active">Detail Daftar Pemilih</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
            <?= $this->session->flashdata('pesan') ?>
                <div class="card mb-3 mx-auto">
                    <div class="card-body">
                        <table class="table table-bordered table-striped table-hover" id="myTable">
                            <tbody>
                                <?php foreach($data as $row) : ?>
                                <tr>
                                    <td><strong>Desa</strong></td>
                                    <?php foreach($desa as $des): ?>
                                    <td><?= $des['nm_desa'] ?></td>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>
                                    <td><strong>TPS</strong></td>
                                    <td><?= $row['nama_tps']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Laki - Laki</strong></td>
                                    <td><?= $row['laki']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Jumlah Perempuan</strong></td>
                                    <td><?= $row['perempuan']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Total Daftar Pemilih</strong></td>
                                    <?php $jum = $row['laki'] + $row['perempuan'] ?>
                                    <td><?= $jum?></td>
                                </tr>
                                <tr>
                                    <td><strong>Tahun</strong></td>
                                    <td><?= $row['tahun']?></td>
                                </tr>
                                <tr>
                                    <td><strong>Asesor</strong></td>
                                    <td><?= $row['nama']?></td>
                                </tr>
                                <tr>
                                    <td><strong>File</strong></td>
                                    <td><?= $row['file']?>
        								<a href="<?php echo base_url()."download/file/".$row['file'];?>">
        									<i class="fa fa-download" aria-hidden="true"></i>
        								</a>
							        </td>
                                </tr>
                                <tr>
                                    <td><strong>Keterangan</strong></td>
                                    <td><?= $row['ket']?></td>
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