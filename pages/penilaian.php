<?php
$update = (isset($_GET['action']) AND $_GET['action'] == 'update') ? true : false;
if ($update) {
	$sql = $mysqli->query("SELECT * FROM nilai WHERE id_nilai='$_GET[key]'");
	$row = $sql->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$err = false;
	if ($update) {
		$sql = "UPDATE nilai SET id_kriteria='$_POST[id_kriteria]', nik='$_POST[nik]', nilai='$_POST[nilai]', periode='$_POST[periode]' WHERE id_nilai='$_GET[key]'";
	} else {
		$sql = "INSERT INTO nilai VALUES(NULL, '$_POST[id_kriteria]', '$_POST[nik]', '$_POST[nilai]', '$_POST[periode]')";
	}

    if (!$err AND $mysqli->query($sql)) {
        $alert =  alert("success", "Penilaian untuk <u>{$_POST["nik"]}</u> berhasil disimpan!");
    } else {
        $alert =  alert("danger", "Penilaian untuk <u>{$_POST["nik"]}</u> gagal disimpan!<hr>{$mysqli->error}");
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
                        <label for="id_kriteria">Kriteria</label>
                        <select class="form-control" name="id_kriteria">
                            <option>---</option>
                            <?php $q = $mysqli->query("SELECT * FROM kriteria"); while ($r = $q->fetch_assoc()): ?>
                                <option value="<?=$r["id_kriteria"]?>" <?= (!$update) ?: (($row["id_kriteria"] != $r["id_kriteria"]) ?: 'selected="on"') ?>><?=$r["nama"]?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="nilai">Nilai</label>
                        <input type="text" name="nilai" class="form-control" <?= (!$update) ?: 'value="'.$row["nilai"].'"' ?>>
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
                </div>
                <div class="panel-footer">
                    <button type="submit" class="btn btn-<?= ($update) ? "warning" : "dark" ?> btn-block">Simpan</button>
                    <?php if ($update): ?>
                        <a href="?page=nilai" class="btn btn-default btn-block">Batal</a>
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
	            <table class="table table-condensed" id="nilai">
	                <thead>
	                    <tr>
	                        <th>No</th>
	                        <th>NIK</th>
	                        <th>Nama</th>
	                        <th>Kriteria</th>
	                        <th>Nilai</th>
	                        <th>PERIODE</th>
	                        <th class="hidden-print"></th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php $no = 1; ?>
	                    <?php if ($query = $mysqli->query("SELECT n.id_nilai, p.nik, p.nama, k.nama AS kriteria, n.nilai, n.periode FROM nilai n JOIN pegawai p ON n.nik=p.nik JOIN kriteria k ON n.id_kriteria=k.id_kriteria")): ?>
	                        <?php while($row = $query->fetch_assoc()): ?>
	                        <tr id="<?=$row['id_nilai']?>">
	                            <td><?=$no++?></td>
	                            <td><?=$row['nik']?></td>
	                            <td><?=$row['nama']?></td>
	                            <td><?=$row['kriteria']?></td>
	                            <td><?=$row['nilai']?></td>
	                            <td><?=$row['periode']?></td>
	                            <td class="hidden-print">
	                                <div class="btn-group">
	                                    <a href="?page=penilaian&action=update&key=<?=$row['id_nilai']?>" class="btn btn-warning btn-xs hidden-print">Edit</a>
                                        <buttpn role="button" onClick="deleteRecord('nilai', 'id_nilai', <?=$row['id_nilai']?>)" class="btn btn-danger btn-xs hidden-print">Hapus</buttpn>
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
