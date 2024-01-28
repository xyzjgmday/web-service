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
        <h1>List Post</h1>
        <table class="table table-striped">
            <tbody>
                <tr>
                    <td>ID</td>
                    <td>
                        <?= $result['id'] ?>
                    </td>
                </tr>
                <tr>
                    <td>User ID</td>
                    <td>
                        <?= $result['user_id'] ?>
                    </td>
                </tr>
                <tr>
                    <td>Title</td>
                    <td>
                        <?= $result['title'] ?>
                    </td>
                </tr>
                <tr>
                    <td>Content</td>
                    <td>
                        <?= $result['content'] ?>
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <?= $result['status'] ?>
                    </td>
                </tr>
                <tr>
                    <td>Created At</td>
                    <td>
                        <?= $result['created_at'] ?>
                    </td>
                </tr>
                <tr>
                    <td>Update At</td>
                    <td>
                        <?= $result['updated_at'] ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>