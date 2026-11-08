<?php
session_start();
if (!empty($_SESSION['usuario_autenticado'])) {
    header('Location: ./adm/');
    exit;
}
?>