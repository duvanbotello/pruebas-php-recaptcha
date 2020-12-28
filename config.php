<?php

define('ROOT_DIR', dirname(__FILE__));

$smarty = new Smarty();
$smarty->setTemplateDir(ROOT_DIR.'/views/templates/');
$smarty->setCompileDir(ROOT_DIR.'/views/templates/compiles/');
