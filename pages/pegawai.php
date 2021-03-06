<?php
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $mysqli->query("SELECT * FROM pegawai WHERE nik='$_GET[key]'");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$validasi = false; $err = false;
	if ($update) {
		$sql = "UPDATE pegawai SET nik='$_POST[nik]',nama='$_POST[nama]',tempat_lahir='$_POST[tempat_lahir]',tanggal_lahir='$_POST[tanggal_lahir]',kelamin='$_POST[kelamin]',alamat='$_POST[alamat]',jabatan='$_POST[jabatan]',tanggal_masuk='$_POST[tanggal_masuk]',pendidikan='$_POST[pendidikan]' WHERE nik='$_GET[key]'";
	} else {
		$sql = "INSERT INTO pegawai VALUES ('$_POST[nik]', '$_POST[nama]', '$_POST[tempat_lahir]', '$_POST[tanggal_lahir]', '$_POST[kelamin]', '$_POST[alamat]', '$_POST[jabatan]', '$_POST[tanggal_masuk]', '$_POST[pendidikan]')";
		$validasi = true;
	}

	if ($validasi) {
		$q = $mysqli->query("SELECT nik FROM pegawai WHERE nik=$_POST[nik]");
		if ($q->num_rows) {
			$alert =  alert("warning", "<u>{$_POST["nik"]}</u> atas nama <u>{$_POST["nama"]}</u> sudah terdaftar!");
			$err = true;
		}
	}

    if (!$err AND $mysqli->query($sql)) {
        $alert =  alert("success", "<u>{$_POST["nik"]}</u> atas nama <u>{$_POST["nama"]}</u> berhasil disimpan!");
    } else {
        $alert =  alert("danger", "<u>{$_POST["nik"]}</u> atas nama <u>{$_POST["nama"]}</u> gagal disimpan!<hr>{$mysqli->error}");
    }
}
?>
<div class="row">
    <?php if (!isset($_GET["laporan"])): ?>
	<div class="col-md-4 hidden-print">
	    <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
            <div class="panel panel-<?= ($update) ? "warning" : "dark" ?>">
                <div class="panel-heading"><h3 class="text-center"><?= ($update) ? "EDIT" : "TAMBAH" ?></h3></div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="nik">Nomor Induk Karyawan</label>
                        <input type="text" name="nik" class="form-control" <?= (!$update) ?: 'value="'.$row["nik"].'"' ?>>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" <?= (!$update) ?: 'value="'.$row["nama"].'"' ?>>
                    </div>
                    <div class="form-group">
                        <label for="tempat_lahir">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="form-control" <?= (!$update) ?: 'value="'.$row["tempat_lahir"].'"' ?>>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="text" name="tanggal_lahir" class="form-control datepicker" <?= (!$update) ?: 'value="'.$row["tanggal_lahir"].'"' ?>>
                    </div>
                    <div class="form-group">
                        <label for="kelamin">Jenis Kelamin</label>
                        <select class="form-control" name="kelamin">
                            <option>---</option>
                            <option value="Pria" <?= (!$update) ?: (($row["kelamin"] != "pria") ?: 'selected="on"') ?>>Pria</option>
                            <option value="Wanita" <?= (!$update) ?: (($row["kelamin"] != "wanita") ?: 'selected="on"') ?>>Wanita</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" name="alamat" class="form-control" <?= (!$update) ?: 'value="'.$row["alamat"].'"' ?>>
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" <?= (!$update) ?: 'value="'.$row["jabatan"].'"' ?>>
                    </div>
                    <div class="form-group">
                        <label for="tanggal_masuk">Tanggal Masuk</label>
                        <input type="text" name="tanggal_masuk" class="form-control datepicker" <?= (!$update) ?: 'value="'.$row["tanggal_masuk"].'"' ?>>
                    </div>
                    <div class="form-group">
                        <label for="pendidikan">Pendidikan</label>
                        <input type="text" name="pendidikan" class="form-control" <?= (!$update) ?: 'value="'.$row["pendidikan"].'"' ?>>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-<?= ($update) ? "warning" : "dark" ?> btn-block">Simpan</button>
                    <?php if ($update): ?>
                        <a href="?page=pegawai" class="btn btn-default btn-block">Batal</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
	</div>
    <?php endif; ?>

    <div class="col-md-<?=(isset($_GET["laporan"])) ? "12" : "8"?>">
        <?=(isset($alert)) ? $alert : "" ?>
	    <div class="panel panel-dark">
	        <div class="panel-heading"><h3 class="text-center">DAFTAR PEGAWAI</h3></div>
	        <div class="panel-body">
	            <table class="table table-condensed" id="pegawai">
	                <thead>
	                    <tr>
	                        <th>No</th>
	                        <th>NIK</th>
	                        <th>Nama</th>
	                        <th>Tempat, Tgl Lahir</th>
	                        <th>Alamat</th>
	                        <th>Jabatan</th>
	                        <th>Tanggal Masuk</th>
	                        <th>Pendidikan</th>
	                        <th class="hidden-print"></th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $mysqli->query("SELECT * FROM pegawai")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr id="<?=$row['nik']?>">
	                            <td><?=$no++?></td>
	                            <td><?=$row['nik']?></td>
	                            <td><?=$row['nama']?></td>
	                            <td><?=$row['tempat_lahir']?>, <?=$row['tanggal_lahir']?></td>
															<td><?=$row['kelamin']?></td>
	                            <td><?=$row['alamat']?></td>
	                            <td><?=$row['jabatan']?></td>
	                            <td><?=$row['tanggal_masuk']?></td>
	                            <td><?=$row['pendidikan']?></td>
	                            <td class="hidden-print">
	                                <div class="btn-group">
	                                    <a href="?page=pegawai&action=update&key=<?=$row['nik']?>" class="btn btn-warning btn-xs hidden-print">Edit</a>
                                        <buttpn role="button" onClick="deleteRecord('pegawai', 'nik', <?=$row['nik']?>)" class="btn btn-danger btn-xs hidden-print">Hapus</buttpn>
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
