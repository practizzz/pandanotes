<?php
session_start(); ?>

<?php

session_destroy();

echo "<script>window.location.href= 'index.php';</script>";

?>