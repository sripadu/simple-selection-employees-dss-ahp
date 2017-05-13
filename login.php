<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("config.php");
    $sql = "SELECT * FROM user WHERE username='$_POST[username]' AND password='" . md5($_POST['password']) . "'";
    if ($query = $mysqli->query($sql)) {
        if ($query->num_rows) {
            session_start();
            while ($data = $query->fetch_array()) {
                $_SESSION['role'] = $data['role'];
                $_SESSION['username'] = $data['username'];
            }
            header('location: index.php');
        } else {
            $msg = "Username / Password tidak sesuai!";
        }
    } else {
        $msg = "Query error!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pemilihan Pegawai Terbaik</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/sweetalert.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4"></div>
            <div class="col-md-4">
                <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
                    <div class="panel panel-dark login-box">
                        <div class="panel-heading"><h3 class="text-center">LOGIN USER</h3></div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Username" autofocus="on">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password">
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-dark raised btn-block">Login</button>
                            <br>
                            <p class="text-center">PT. Global Eushanosoft</p>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/sweetalert.min.js"></script>
	<?php if (isset($msg)): ?>
    <script type="text/javascript">
		swal({
            title: "Maaf!",
            text: "<?=$msg?>",
            type: "error",
            timer: 2000,
            confirmButtonColor: "#DD6B55"
		})
	</script>
	<?php endif; ?>
</body>
</html>
