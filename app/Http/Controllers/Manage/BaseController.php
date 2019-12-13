<?php

namespace App\Http\Controllers\Manage;

use App\Http\Controllers\Traits\CommonApiTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{

    use CommonApiTrait;

    const CTRL_MESSAGE_SUCCESS = "success";
    const CTRL_MESSAGE_INFO    = "info";
    const CTRL_MESSAGE_WARNING = "warning";
    const CTRL_MESSAGE_ERROR   = "error";
    const LIMIT                = 10;
    const SAVE_CLOSE           = 'save_close';

    /***
     * Append query url
     *
     * @param array $params
     * @param Request $request
     * @return array
     */
    public function appendQueryUrl(array $params, Request $request)
    {
        //TODO: Write helper
        return array_merge($request->input(), $params);
    }
}
