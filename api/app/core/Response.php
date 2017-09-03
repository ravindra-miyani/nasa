<?php

class Response extends \Phalcon\Http\Response
{
    public static function getInstance()
    {
        return new Response();
    }

    public function sendResponse($array,$response_code = 200, $response_message = 'OK',$encode = true)
    {
        $this->setStatusCode($response_code,$response_message);
        /*if (true == $encode && is_array($array)) {
            array_walk_recursive($array, function(&$value, $key) {
                if(!mb_detect_encoding($value, 'utf-8', true)) {
                    $value = utf8_encode($value);
                }
            });
        }*/

        $this->setContentType('application/json');
        $this->setJsonContent(array('content' => $array));
        $this->send();
    }
}