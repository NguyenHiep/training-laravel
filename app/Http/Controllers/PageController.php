<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PageController extends Controller
{
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
