<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Update Employee</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
</head>

<body>
    <div class="container mt-5">
        <h2>Update Employee</h2>
        <form id="updateForm" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="employeeName">Employee Name</label>
                <input type="text" class="form-control" id="employeeName" name="employee_name"
                    value="<?= isset($result->employee_name) ? $result->employee_name : '' ?>" required>
                <div class="invalid-feedback">Please provide the employee name.</div>
            </div>
            <div class="form-group">
                <label for="employeeSalary">Employee Salary</label>
                <input type="number" class="form-control" id="employeeSalary" name="employee_salary"
                    value="<?= isset($result->employee_salary) ? $result->employee_salary : '' ?>" required>
                <div class="invalid-feedback">Please provide a valid salary.</div>
            </div>
            <div class="form-group">
                <label for="employeeAge">Employee Age</label>
                <input type="number" class="form-control" id="employeeAge" name="employee_age"
                    value="<?= isset($result->employee_age) ? $result->employee_age : '' ?>" required>
                <div class="invalid-feedback">Please provide a valid age.</div>
            </div>
            <button type="button" class="btn btn-primary" onclick="updateEmployee()">Update Employee</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function updateEmployee() {
            var form = document.getElementById('updateForm');

            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }

            form.classList.add('was-validated');

            if (form.checkValidity()) {
                var url = window.location.href;
                var employeeId = url.substring(url.lastIndexOf('/') + 1);

                var formData = {
                    employee_name: $('#employeeName').val(),
                    employee_salary: $('#employeeSalary').val(),
                    employee_age: $('#employeeAge').val()
                };

                $.ajax({
                    url: 'https://dummy.restapiexample.com/api/v1/update/' + employeeId,
                    method: 'PUT',
                    contentType: 'application/json',
                    data: JSON.stringify(formData),
                    success: function (response) {
                        var responseData = response;
                        if (responseData.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: responseData.message,
                            }).then(() => {
                                window.location.href = '/employee';
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Failed to update employee. Please try again.',
                            });
                        }
                    },
                    error: function (error) {
                        console.error('Error updating employee:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred. Please try again later.',
                        });
                    }
                });
            }
        }

    </script>

</body>

</html>