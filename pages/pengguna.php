<?php
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $mysqli->query("SELECT * FROM user WHERE id_user='$_GET[key]'");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$err = false;
    if (trim($_POST["password"]) != trim($_POST["konfirmasi_password"])) {
        $alert =  alert("danger", "Password tidak cocok!");
        $err = true;
    }

	if ($update) {
		$sql = "UPDATE user SET role='$_POST[role]', username='$_POST[username]'";
        if (trim($_POST["password"]) != "") {
            $sql .= ", password='".md5($_POST["password"])."'";
        }
        $sql .= " WHERE id_user='$_GET[key]'";
	} else {
		$sql = "INSERT INTO user VALUES (NULL, '$_POST[role]', '$_POST[username]', '".md5($_POST["password"])."')";
	}

    if (!$err AND $mysqli->query($sql)) {
        $alert =  alert("success", "Pengguna <u>{$_POST["username"]}</u> berhasil disimpan!");
    } else {
        $alert =  alert("danger", "Pengguna <u>{$_POST["username"]}</u> gagal disimpan!<hr>{$mysqli->error}");
    }
}
?>
<div class="row">
	<div class="col-md-4 hidden-print">
	    <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
            <div class="panel panel-<?= ($update) ? "warning" : "dark" ?>">
                <div class="panel-heading"><h3 class="text-center"><?= ($update) ? "EDIT" : "TAMBAH" ?></h3></div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select name="role" class="form-control">
                            <option value="">---</option>
                            <option value="Atasan" <?= (!$update) ?: (($row["role"] != "Atasan") ?: 'selected="on"') ?>>Atasan</option>
                            <option value="Manajer" <?= (!$update) ?: (($row["role"] != "Manajer") ?: 'selected="on"') ?>>Manajer</option>
                            <option value="Pegawai" <?= (!$update) ?: (($row["role"] != "Pegawai") ?: 'selected="on"') ?>>Pegawai</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" class="form-control" <?= (!$update) ?: 'value="'.$row["username"].'"' ?>>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control">
                        <?php if (isset($_GET["action"]) == "update"): ?>
                            <span class="help-block text-red">*) Kosongkan jika tidak diubah</span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label for="konfirmasi_password">Konfirmasi Password</label>
                        <input type="password" name="konfirmasi_password" class="form-control">
                        <?php if (isset($_GET["action"]) == "update"): ?>
                            <span class="help-block text-red">*) Kosongkan jika tidak diubah</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-<?= ($update) ? "warning" : "dark" ?> btn-block">Simpan</button>
                    <?php if ($update): ?>
                        <a href="?page=pengguna" class="btn btn-default btn-block">Batal</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
	</div>
	<div class="col-md-8">
        <?=(isset($alert)) ? $alert : "" ?>
	    <div class="panel panel-dark">
	        <div class="panel-heading"><h3 class="text-center">DAFTAR PENGGUNA</h3></div>
	        <div class="panel-body">
	            <table class="table table-condensed" id="kriteria">
	                <thead>
	                    <tr>
	                        <th>No</th>
	                        <th>Role</th>
	                        <th>Username</th>
	                        <th class="hidden-print"></th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $mysqli->query("SELECT * FROM user")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr id="<?=$row['id_user']?>">
	                            <td><?=$no++?></td>
	                            <td><?=$row['role']?></td>
	                            <td><?=$row['username']?></td>
	                            <td class="hidden-print">
	                                <div class="btn-group">
	                                    <a href="?page=pengguna&action=update&key=<?=$row['id_user']?>" class="btn btn-warning btn-xs hidden-print">Edit</a>
                                        <buttpn role="button" onClick="deleteRecord('user', 'id_user', <?=$row['id_user']?>)" class="btn btn-danger btn-xs hidden-print">Hapus</buttpn>
	                                </div>
	                            </td>
	                        </tr>
	                        <?php endwhile ?>
	                    <?php endif ?>
	                </tbody>
	            </table>
	        </div>
            <div class="panel-footer hidden-print">
                <button type="submit" onClick="window.print();return false" class="btn btn-dark"><i class="glyphicon glyphicon-print"></i></button>
            </div>
	    </div>
	</div>
</div>
