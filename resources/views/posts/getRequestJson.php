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
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Content</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($results as $result) {
                    echo "<tr>";
                    echo "<td>" . $result->id . "</td>";
                    echo "<td>" . $result->user_id . "</td>";
                    echo "<td>" . $result->title . "</td>";
                    echo "<td>" . $result->status . "</td>";
                    echo "<td>" . $result->content . "</td>";
                    echo "<td>" . $result->created_at . "</td>";
                    echo "<td>" . $result->updated_at . "</td>";
                    echo "</tr>";
                } ?>
            </tbody>
        </table>
    </div>
</body>

</html>