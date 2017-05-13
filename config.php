<?php

// Koneksi database
if (!$mysqli = new Mysqli("localhost", "root", "idiot", "")) {
    die("Koneksi database gagal!");
}

if (!isset($_GET["page"])) {
    $_PAGE = "home";
} else {
    $_PAGE = $_GET["page"];
}

if (isset($_GET["logout"])) {
    unset($_SESSION["role"]);
    header("location: login.php");
}

function paging() {
    if (isset($_GET["page"])) {
        return "pages/{$_GET["page"]}.php";
    } else {
        return "pages/home.php";
    }
}

function activeMenu($current, $page) {
    if ($current === $page) {
        return "class=\"active\"";
    }
}

function alert($type = "success", $text) {
    switch ($type) {
        case 'success': $title = "Berhasil!"; break;
        case 'warning': $title = "Peringatan!"; break;
        default: $title = "Gagal!"; break;
    }
    return "<div class=\"alert alert-{$type} alert-dismissible\" role=\"alert\">
                <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                <strong>{$title}</strong> {$text}.
            </div>";
}
