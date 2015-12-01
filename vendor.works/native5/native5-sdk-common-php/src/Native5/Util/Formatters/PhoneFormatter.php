<?php
/**
 *  Copyright 2012 Native5. All Rights Reserved
 *
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *	You may not use this file except in compliance with the License.
 *
 *	Unless required by applicable law or agreed to in writing, software
 *	distributed under the License is distributed on an "AS IS" BASIS,
 *	WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *	See the License for the specific language governing permissions and
 *	limitations under the License.
 *  PHP version 5.3+
 *
 * @category  Formatters
 * @package   Native5\Util\Formatter
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Util\Formatters;

/**
 * Formatter
 * 
 * @category  Formatter 
 * @package   Native5\Util\Formatter
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class PhoneFormatter implements Formatter 
{

    /**
     * format 
     * 
     * @param mixed $number The phone number to format 
     * @param mixed $format The format to output in
     *
     * @access public
     * @return void
     */
    public static function format($number, $format=Formatter::PHONE_E164) {
        $formattedNumber = '';
        $regex = "/[^0-9]/";
        $number = preg_replace($regex, "", $number);

        if(strlen($number) > 13)
            throw new \Exception('Unsupported Format for number '.$number);

        if(strlen($number) >10)
            $countryCode = "";
        else
            $countryCode = "91";
        $formattedNumber = "+$countryCode$number";
        return $formattedNumber;
    }
}

