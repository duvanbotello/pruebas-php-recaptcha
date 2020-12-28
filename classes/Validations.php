<?php

class Validations
{
    function validRequired($valor)
    {
        if (trim($valor) == '') {
            return false;
        } else {
            return true;
        }
    }

    function validateInteger($valor, $opciones = null)
    {
        if (filter_var($valor, FILTER_VALIDATE_INT, $opciones) === FALSE) {
            return false;
        } else {
            return true;
        }
    }

    function validateEmail($valor)
    {
        if (filter_var($valor, FILTER_VALIDATE_EMAIL) === FALSE) {
            return false;
        } else {
            return true;
        }
    }

}