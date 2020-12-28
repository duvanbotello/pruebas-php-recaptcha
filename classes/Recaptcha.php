<?php

class Recaptcha{

    private $v = 3;

    public function render(){
        global $smarty;

        $smarty->display('recaptcha.tpl');
    }

}
