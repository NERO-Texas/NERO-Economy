<?php

if($_POST) {
	setcookie('chapter', $_POST['chapter'], time() + (86400 * 30));
} else {
    die();
}