<?php

namespace App\Http\Controllers;

use App\Company;
use Illuminate\Http\Request;

class PageController extends Controller
{
    const LIST_LANGUAGE = ['vi', 'en', 'ja'];

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
            'getCompanyList'   => route('api.companies.list')
        ];
        return view('home')->with('apiList', $apiList);
    }

    public function company($slug)
    {
        $company = Company::where('slug', $slug)->first(['id', 'slug', 'name']);
        if (empty($company)) {
            abort(404);
        }
        $apiList = [
            'baseUrl'            => route('home'),
            'getCompanyDetail'   => route('api.companies.detail', ['slug' => $company->slug]),
            'getCommentDetail'   => route('api.companies.comment.detail', ['id' => $company->id]),
            'storedComment'      => route('api.comments.store'),
            'storedCommentReply' => route('api.comments.store.reply'),
        ];
        return view('company')->with(['apiList' => $apiList, 'company' => $company]);
    }

    public function getPageTnc()
    {
        return view('tnc');
    }

    public function getPageFqa()
    {
        return view('fqa');
    }

    public function handleLanguage(Request $request, $locale)
    {
        $result = [
            'success' => false,
            'message' => ''
        ];
        if (in_array($locale, self::LIST_LANGUAGE)) {
            $request->session()->put('locale', $locale);
            $result = [
                'success' => true,
                'message' => __('Action complete')
            ];
        }
        return response()->json($result);
    }
}
