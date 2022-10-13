<?php

require 'class/Db.php';
require 'class/UserAuth.php';
require 'class/Route.php';

$route = new formController();

$route->handleForm();