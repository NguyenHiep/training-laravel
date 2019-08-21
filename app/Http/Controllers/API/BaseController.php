<?php

namespace App\Http\Controllers\API;

use Exception;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Request;

class BaseController extends Controller
{
    /***
     * success response method.
     *
     * @param array $result
     * @param string $message
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse(array $result, string $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }


    /***
     * return error response.
     *
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    /****
     * Call api external
     *
     * @param string $method
     * @param array $dataSend
     * @param string $url
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function callApiExternal(string $method, array $dataSend, string $url)
    {
        $result = [];
        $client = new Client();
        $request = new Request($method, $url);
        try {
            $response = $client->send($request, ['json' => $dataSend]);
            if (!empty($response)) {
                $result = $this->makeResponse($response);
            }
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
        }
        return $result;
    }

    /***
     * Get response api
     * @param $response
     * @return array
     */
    private function makeResponse($response)
    {
        $result = [
            'statusCode' => 404,
            'message'    => 'Not Found',
            'data'       => []
        ];
        try {
            $body = $response->getBody();
            if (!$body) {
                return $result;
            }
            $result['statusCode'] = $response->getStatusCode();
            $result['data'] = \GuzzleHttp\json_decode($body->getContents(), true);
            $result['message'] = $response->getReasonPhrase();
        } catch (Exception $e) {
            $result['message'] = $e->getMessage();
        }
        return $result;
    }
}
