<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Create Employee</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <div class="container mt-5">
        <h2>Create Employee</h2>
        <form id="createForm" class="needs-validation" novalidate>
            <div class="form-group">
                <label for="employeeName">Employee Name</label>
                <input type="text" class="form-control" id="employeeName" name="employee_name" required>
                <div class="invalid-feedback">Please provide the employee name.</div>
            </div>
            <div class="form-group">
                <label for="employeeSalary">Employee Salary</label>
                <input type="number" class="form-control" id="employeeSalary" name="employee_salary" required>
                <div class="invalid-feedback">Please provide a valid salary.</div>
            </div>
            <div class="form-group">
                <label for="employeeAge">Employee Age</label>
                <input type="number" class="form-control" id="employeeAge" name="employee_age" required>
                <div class="invalid-feedback">Please provide a valid age.</div>
            </div>
            <button type="button" class="btn btn-primary" onclick="createEmployee()">Create Employee</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
        function createEmployee() {
            var form = document.getElementById('createForm');

            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
            if (form.checkValidity()) {
                var formData = {
                    employee_name: $('#employeeName').val(),
                    employee_salary: $('#employeeSalary').val(),
                    employee_age: $('#employeeAge').val()
                };
                fetch('https://dummy.restapiexample.com/api/v1/create', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(formData),
                })
                    .then(response => response.json())
                    .then(data => {
                        var responseData = data;
                        if (data.status === 'success') {
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
                                text: 'Failed to create employee. Please try again.',
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'An error occurred. Please try again later.',
                        });
                    });
            }
        }
    </script>

</body>

</html>