<?php

namespace App\Http\Controllers;

use App\Company;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function contact()
    {
        return view('contact');
    }

    public function storedContact(Request $request)
    {
        $inputs = $request->all();
        $validator = Validator::make($inputs, [
            'name'             => ['required', 'max:255'],
            'email'            => ['required', 'email', 'max:255'],
            'content'          => ['required', 'min:20', 'max:255'],
            'recaptcha_action' => ['required', 'string'],
            'recaptcha_token'  => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $client = new Client();
        $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret'   => config('site.secret_key_google'),
                'response' => $inputs['recaptcha_token'],
            ]
        ]);
        $result = json_decode($response->getBody()->getContents());
        if (!empty($result) && is_object($result)
            && $result->success
            && $result->action === $inputs['recaptcha_action']) {
            if ($result->score >= 0.5) {
                // TODO: Store contact or send mail contact here
                return redirect()->route('contact')->with(['message' => __('Thank you, we have received your contact content')]);
            } else {
                $validator->getMessageBag()->add('recaptcha', __('Recaptcha verify failed with score is '.$result->score));
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        $validator->getMessageBag()->add('recaptcha', __('Recaptcha verify failed'));
        return redirect()->back()->withErrors($validator)->withInput();
    }
}
