<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1><?= $title ?></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?= $title ?></li>
              <li class="breadcrumb-item active">Kecamatan</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<div class="container ml-2 mb-2">
    <?= $this->session->flashdata('pesan') ?>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tabel Wilayah Kecamatan</h3>
                </div>
                <div class="card-body col-md-8 mx-auto">
                    <table id="example1" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10px;">#</th>
                                <th class="text-center" style="width: 10px;">Ketua</th>
                                <th class="text-center" style="width: 10px;">Sekretaris</th>
                                <th class="text-center" style="width: 10px;">Bendahara</th>
                                <th>Wilayah</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($data as $row ) : ?>
                            <tr>
                                <td><?= $no++ ?></td>

                                <?php $ketua = $this->Pac_model->getDataStrukturPac($row->id_kec,1); ?>
                                <?php if($ketua->num_rows() > 0) { ?>
                                    <td>
                                        <?php $kta = $ketua->result() ?>
                                        <?php foreach($ketua->result() as $kt) : ?>
                                           <?= $kt->nama ?>
                                           <?php 
                                                if($kt !== end($kta)){
                                                    echo ", ";
                                                }
                                           ?>
                                        <?php endforeach; ?>
                                    </td>
                                <?php } else { ?>
                                        <td> - </td>
                                <?php } ?>

                                <?php $sekretaris = $this->Pac_model->getDataStrukturPac($row->id_kec,3); ?>
                                <?php if($sekretaris->num_rows() > 0) { ?>
                                    <td>
                                        <?php $sk = $sekretaris->result() ?>
                                        <?php foreach($sekretaris->result() as $st) : ?>
                                            <?= $st->nama ?>
                                            <?php
                                                if($st !== end($sk)){
                                                    echo ", ";
                                                }
                                            ?>
                                        <?php endforeach; ?>
                                    </td>
                                <?php } else { ?>
                                        <td> - </td>
                                <?php } ?>

                                <?php $bendahara = $this->Pac_model->getDataStrukturPac($row->id_kec,5); ?>
                                <?php if($bendahara->num_rows() > 0) { ?>
                                    <td>
                                        <?php $bdh = $bendahara->result(); ?>
                                        <?php foreach($bendahara->result() as $b) : ?>
                                            <?= $b->nama ?>
                                            <?php 
                                                if($b !== end($bdh)){
                                                    echo ", ";
                                                }
                                            ?>
                                        <?php endforeach; ?>
                                    </td>
                                <?php } else { ?>
                                        <td> - </td>
                                <?php } ?>

                                <td><?= $row->nm_kec ?></td>
                                <td>
                                    <a href="<?= base_url('pac/detailPacKec/'). $row->id_kec ?>" class="btn btn-primary btn-md">
                                        Tab
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>