<?php

namespace App\Http\Controllers\Manage;

use App\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Manage\BaseController as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CompanyController extends BaseController
{

    public function __construct()
    {

        $this->middleware('permission:company-list');
        $this->middleware('permission:company-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:company-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:company-delete', ['only' => ['destroy']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, int $id = null)
    {
        return Validator::make($data, [
            'name'    => ['required', 'string', 'max:255', 'unique:companies,name,' . $id],
            'slug'    => ['required', 'string', 'max:255', 'unique:companies,slug,' . $id],
            'type'    => ['required', 'string'],
            'size'    => ['required', 'integer', 'min:0'],
            'address' => ['required', 'string'],
            'logo'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'status'  => ['required', 'integer', 'min:0', 'max:1']
        ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::withCount(['comments' => function($query) {
            return $query->groupBy('company_id');
        }])->paginate(self::LIMIT);
        return view('manage.companies.list')->with(['companies' => $companies]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('manage.companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputs = $request->all();
        $inputs['status'] = $request->input('status', 0);
        $inputs['slug'] = Str::slug($request->input('name'));
        $validator = $this->validator($inputs);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Upload logo image
        if ($request->hasFile('logo')) {
            $pathLogo = Storage::putFile('companies', $request->file('logo'));
            $inputs['logo'] = $pathLogo;
        }
        $company = Company::create($inputs);
        if (!empty($company['id'])) {
            if ($inputs['save'] === self::SAVE_CLOSE) {
                return redirect()->route('manage.companies.index')->with([
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
        $company = Company::findOrFail($id);
        return view('manage.companies.edit')->with(['company' => $company]);
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
        $inputs = $request->all();
        $inputs['status'] = $request->input('status', 0);
        $inputs['slug'] = Str::slug($request->input('name'));
        $validator = $this->validator($inputs, $id);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // Upload logo image
        if ($request->hasFile('logo')) {
            $pathLogo = Storage::putFile('companies', $request->file('logo'));
            $inputs['logo'] = $pathLogo;
        }
        $company = Company::findOrFail($id);
        $company->update($inputs);
        if (!empty($company['id'])) {
            if ($inputs['save'] === self::SAVE_CLOSE) {
                return redirect()->route('manage.companies.index')->with([
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
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('manage.companies.index')->with([
            'message' => __('Successfully!'),
            'status'  => self::CTRL_MESSAGE_SUCCESS,
        ]);
    }

}
