<?php

include "config.php";
session_start();

if (isset($_REQUEST['submit'])) {

    $nama_siswa = $_REQUEST['nama_lengkap'];
    $nim = $_REQUEST['nim'];
    $periode = $_REQUEST['periode'];
    $prodi = $_REQUEST['id_prodi'];
    $kelas = $_REQUEST['id_kelas'];

    // echo "<pre>";
    // print_r($_REQUEST);
    // echo "</pre>";

    $targetDir = "uploads/";

    $fileName = $_FILES["file"]["name"];
    $fileTmpName = $_FILES["file"]["tmp_name"];
    $fileType = strtolower($_FILES["file"]["type"]);

    $customFileName = $nim . "_" . time() . "_" . $fileName;
    $targetFilePath = $targetDir . $customFileName;

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
    if (in_array($fileExt, $allowedTypes)) {
        if (move_uploaded_file($fileTmpName, $targetFilePath)) {
            echo "File berhasil diunggah dengan nama kustom: " . $customFileName;
        } else {
            echo "Terjadi kesalahan saat mengunggah file.";
            die();
        }
    } else {
        echo "Jenis file yang diunggah tidak diizinkan.";
        die();
    }

    $query = "INSERT INTO mahasiswa VALUES (NULL, '{$nama_siswa}', '{$nim}', '{$prodi}', '{$periode}', '{$customFileName}')";

    $insert = mysqli_query($conn, $query);

    if ($insert) {
        $getId = mysqli_query($conn, "SELECT id FROM mahasiswa ORDER BY id DESC LIMIT 1");
        $row = $getId->num_rows;

        if ($row > 0) {
            $getById = mysqli_fetch_array($getId);
            $id_mhs = $getById['id'];
        }

        $query2 = "INSERT INTO kelas_mahasiswa VALUES (NULL, '{$kelas}', '{$id_mhs}')";
        mysqli_query($conn, $query2);
        $_SESSION['desc'] = "success";
        $_SESSION['message'] = "Data berhasil di simpan";
        header("location: index.php");
    } else {
        $_SESSION['desc'] = "danger";
        $_SESSION['message'] = "error ngabs : " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Input Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="shortcut icon" href="https://cdn1.iconfinder.com/data/icons/basic-ui-169/32/Login-256.png"
        type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card login-content shadow-lg border-0">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="card-body">
                            <h1 class="p-3 text-logo">
                                Tambah Mahasiswa
                            </h1>

                            <div class="mb-3 row">
                                <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nim" name="nim">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="periode" class="col-sm-2 col-form-label">Periode</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="periode" id="periode">
                                        <?php
                                        $year = date('Y');
                                        for ($i = $year; $i > $year - 5; $i--) { ?>
                                        <option value="<?= $i; ?>"><?= $i; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="periode" class="col-sm-2 col-form-label">Program Studi</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_prodi">
                                        <option disabled selected> Pilih Prodi</option>
                                        <?php
                                        $sql = "SELECT * FROM program_studi";
                                        $query = mysqli_query($conn, $sql);
                                        while ($data = mysqli_fetch_array($query)) {
                                            ?>
                                        <option value="<?= $data['ps_id'] ?>"><?= $data['program_studi'] ?> </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="periode" class="col-sm-2 col-form-label">Kelas</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="id_kelas">
                                        <option disabled selected> Pilih Kelas</option>
                                        <?php
                                        $sql = "SELECT * FROM kelas";
                                        $query = mysqli_query($conn, $sql);
                                        while ($data = mysqli_fetch_array($query)) {
                                            ?>
                                        <option value="<?= $data['id_kelas'] ?>"><?= $data['nama_kelas'] ?> </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="formFileMultiple" class="col-sm-2 col-form-label">Photo Profile</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" name="file" id="formFileMultiple" multiple>
                                </div>
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary float-end" value="Simpan">
                            <a href="index.php" class="btn btn-secondary float-end me-2">Kembali</a>
                        </div>
                    </form>
                    <div class="footer">
                        <p class="text-center small">© 2023 Hand-crafted & Made with D112121057</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>