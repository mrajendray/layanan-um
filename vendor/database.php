<?php
require_once 'config.php';
require_once 'library/rb-p533.php';

\R::setup('mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_MAME,DB_USER, DB_PASS);