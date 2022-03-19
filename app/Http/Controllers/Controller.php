<?php

namespace App\Http\Controllers;

use App\Constants\TranslationCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class Controller
 *
 * All controllers should extend this controller
 *
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{

    /** @var bool */
    private $isError = false;

    /** @var array */
    private $errorMessages = [];

    /** @var bool */
    private $userFault = false;

    /** @var null */
    private $result = null;

    /** @var array */
    private $pagination = [];

    /** @var bool */
    private $refreshToken = false;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * Success response
     *
     * @param string|array|null $data
     *
     * @return JsonResponse
     */
    protected function successResponse($data = null)
    {
        if ($data !== null) {
            $this->result = $data;
        }

        return $this->buildResponse();
    }

    /**
     * Build the response.
     *
     * @return JsonResponse
     */
    private function buildResponse()
    {
        if ($this->isError) {
            $response = [
                'isError'       => $this->isError,
                'userFault'     => $this->userFault,
                'errorMessages' => $this->errorMessages
            ];
        } else {
            $response = [
                'isError' => $this->isError
            ];

            if ($this->result !== null) {
                $response['result'] = $this->result;
            }

            if (count($this->pagination) > 0) {
                $response['pagination'] = $this->pagination;
            }
        }

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * Return user fault response.
     *
     * @param array $errorMessages
     *
     * @return JsonResponse
     */
    protected function userErrorResponse(array $errorMessages)
    {
        $this->isError       = true;
        $this->userFault     = true;
        $this->errorMessages = $errorMessages;

        return $this->buildResponse();
    }

    /**
     * Return application error response.
     *
     * @return JsonResponse
     */
    protected function errorResponse()
    {
        $this->isError       = true;
        $this->errorMessages = ['application' => TranslationCode::ERROR_APPLICATION];

        return $this->buildResponse();
    }
}
