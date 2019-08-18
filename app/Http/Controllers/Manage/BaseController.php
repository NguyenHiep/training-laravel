<?php

namespace App\Http\Controllers\Manage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    const CTRL_MESSAGE_SUCCESS = "success";
    const CTRL_MESSAGE_INFO    = "info";
    const CTRL_MESSAGE_WARNING = "warning";
    const CTRL_MESSAGE_ERROR   = "error";
    const LIMIT = 10;
}
