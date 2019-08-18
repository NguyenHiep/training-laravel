<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $apiList = [
            'baseUrl'          => route('home'),
            'getCommentLatest' => route('api.comments.latest'),
            'getCompanyList'   => route('home') . '/company-list',
            'getCompanySearch' => route('home') . 'company-search',
        ];
        return view('home')->with('apiList', $apiList);
    }
}
