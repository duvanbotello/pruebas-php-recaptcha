<?php

class Recaptcha
{

    private $v;

    function __construct($v)
    {
        $this->v = $v;
    }

    public function render()
    {
        global $smarty;
        $smarty->display('recaptcha.tpl');
    }

    public function requestAPI($response, $secret)
    {
        $url = "https://www.google.com/recaptcha/api/siteverify";
        $data = [
            "secret" => $secret,
            "response" => $response,
        ];
        $options = array(
            "http" => array(
                "header" => "Content-type: application/x-www-form-urlencoded\r\n",
                "method" => "POST",
                "content" => http_build_query($data),
            ),
        );
        $context = stream_context_create($options);
        $results = file_get_contents($url, false, $context);
        if ($results === false) {
            return false;
            exit;
        } else {
            return $results;
        }
    }

    /**
     * @return int
     */
    public function getV()
    {
        return $this->v;
    }

    /**
     * @param int $v
     */
    public function setV($v)
    {
        $this->v = $v;
    }


}
