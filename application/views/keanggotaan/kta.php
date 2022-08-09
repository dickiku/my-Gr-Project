<?php 
    date_default_timezone_set('Asia/Jakarta');
    $tgl = date('d F Y');
?>
<!doctype html>
<html><head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/style.css">
</head><body>
    <div class="container-fluid">
        <div class="row mt-2">
            <div class="col-md-2">
                <img class= "img-thumbnail" src="<?= base_url() ?>uploads/<?= $keanggotaan['foto_profil'] ?>" width="150px" height="150px">
            </div>
            <div class="col-md-10">
                <div class="text-header">
                    <!-- <p>||||||||||||||||||||||||||||||||||||||||||||||||||||||||||</p> -->
                    <p>
                    <?php
                        // require 'vendor/autoload.php';

                        $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
                        echo '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($keanggotaan['no_kta'], $generator::TYPE_CODE_128)) . '">';
                    ?>
                    </p>
                    <p class="kta"><?= $keanggotaan['no_kta']?></p>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        Nama
                    </div>
                    <div class="col-md-10 text-tebal">
                       : <?= $keanggotaan['nama'] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        TTL
                    </div>
                    <div class="col-md-10 text-tebal">
                       : <?= $keanggotaan['tempat_lahir'] ?>,<?= $keanggotaan['tgl_lahir'] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        Alamat
                    </div>
                    <div class="col-md-10 text-tebal">
                       : <?= $keanggotaan['alamat'] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        Kel./Kec
                    </div>
                    <div class="col-md-10 text-tebal">
                       : <?= $keanggotaan['nm_desa'] ?> / <?= $keanggotaan['nm_kec'] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        Kab.
                    </div>
                    <div class="col-md-10 text-tebal">
                       : <?= $keanggotaan['nm_kab'] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        Provinsi
                    </div>
                    <div class="col-md-10 text-tebal">
                       : Jawa Tengah
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        Kelamin
                    </div>
                    <div class="col-md-10 text-tebal">
                       : <?= $keanggotaan['jenis_kelamin']?>
                    </div>
                </div>
                <br>
                <div class="row justify-content-end">
                    <div class="col-md-3">
                        <img src="<?= base_url('uploads/prabowo.png') ?>" width="200px">
                    </div>
                    <div class="col-md-2">
                        <img src="<?= base_url('uploads/geri.png') ?>" width="80px">
                    </div>
                    <div class="col-md-2">
                        <img src="<?= base_url('uploads/muzani.png') ?>" width="160px">
                    </div>
                    <div class="col-md-5">
                        &nbsp;
                    </div>
                </div>
                <!-- <div class="row justify-content-end">
                    <div class="col-md-2">
                        TTD
                    </div>
                    <div class="col-md-2">
                        
                    </div>
                    <div class="col-md-8">
                        TTD
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-md-2">
                        H. PRABOWO SUBIANTO
                    </div>
                    <div class="col-md-2">
                        
                    </div>
                    <div class="col-md-8">
                        H. AHMAD MUZANI
                    </div>
                </div> -->
            </div>
        </div>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/bootstrap.min.js"></script>
        <!-- <script type="text/javascript">
            window.print();
        </script> -->
    </div>
</body></html>
