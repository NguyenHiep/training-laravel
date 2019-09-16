<?php

namespace App\Http\Controllers\API\Frontend;

use App\CommentReply;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Company;
use App\Comment;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        //
        if ($comments->count() > 0) {
            foreach ($comments as $comment) {
                $resultComment = $commentModel->getCommentReply($comment->id);
                $comment->childrens = [
                    'list_comment' => $resultComment->items(),
                    'paginate'     => [
                        'current_page' => $resultComment->currentPage(),
                        'last_page'    => $resultComment->lastPage(),
                        'per_page'     => $resultComment->perPage(),
                        'total'        => $resultComment->total()
                    ]
                ];
            }
        }
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

    public function storedComment(Request $request)
    {
        if (!$request->isMethod('post')) {
            return $this->sendError('Method not allow');
        }
        $validator = Validator::make($request->all(), [
            'g_recaptcha_response' => 'required|string',
            'content'              => 'required|min:10',
            'company_id'           => 'required|integer|gt:0|exists:companies,id',
            'reviewer'             => 'nullable|string|max:255',
            'position'             => 'nullable|string|max:255',
            'star'                 => 'required|in:1,2,3,4,5'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if ($this->verifyGoogleRecapcha($request->input('g_recaptcha_response'))) {
            $comment = new Comment();
            $comment->fill($request->all());
            $comment->save();
            return $this->sendResponse($comment->toArray(), 'Stored successfully');
        }
        return $this->sendError('Verify failed');
    }

    public function storedCommentReply(Request $request)
    {
        if (!$request->isMethod('post')) {
            return $this->sendError('Method not allow');
        }
        $validator = Validator::make($request->all(), [
            'g_recaptcha_response' => 'required|string',
            'content'              => 'required|min:10',
            'comment_id'           => 'required|integer|gt:0|exists:comments,id',
            'reviewer'             => 'nullable|string|max:255',
            'reaction'             => 'required|string|in:LIKE,HATE,DELETE'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($this->verifyGoogleRecapcha($request->input('g_recaptcha_response'))) {
            $comment = new CommentReply();
            $comment->fill($request->all());
            $comment->save();
            return $this->sendResponse($comment->toArray(), 'Stored successfully');
        }
        return $this->sendError('Verify failed');
    }

    public function getCommentReply(int $commentId)
    {
        $comment = Comment::find($commentId);
        if (empty($comment)) {
            return $this->sendError(__('Comment not found'));
        }
        $commentModel = new Comment();
        $commentsReply = $commentModel->getCommentReply($commentId);
        $resultData = [
            'list_comment' => $commentsReply->items(),
            'paginate'     => [
                'current_page' => $commentsReply->currentPage(),
                'last_page'    => $commentsReply->lastPage(),
                'per_page'     => $commentsReply->perPage(),
                'total'        => $commentsReply->total(),
            ]
        ];
        return $this->sendResponse($resultData, 'get list comment reply successfully');
    }

    /****
     * @param string $responseGoogle
     * @return bool
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function verifyGoogleRecapcha(string $responseGoogle)
    {
        $dataSend = [
            'response' => $responseGoogle,
            'secret'   => config('site.secret_key_google'),
        ];
        try {
            //@link: https://developers.google.com/recaptcha/docs/verify
            $client = new Client();
            $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
                'query' => $dataSend
            ]);
            $resultData = json_decode($response->getBody());
            $isVerifySuccess = $resultData->success ?? false;
        } catch (\Exception $e) {
            report($e);
            $isVerifySuccess = false;
        }

        return $isVerifySuccess;
    }
}
