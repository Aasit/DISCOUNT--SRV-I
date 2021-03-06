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
 * @category  API 
 * @package   Native5\Core\<package>
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Native5\Core\Feeds;

/**
 * Class for representing a news article from a feed. 
 * 
 * @category  Feeds 
 * @package   Native5\Core
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created : 27-11-2012
 * Last Modified : Fri Dec 21 09:11:53 2012
 */
class NewsArticle
{

    public  $_id, $title, $description, $pubDate, $link;

    private $images, $videos; 

    public function __construct() {
        $this->images = array();
        $this->videos = array();
    }

    public function addImage($article_image) {
        $this->images[$article_image->getResolution()]=$article_image;
    }

    public function addVideo($video) {
        $this->videos[]=$video;
    }

    public function getImage($res) {
        if (!$res) {
            $res = 'HIGH';
        }
        if(array_key_exists($res, $this->images))
            return $this->images[$res];
        return null;
    }

    public function getVideo() {
        return $this->videos[0];
    }
}
