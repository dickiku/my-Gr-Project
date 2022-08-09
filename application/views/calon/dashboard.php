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
              <li class="breadcrumb-item active">Detail</li>
            </ol>
          </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<div class="container">
    <?= $this->session->flashdata('pesan'); ?>
    <br>
    <?php if($keanggotaan['status'] == 0) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>* Silahkan Lengkapi Semua Data Diri Anda, dan Tunggu Verifikasi dari Admin</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php else : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Akun Anda Sudah Diverifikasi!</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>
    <a href="<?= base_url('calon/dashboard/editCalon/'.$keanggotaan['id_keanggotaan']) ?> "class="btn btn-effect-ripple btn-warning ml-2 mb-2"><i class="fa fa-edit"></i> Lengkapi</a>
</div>
<section class="content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3 mx-auto">
                    <img src="<?= base_url('uploads/').$keanggotaan['foto_profil'] ?>" class="card-img-top card-img img-circle img-thumbnail mx-auto mt-2" style="max-width: 140px;">
                    <hr>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label>Kabupaten/Kota</label>
                                <input type="text" class="form-control" value="<?= $anggota['nm_kab']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Kecamatan</label>
                                <input type="text" class="form-control" value="<?= $anggota['nm_kec']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Desa/Kelurahan</label>
                                <input type="text" class="form-control" value="<?= $anggota['nm_desa']?>" readonly>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label>Nama</label>
                                    <input type="text" class="form-control" value="<?= $keanggotaan['nama']?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Tanggal Lahir</label>
                                <input type="date" class="form-control" value="<?= $keanggotaan['tgl_lahir']?>" readonly>
                            </div>
                            <?php 
                                
                                // $tgl = explode('-', $keanggotaan['tgl_lahir']);
                                // $nil = join("",$tgl);
                                // $sub2 = substr($nil,-2);
                                // $sub4 = substr($nil,-4,-2);
                                // $sub6 = substr($nil,2, -4);
                                // $string = "$sub2"."$sub4"."$sub6";
                                // "<br>";
                                // "<br>";
                                // // echo $string;

                                // //=========================
                                // //ANGKA RANDOM
                                // $karakter = '0123456789';
                                // $shuffle  = substr(str_shuffle($karakter), 0, 7);
                                // $akhir = $shuffle;

                                // $mode = 0;

                                // $hasil = "$string"."$akhir";
                            ?>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>No KTP</label>
                                    <input type="text" class="form-control" value="<?= $keanggotaan['no_ktp']?>" readonly>
                                    <!-- <input type="text" class="form-control" value="<?= $hasil?>" readonly> -->
                                </div>
                                <div class="form-group col-md-6">
                                    <label>No KTA</label>
                                    <input type="text" class="form-control" value="<?= $keanggotaan['no_kta'] ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['alamat']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>NO HP</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['no_hp']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Agama</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['agama']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['email']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Jenis Kelamin</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['jenis_kelamin']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Status Perkawinan</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['status_perkawinan']?>" readonly>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>Nama Istri / Suami</label>
                                    <input type="text" class="form-control" value="<?= $keanggotaan['nama_istri_suami']?>" readonly>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Nama Anak</label>
                                    <input type="text" class="form-control" value="<?= $keanggotaan['nama_anak']?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Latar Belakang Pendidikan</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['latar_pendidikan']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Latar Belakang Organisasi</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['latar_organisasi']?>" readonly>
                            </div>
                            <div class="form-group">
                                <label>Latar Belakang Pekerjaan</label>
                                <input type="text" class="form-control" value="<?= $keanggotaan['latar_pekerjaan']?>" readonly>
                            </div>
                       </form>
                    </div> 
                </div>
            </div>
            <div class="col-md-4">
                <div class="card mb-3 mx-auto">
                    <img src="<?= base_url('uploads/').$keanggotaan['foto_ktp'] ?>" class="card-img-top card-img img-thumbnail mx-auto mt-2" style="max-width: 300px;">
                </div>
                <div class="card mb-3 mx-auto">
                    <div class="progress progress-striped active">
                        <?php 
                            if ($keanggotaan['status'] == 0) {
                                $bar = 'progress-bar-striped bg-danger progress-bar-animated';
                                $wd = '50%';
                                $text = '50% (Menunggu Verifikasi)';
                            }
                            else {
                                $bar = 'progress-bar-striped bg-success progress-bar-animated';
                                $wd = '100%';
                                $text = '100% (Sudah Diverifikasi)';
                            }
                        ?>
                        <div class="progress-bar <?php echo $bar ?>" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $wd ?>"><?php echo $text ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>