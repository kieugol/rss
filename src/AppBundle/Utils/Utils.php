<?php
namespace AppBundle\Utils;

trait Utils
{

    /**
     * [isUrl description]
     * @param  [type]  $strUrl   [description]
     * @return boolean  true|false
     */
    public function isUrl($strUrl)
    {
        return preg_match('/^(http|https)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/', $strUrl);
    }

    /**
     * Validate string is XML
     *
     * @param  string  $string  the string need to validate
     * @return boolean          true/false
     */
    public function isXML($string)
    {
        libxml_use_internal_errors(true);
        $isXml = \simplexml_load_string($string);
        return ($isXml ? true : false);
    }
}
