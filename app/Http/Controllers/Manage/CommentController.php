<?php

namespace App\Http\Controllers\Manage;

use App\Comment;
use App\Company;
use App\Http\Controllers\Manage\BaseController as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends BaseController
{

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @param  int|null  $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, int $id = null)
    {
        return Validator::make($data, [
            'company_id' => ['required', 'integer'],
            'reviewer'   => ['required', 'string'],
            'position'   => ['required', 'string'],
            'content'    => ['required', 'string'],
            'star'       => ['required', 'integer', 'min:1', 'max:5'],
            'status'     => ['required', 'integer', 'min:0', 'max:1']
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companyId = request()->input('company_id', 0);
        if (!empty($companyId)) {
            $comments = Comment::with('company')->orderBy('id', 'DESC')->whereCompanyId($companyId)->paginate(self::LIMIT);
        } else {
            $comments = Comment::with('company')->orderBy('id', 'DESC')->paginate(self::LIMIT);
        }
        return view('manage.comments.list')->with(['comments' => $comments, 'companyId' => $companyId]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyId = request()->input('company_id', 0);
        $company = Company::findOrFail($companyId);
        return view('manage.comments.create')->with(['company' => $company]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->input();
        $inputs['status'] = $request->input('status', 0);
        $validator = $this->validator($inputs);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $comment = Comment::create($inputs);
        if (!empty($comment['id'])) {
            if ($inputs['save'] === self::SAVE_CLOSE) {
                return redirect()->route('manage.comments.index', ['company_id' => $comment['company_id']])->with([
                    'message' => __('Successfully!'),
                    'status'  => self::CTRL_MESSAGE_SUCCESS,
                ]);
            }
            return redirect()->back()->with([
                'message' => __('Successfully!'),
                'status'  => self::CTRL_MESSAGE_SUCCESS,
            ]);
        }
        return redirect()->back()->withInput($inputs)->with([
            'message' => __('Wrong!'),
            'status'  => self::CTRL_MESSAGE_ERROR
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $comment = Comment::with('company')->findOrFail($id);
        return view('manage.comments.edit')->with(['comment' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $inputs = $request->input();
        $inputs['status'] = $request->input('status', 0);
        $validator = $this->validator($inputs, $id);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $comment = Comment::findOrFail($id);
        $comment->update($inputs);
        if (!empty($comment['id'])) {
            if ($inputs['save'] === self::SAVE_CLOSE) {
                return redirect()->route('manage.comments.index')->with([
                    'message' => __('Successfully!'),
                    'status'  => self::CTRL_MESSAGE_SUCCESS,
                ]);
            }
            return redirect()->back()->with([
                'message' => __('Successfully!'),
                'status'  => self::CTRL_MESSAGE_SUCCESS,
            ]);
        }
        return redirect()->back()->withInput($inputs)->with([
            'message' => __('Wrong!'),
            'status'  => self::CTRL_MESSAGE_ERROR
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        $comment->delete();
        return redirect()->back()->with([
            'message' => __('Successfully!'),
            'status'  => self::CTRL_MESSAGE_SUCCESS,
        ]);
    }
}
