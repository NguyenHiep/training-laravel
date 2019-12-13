<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Storage;

class Helper
{
    /***
     * get content file
     *
     * @param string $path
     * @return mixed
     */
    public static function readFileContent(string $path)
    {
        return Storage::get($path);
    }

    /***
     * Replace white space in string
     *
     * @param string $strData
     * @return string|string[]
     */
    public static function replaceWhiteSpace(string $strData)
    {
        $strData = trim(preg_replace('/\s+/', ' ', $strData));
        $strData = str_replace("\n", '', $strData);
        return $strData;
    }
}
