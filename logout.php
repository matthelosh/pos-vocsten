<?php
    include 'konf/db.php';
    session_start();
    $_SESSION = array();
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    $del_log = mysqli_query($koneksi, "UPDATE access_log SET isActive='0' WHERE user = '$_SESSION[user]'");
    if (!$del_log) {
        echo 'Error :'. mysqli_error($koneksi);
    } else {
        session_destroy();
        header('location:index.php');
    }
?>
