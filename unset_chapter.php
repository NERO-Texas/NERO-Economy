<?php
setcookie('chapter', '', time() - 300);
header('Location: index.php');