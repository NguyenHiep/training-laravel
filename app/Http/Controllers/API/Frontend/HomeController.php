<?php

namespace App\Http\Controllers\API\Frontend;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Company;
use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HomeController extends BaseController
{
    public function getListComment()
    {
        $commentsModel = new Comment();
        $comments = $commentsModel->getLatestComment();
        $comments->each(function ($item) {
            $item->company_url = route('company.detail', [ 'slug' => $item->slug]);
        });
        return $this->sendResponse($comments->toArray(), 'get comment successfully');
    }

    public function getListCompany(Request $request)
    {
        $textSearch = $request->input('q', '');
        if (!empty($textSearch)) { // Search and return
            return $this->searchCompany($textSearch);
        }
        $companyModel = new Company();
        $companies = $companyModel->getListCompany();
        $companies->each(function ($item) {
            $item->logo = Storage::url($item->logo);
            $item->company_url = route('company.detail', [ 'slug' => $item->slug]);
        });
        $resultData = [
            'list_company' => $companies->items(),
            'paginate'     => [
                'current_page' => $companies->currentPage(),
                'last_page'    => $companies->lastPage(),
                'per_page'     => $companies->perPage(),
                'total'        => $companies->total(),
            ]
        ];
        return $this->sendResponse($resultData, 'get company successfully');
    }

    private function searchCompany(string $textSearch)
    {
        $companyModel = new Company();
        $companies = $companyModel->searchCompany($textSearch);
        $companies->each(function ($item) use ($textSearch) {
            $item->logo = Storage::url($item->logo);
            $item->company_url = route('company.detail', [ 'slug' => $item->slug]);
        });
        return $this->sendResponse($companies->toArray(), 'get data search company successfully');
    }

    public function getCompanyDetail(string $slug)
    {
        $companyModel = new Company();
        $company = $companyModel->getCompanyDetail($slug);
        if (empty($company)) {
            return $this->sendError(__('Company not found'));
        }
        $company->logo = Storage::url($company->logo);
        return $this->sendResponse(collect($company)->toArray(), 'get detail company successfully');
    }

    public function getCommentByCompanyId(int $companyId)
    {
        $company = Company::find($companyId);
        if (empty($company)) {
            return $this->sendError(__('Company not found'));
        }
        $commentModel = new Comment();
        $comments = $commentModel->getCommentByCompanyId($companyId);
        $resultData = [
            'list_comment' => $comments->items(),
            'paginate'     => [
                'current_page' => $comments->currentPage(),
                'last_page'    => $comments->lastPage(),
                'per_page'     => $comments->perPage(),
                'total'        => $comments->total(),
            ]
        ];
        return $this->sendResponse($resultData, 'get list comment company successfully');
    }
}
