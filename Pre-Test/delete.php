<?php
include "config.php";
session_start();

if (isset($_REQUEST['id'])) {
    $id_mhs = $_GET['id'];

    if (!empty($id_mhs)) {
        // Query
        $sql = "DELETE FROM mahasiswa WHERE id = '{$id_mhs}';";
        $sql2 = "DELETE FROM kelas_mahasiswa WHERE kelas_id = '{$id_mhs}';";
        $delete = mysqli_query($conn, $sql);
        $delete2 = mysqli_query($conn, $sql2);

        if ($delete && $delete === TRUE) {
            $_SESSION['desc'] = "danger";
            $_SESSION['message'] = "Data berhasil dihapus";

            header("location: index.php");
        } else {
            echo "error ngabs : " . mysqli_error($conn);
            exit();
        }
    } else {
        echo "<script>alert('ID Mahasiswa kosong!');</script>";
    }
} else {
    echo "<script>alert('ID Mahasiswa tidak didefinisikan!');</script>";
}

// mengalihkan halaman
echo "<meta http-equiv='refresh' content='0; url=index.php'>";