<?php

namespace App\Http\Controllers\Manage;

use App\Company;
use App\Events\CrawlingCompany;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Manage\BaseController as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Symfony\Component\DomCrawler\Crawler;

class CompanyController extends BaseController
{

    const CRAWL_DIR = 'crawling_company';
    const CRAWL_FILE_NAME = 'reviewcongty_%s.txt';

    protected $listCompany;
    protected $contentData;

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
            'size'    => ['required', 'string'],
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


    public function crawling()
    {
        return view('manage.companies.crawling');

    }

    public function previewCrawling(Request $request)
    {
        $input = $request->input();
        $validator = Validator::make($input, [
            'url_crawling' => 'required|url'
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $client = new Client();
        $response = $client->request('GET', $request->input('url_crawling'), [
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36',
            ]
        ]);
        $contentData = $response->getBody()->getContents();
        // TODO: Push to queues

        $contentData = $this->handleCrawling($contentData);
        if (empty($contentData)) {
            return $this->sendError('Something wrong!');
        }
        return $this->sendResponse([$contentData], 'Successfully');
    }

    private function handleCrawling($strContent, $baseUrl = '')
    {
        $crawler    = new Crawler($strContent);
        $nodeCompanies = $crawler->filter('div.company-item')->each(function (Crawler $node) {
            return $node;
        });
        $listCompany = [];

        if (empty($nodeCompanies) || !is_array($nodeCompanies)) {
            return $listCompany;
        }

        foreach ($nodeCompanies as $nodeCompany) {
            $nodeLogo    = $nodeCompany->filter('figure.company-info__logo > img')->attr('src');
            $nodeName    = $nodeCompany->filter('.company-info__detail h2 > a');
            $nodeAddress = $nodeCompany->filter('.company-info__detail .company-info__location');
            $nodeOther   = $nodeCompany->filter('.company-info__detail .company-info__other span')->each(function (Crawler $node) {
                if (!empty(trim($node->text()))) {
                    return $node;
                }
            });
            $nodeOther = array_filter($nodeOther); // fill element null
            $nodeOther = array_values($nodeOther); // Reset key array
            $type = $nodeOther[0]->text() ?? 1;
            if (!empty($type) && strtolower(trim($type)) === 'dịch vụ') {
                $type = 2;
            } else {
                $type = 1;
            }
            $size = $nodeOther[1]->text() ?? '0-50';
            event(new CrawlingCompany([
                'logo'    => $baseUrl . $nodeLogo,
                'name'    => trim($nodeName->text()),
                'slug'    => Str::slug(trim($nodeName->text())),
                'address' => $this->replaceWhiteSpace($nodeAddress->text()),
                'type'    => $type,
                'size'    => trim($size)
            ]));
            /*$this->listCompany[] = [
                'logo'    => $baseUrl . $nodeLogo,
                'name'    => trim($nodeName->text()),
                'slug'    => Str::slug(trim($nodeName->text())),
                'address' => $this->replaceWhiteSpace($nodeAddress->text()),
                'type'    => $type,
                'size'    => trim($size)
            ];*/
        }
        return true;
    }

    private function replaceWhiteSpace(string $strData)
    {
        $strData = trim(preg_replace('/\s+/', ' ', $strData));
        $strData = str_replace("\n", '', $strData);
        return $strData;
    }

    public function testCrawlingData()
    {
        $baseUrl = "https://reviewcongty.com";
        $url     = $baseUrl . "/?tab=latest&page=";
        $client  = new Client();
        for ($i = 1; $i <= 3; $i++) {
            $response = $client->request('GET', $url . $i, [
                'headers' => [
                    'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36',
                ]
            ]);
            // TODO: Show data leech
            $htmlContent = $response->getBody()->getContents();
            preg_match_all('/<div class="tabs-section">(.*?)<\/div>/s', $htmlContent, $match);
            $this->contentData[] = $match[1];
        }

        if (!empty($this->contentData)) {
            foreach ($this->contentData as $strContent) {
                $this->handleCrawling($strContent, $baseUrl);
            }
        }


        /*if (!empty($this->listCompany) && is_array($this->listCompany)) {
            $resultJson = json_encode($this->listCompany, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
            Storage::put('crawling/test5.json', $resultJson);
        }*/
    }

}
