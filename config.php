<?php

define('ROOT_DIR', dirname(__FILE__));

$versionCaptcha = 2;
$scoreMin = 0.8;
$secretKeyCaptchaServer = '6LddGhgaAAAAAGk9gtxTWvYMsuQsdBBodajscNYp';
$secretKeyCaptchaClient = '6LddGhgaAAAAAH1Iw3blWDD2OgbrzBIRZhulgKz0';
$visibleCaptcha = true;

$cof_database = array(
    'host' => 'localhost',
    'username' => 'root',
    'password' => '',
    'db' => 'prueba',
    'port' => 3306,
    'charset' => 'utf8');

$db = new MysqliDb ($cof_database);

$smarty = new Smarty();
$smarty->setTemplateDir(ROOT_DIR.'/views/templates/');
$smarty->setCompileDir(ROOT_DIR.'/views/templates/compiles/');
