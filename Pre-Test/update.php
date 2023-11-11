<?php
include "config.php";
session_start();

$id_mhs = $_REQUEST['id'];
if (!isset($_REQUEST['submit'])) { // memperoleh buku_id

    if ($id_mhs) {
        // Query
        $sql = "SELECT
                    a.nama_lengkap,
                    a.nim,
                    b.ps_id,
                    a.periode,
                    c.kelas_id
                FROM
                    mahasiswa a
                    INNER JOIN program_studi b ON a.program_studi = b.ps_id
                    INNER JOIN kelas_mahasiswa c ON a.id = c.mahasiswa_id
                WHERE a.id = '{$id_mhs}';";
        $query = mysqli_query($conn, $sql);
        $row = $query->num_rows;

        if ($row > 0) {
            $data_update = mysqli_fetch_array($query); // memperoleh data buku
        } else {
            echo "<script>alert('NIM Mahasiswa tidak ditemukan!');</script>";

            // mengalihkan halaman
            echo "<meta http-equiv='refresh' content='0; url=index.php'>";
            exit;
        }
    } else {
        echo "<script>alert('NIM Mahasiswa kosong!');</script>";

        // mengalihkan halaman
        echo "<meta http-equiv='refresh' content='0; url=index.php'>";
        exit;
    }
} else {
    $nama_siswa = $_REQUEST['nama_lengkap'];
    $nim = $_REQUEST['nim'];
    $periode = $_REQUEST['periode'];
    $prodi = $_REQUEST['id_prodi'];
    $kelas = $_REQUEST['id_kelas'];

    // echo "<pre>";
    // print_r($_REQUEST);
    // echo "</pre>";

    $query = "UPDATE mahasiswa SET nama_lengkap = '{$nama_siswa}', nim = '{$nim}', program_studi = '{$prodi}', periode = '{$periode}' WHERE id = $id_mhs";
    $query2 = "UPDATE kelas_mahasiswa SET kelas_id = '{$kelas}' WHERE mahasiswa_id = $id_mhs";

    $update = mysqli_query($conn, $query);
    $update2 = mysqli_query($conn, $query2);

    if ($update && $update2 === TRUE) {
        $_SESSION['desc'] = "success";
        $_SESSION['message'] = "Data berhasil diubah";
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
    <title>Update Page</title>
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
                    <form action="" method="post">
                        <div class="card-body">
                            <h1 class="p-3 text-logo">
                                Tambah Mahasiswa
                            </h1>

                            <div class="mb-3 row">
                                <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nama_lengkap"
                                        value="<?= $data_update['nama_lengkap'] ?>" name="nama_lengkap">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="nim" value="<?= $data_update['nim'] ?>"
                                        name="nim">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="periode" class="col-sm-2 col-form-label">Periode</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="periode" id="periode">
                                        <?php
                                        $year = date('Y');
                                        for ($i = $year; $i > $year - 5; $i--) { ?>
                                            <option value="<?= $i; ?>" <?= ($data_update['periode'] == $i) ? 'selected' : ''; ?>><?= $i; ?></option>
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
                                            <option value="<?= $data['ps_id'] ?>" <?= ($data_update['ps_id'] == $data['ps_id']) ? 'selected' : ''; ?>><?= $data['program_studi'] ?> </option>
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
                                            <option value="<?= $data['id_kelas'] ?>"
                                                <?= ($data_update['kelas_id'] == $data['id_kelas']) ? 'selected' : ''; ?>><?= $data['nama_kelas'] ?> </option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <input type="submit" name="submit" class="btn btn-primary float-end" value="Simpan">
                            <a href="index.php" class="btn btn-secondary float-end me-2">Kembali</a>
                        </div>
                    </form>
                    <div class="footer">
                        <p class="text-center">© 2023 Hand-crafted & Made with D112121062</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>