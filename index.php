<?php

if( !session_id() ) session_start();

require_once 'api/init.php';

$app = new App;