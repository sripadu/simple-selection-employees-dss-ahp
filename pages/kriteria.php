<?php
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $mysqli->query("SELECT * FROM kriteria WHERE id_kriteria='$_GET[key]'");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$err = false;
	if ($update) {
		$sql = "UPDATE kriteria SET nama='$_POST[nama]', bobot='$_POST[bobot]' WHERE id_kriteria='$_GET[key]'";
	} else {
		$sql = "INSERT INTO kriteria VALUES (NULL, '$_POST[nama]', '$_POST[bobot]')";
	}

    if (!$err AND $mysqli->query($sql)) {
        $alert =  alert("success", "Kriteria <u>{$_POST["nama"]}</u> berhasil disimpan!");
    } else {
        $alert =  alert("danger", "Kriteria <u>{$_POST["nama"]}</u> gagal disimpan!<hr>{$mysqli->error}");
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
                <?php $q = $mysqli->query("SELECT SUM(bobot) AS total FROM kriteria"); if ($q->fetch_assoc()["total"] != 100): ?>
                    <div class="form-group">
                        <label for="nama">Nama Kriteria</label>
                        <input type="text" name="nama" class="form-control" <?= (!$update) ?: 'value="'.$row["nama"].'"' ?>>
                    </div>
                    <div class="form-group">
                        <label for="bobot">Bobot</label>
                        <input type="text" name="bobot" class="form-control" <?= (!$update) ?: 'value="'.$row["bobot"].'"' ?>>
                    </div>
                <?php else: ?>
                    <h3 class="text-center text-red">Kriteria sudah penuh!</h3>
                <?php endif; ?>
                </div>
                <?php $q = $mysqli->query("SELECT SUM(bobot) AS total FROM kriteria"); if ($q->fetch_assoc()["total"] != 100): ?>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-<?= ($update) ? "warning" : "dark" ?> btn-block">Simpan</button>
                    <?php if ($update): ?>
                        <a href="?page=kriteria" class="btn btn-default btn-block">Batal</a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
        </form>
	</div>
    <?php endif; ?>
	<div class="col-md-<?=(isset($_GET["laporan"])) ? "12" : "8"?>">
        <?=(isset($alert)) ? $alert : "" ?>
	    <div class="panel panel-dark">
	        <div class="panel-heading"><h3 class="text-center">DAFTAR KRITERIA</h3></div>
	        <div class="panel-body">
	            <table class="table table-condensed" id="kriteria">
	                <thead>
	                    <tr>
	                        <th>No</th>
	                        <th>Nama</th>
	                        <th>Bobot</th>
	                        <th class="hidden-print"></th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $mysqli->query("SELECT * FROM kriteria")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr id="<?=$row['id_kriteria']?>">
	                            <td><?=$no++?></td>
	                            <td><?=$row['nama']?></td>
	                            <td><?=$row['bobot']?></td>
	                            <td class="hidden-print">
	                                <div class="btn-group">
	                                    <a href="?page=kriteria&action=update&key=<?=$row['id_kriteria']?>" class="btn btn-warning btn-xs hidden-print">Edit</a>
                                        <buttpn role="button" onClick="deleteRecord('kriteria', 'id_kriteria', <?=$row['id_kriteria']?>, true)" class="btn btn-danger btn-xs hidden-print">Hapus</buttpn>
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
