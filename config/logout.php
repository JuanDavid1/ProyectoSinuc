<?php
session_start();
session_destroy();
header('Location: '.$_SESSION['urlin'].'/index.php');