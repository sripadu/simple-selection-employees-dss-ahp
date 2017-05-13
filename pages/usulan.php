<?php
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $mysqli->query("SELECT * FROM usulan WHERE id_usulan='$_GET[key]'");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$err = false;
	if ($update) {
		$sql = "UPDATE usulan SET nik='$_POST[nik]', periode='$_POST[periode]', nilai='$_POST[nilai]' WHERE id_usulan='$_GET[key]'";
	} else {
		$sql = "INSERT INTO usulan VALUES(NULL, '$_POST[nik]', '$_POST[periode]', '$_POST[nilai]')";
	}

    if (!$err AND $mysqli->query($sql)) {
        $alert =  alert("success", "Usulan untuk <u>{$_POST["nik"]}</u> berhasil disimpan!");
    } else {
        $alert =  alert("danger", "Usulan untuk <u>{$_POST["nik"]}</u> gagal disimpan!<hr>{$mysqli->error}");
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
                        <label for="nik">Pegawai</label>
                        <select class="form-control" name="nik">
                            <option>---</option>
                            <?php $q = $mysqli->query("SELECT * FROM pegawai"); while ($r = $q->fetch_assoc()): ?>
                                <option value="<?=$r["nik"]?>" <?= (!$update) ?: (($row["nik"] != $r["nik"]) ?: 'selected="on"') ?>><?=$r["nama"]?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="periode">Periode</label>
                        <select class="form-control" name="periode">
                            <option>---</option>
														<?php for ($i=2005; $i<=date("Y"); $i++): ?>
	                            <option value="<?=$i?>" <?= (!$update) ?: (($row["periode"] != $i) ?: 'selected="on"') ?>><?=$i?></option>
														<?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nilai">Nilai</label>
                        <input type="text" name="nilai" class="form-control" <?= (!$update) ?: 'value="'.$row["nilai"].'"' ?>>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-<?= ($update) ? "warning" : "dark" ?> btn-block">Simpan</button>
                    <?php if ($update): ?>
                        <a href="?page=usulan" class="btn btn-default btn-block">Batal</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
	</div>
    <?php endif; ?>
	<div class="col-md-<?=(isset($_GET["laporan"])) ? "12" : "8"?>">
        <?=(isset($alert)) ? $alert : "" ?>
	    <div class="panel panel-dark">
	        <div class="panel-heading"><h3 class="text-center">DAFTAR PENILAIAN</h3></div>
	        <div class="panel-body">
	            <table class="table table-condensed" id="usulan">
	                <thead>
	                    <tr>
	                        <th>No</th>
	                        <th>Nama</th>
	                        <th>Nilai</th>
	                        <th>Periode</th>
	                        <th class="hidden-print"></th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $mysqli->query("SELECT u.id_usulan, p.nama, u.nilai, u.periode FROM usulan u JOIN pegawai p USING(nik)")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr id="<?=$row['id_usulan']?>">
	                            <td><?=$no++?></td>
															<td><?=$row['nama']?></td>
	                            <td><?=$row['nilai']?></td>
	                            <td><?=$row['periode']?></td>
	                            <td class="hidden-print">
	                                <div class="btn-group">
	                                    <a href="?page=usulan&action=update&key=<?=$row['id_usulan']?>" class="btn btn-warning btn-xs hidden-print">Edit</a>
                                        <buttpn role="button" onClick="deleteRecord('usulan', 'id_usulan', <?=$row['id_usulan']?>)" class="btn btn-danger btn-xs hidden-print">Hapus</buttpn>
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
