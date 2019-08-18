<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Company;
use Illuminate\Support\Facades\Validator;

class CompanyController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = Company::all();
        return $this->sendResponse($companies->toArray(), 'Companies retrieved successfully.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|string',
            'type' => 'required|string',
            'size' => 'required|integer|min:0',
            'address' => 'required|string',
            'logo' => 'nullable|string',
            'status' => 'nullable|integer|min:0',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $company = Company::create($input);
        return $this->sendResponse($company->toArray(), 'Company created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $company = Company::find($id);
        if (is_null($company)) {
            return $this->sendError('Company not found.');
        }

        return $this->sendResponse($company->toArray(), 'Company retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $input = $request->all();
        $company = Company::find($id);
        if (is_null($company)) {
            return $this->sendError('Company not found.');
        }
        $validator = Validator::make($input, [
            'name' => 'required|string',
            'type' => 'required|string',
            'size' => 'required|integer|min:0',
            'address' => 'required|string',
            'logo' => 'nullable|string',
            'status' => 'nullable|integer|min:0',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $company->fill($input)->update($input);
        return $this->sendResponse($company->toArray(), 'Company updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::find($id);
        if (is_null($company)) {
            return $this->sendError('Company not found.');
        }
        $company->delete();
        return $this->sendResponse($company->toArray(), 'Company deleted successfully.');
    }
}
