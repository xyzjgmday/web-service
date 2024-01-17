<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employees</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>List Employees</h1>
            <a href="employee/create" class="btn btn-info"><i class="fas fa-plus"></i></a>
        </div>
        <div class="table-responsive-md">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Salary</th>
                        <th>Age</th>
                        <th>Image</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result) { ?>
                        <tr>
                            <td>
                                <?= $result->id ?>
                            </td>
                            <td>
                                <?= $result->employee_name ?>
                            </td>
                            <td>
                                <?= $result->employee_salary ?>
                            </td>
                            <td>
                                <?= $result->employee_age ?>
                            </td>
                            <td>
                                <?= $result->profile_image ?>
                            </td>
                            <td>
                                <a class="btn btn-primary" href="/employee/detail/<?= $result->id ?>">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a class="btn btn-success" href="/employee/change/<?= $result->id ?>">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" class="btn btn-danger" onclick="deleteEmployee(<?= $result->id ?>)">
                                    <i class="far fa-trash-alt"></i>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script>
        function deleteEmployee(employeeId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'https://dummy.restapiexample.com/api/v1/delete/' + employeeId,
                        method: 'DELETE',
                        success: function (response) {
                            var responseData = response;
                            if (responseData.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: responseData.message,
                                }).then(() => {
                                    // Reload the page after successful deletion
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: responseData.message,
                                });
                            }
                        },
                        error: function (error) {
                            console.error('Error deleting employee:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred. Please try again later.',
                            });
                        }
                    });
                }
            });
        }

        $(document).ready(function () {
            $('#example').DataTable();
        });
    </script>


</body>

</html>