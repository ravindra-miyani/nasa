<?php

class BaseController extends \Phalcon\Mvc\Controller
{

    protected $response;

    public function onConstruct()
    {
        $this->setResponse(Response::getInstance());
    }
   

    public function setResponse($response)
    {
        $this->response = $response;
    }

    public function sendSuccessResponse($array,$encode = true)
    {
        $this->response->sendResponse($array, 200, 'OK',$encode);
    }

    public function sendSaveResponse($array)
    {
        $this->response->sendResponse($array, 201, 'CREATED');
    }

    public function sendDeleteResponse($array)
    {
        $this->response->sendResponse($array, 204, 'NO CONTENT');
    }

    public function sendErrorResponse($array)
    {
        $this->response->sendResponse($array, 400, 'BAD REQUEST');
    }

    public function sendExceptionResponse($array)
    {
        $this->response->sendResponse($array, 512, 'EXCEPTION');
    }

    public function sendUnAuthorisedResponse($array)
    {
        $this->response->sendResponse($array, 401, 'UNAUTHORIZED');
    }

    public function sendForbiddenResponse($array)
    {
        $this->response->sendResponse($array, 403, 'FORBIDDEN');
    }

    public function sendNotFound($array)
    {
        $this->response->sendResponse($array, 404, 'NOT FOUND');
    }

    public function sendUnprocessableResponse($array)
    {
        $this->response->sendResponse($array, 422, 'UNPROCESSABLE ENTITY');
    }
    
    public function getRawData()
    {
        $rawPost = $this->request->getRawBody();
        $data = json_decode($rawPost);
        return $data;
    }

    protected static function translate()
    {
        return \Phalcon\DI::getDefault()->getShared('language');
    }
   
}