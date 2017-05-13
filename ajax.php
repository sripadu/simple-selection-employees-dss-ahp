<?php require_once("config.php");

if ($mysqli->query("DELETE FROM $_GET[table] WHERE $_GET[field]=$_GET[id]")) {
    echo "true";
} else {
    echo "false";
}