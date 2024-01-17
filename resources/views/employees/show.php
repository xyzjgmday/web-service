<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Detail Employee</h1>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td>ID</td>
                    <td>
                        <?= $result->id ?>
                    </td>
                </tr>
                <tr>
                    <td>Name </td>
                    <td>
                        <?= $result->employee_name ?>
                    </td>
                </tr>
                <tr>
                    <td>Salary</td>
                    <td>
                        <?= $result->employee_salary ?>
                    </td>
                </tr>
                <tr>
                    <td>Age</td>
                    <td>
                        <?= $result->employee_age ?>
                    </td>
                </tr>
                <tr>
                    <td>Image</td>
                    <td>
                        <?= $result->profile_image ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>