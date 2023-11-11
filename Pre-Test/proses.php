<?php
session_start();

$listUser = [
    [
        'username' => 'nsubhiz',
        'email' => 'daysubhiz@gmail.com',
        'password' => '123546'
    ],
    [
        'username' => 'daysubhiz',
        'email' => 'gimyungkim91@gmail.com',
        'password' => '123456'
    ]
];

$notFound = false;
$email = $_POST['email'];
$password = $_POST['passwd'];


//cek email
$validEmail = false;
foreach ($listUser as $user) {
    if ($user['email'] == $email) {
        $validEmail = true;
        break;
    }
}

if (!$email) {
    $_SESSION['error'] = 'Email tidak boleh kosong!';
    $notFound = true;
} elseif (!$validEmail) {
    $_SESSION['error'] = $email . ' Email tidak terdaftar';
    $notFound = true;
} else {
    $passwordValid = false;

    //cek password
    foreach ($listUser as $user) {
        if (!$password) {
            $_SESSION['error'] = 'Password tidak boleh kosong!';
            $passwordValid = false;
        } elseif ($user['email'] == $email && $user['password'] == $password) {
            // Set Cookie
            if (isset($_REQUEST['remember'])) {
                setcookie('login', 'true', time() + 60);
                setcookie('key', $_REQUEST['email'], time() + 60);
            }
            $_SESSION['success'] = "Login berhasil...";
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $passwordValid = true;
            break;
        } else {
            $_SESSION['error'] = 'Password Salah';
            $passwordValid = false;
        }
    }
}


if ($notFound == true || !$passwordValid) {
    header("location: login.php");
} else {
    header("location: index.php");
}