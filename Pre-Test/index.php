<?php
session_start();

if (!isset($_SESSION['username'])) { ?>
    <script>
        alert("Anda harus masuk terlebih dahulu!");
        window.location.href = "login.php";
    </script>
<?php
    exit();
} ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <link rel="shortcut icon" href="https://cdn1.iconfinder.com/data/icons/basic-ui-169/32/Login-256.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card login-content shadow-lg border-0">
                    <div class="card-body">
                        <?php if (isset($_SESSION['success'])) { ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert" id="myAlert">
                                <?= $_SESSION['success']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php }
                        unset($_SESSION['success']); ?>
                        <?php if (isset($_SESSION['message'])) { ?>
                            <div class="alert alert-<?= $_SESSION['desc'] ?> alert-dismissible fade show" role="alert" id="myAlert">
                                <?= $_SESSION['message']; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php }
                        unset($_SESSION['message']); ?>
                        <h1 class="p-3 text-logo">
                            Data Mahasiswa
                            <a href="insert.php" class="btn btn-primary float-end me-2">Insert</a>
                            <a href="logout.php"><button type="submit" class="btn btn-primary float-end me-2">Logout</button></a>

                        </h1>
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>PP</th>
                                    <th>NIM</th>
                                    <th>Nama Lengkap</th>
                                    <th>Priode</th>
                                    <th>Program Studi</th>
                                    <th>Kelas</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include "config.php";
                                $query = "SELECT
                                                a.id,
                                                a.nama_lengkap,
                                                a.nim,
                                                a.foto,
                                                b.program_studi,
                                                a.periode,
                                                d.nama_kelas
                                            FROM
                                                mahasiswa a
                                                INNER JOIN program_studi b ON a.program_studi = b.ps_id
                                                INNER JOIN kelas_mahasiswa c ON a.id = c.mahasiswa_id
                                                INNER JOIN kelas d on c.kelas_id = d.id_kelas
                                            WHERE d.nama_kelas LIKE '%IF 2021%' ORDER BY a.id DESC";
                                $result = mysqli_query($conn, $query);
                                $id = 1;
                                foreach ($result as $row) {
                                ?>
                                    <tr>
                                        <td>
                                            <?= $id++ ?>
                                        </td>
                                        <td>
                                            <?php if (!$row['foto']) {
                                                echo '<img src="https://www.pooc.org/wp-content/uploads/2022/03/PP-WA-Kosong-6.jpg" alt="pp" class="img-thumbnail" width="80">';
                                            } else {
                                                echo '<img src="uploads/' . $row['foto'] . '" alt="pp" class="img-thumbnail" width="80">';
                                            } ?>

                                        </td>
                                        <td>
                                            <?= $row['nim'] ?>
                                        </td>
                                        <td>
                                            <?= $row['nama_lengkap'] ?>
                                        </td>
                                        <td>
                                            <?= $row['periode'] ?>
                                        </td>
                                        <td>
                                            <?= $row['program_studi'] ?>
                                        </td>
                                        <td>
                                            <?= $row['nama_kelas'] ?>
                                        </td>
                                        <td>
                                            <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-info text-white">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            <button onclick="confirmDelete(<?= $row['id'] ?>)" class="btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>NIM</th>
                                    <th>Nama Lengkap</th>
                                    <th>Priode</th>
                                    <th>Program Studi</th>
                                    <th>Kelas</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="footer">
                        <p class="text-center">© 2023 Hand-crafted & Made with D112121057</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        window.setTimeout(function() {
            $("#myAlert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
        $(document).ready(function() {
            $('#example').DataTable();
        });

        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
</body>

</html>