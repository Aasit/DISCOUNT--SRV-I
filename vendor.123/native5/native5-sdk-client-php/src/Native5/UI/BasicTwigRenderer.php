<?php
/**
 *  Copyright 2014 Native5. All Rights Reserved
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
 * @category  UI
 * @package   Native5\UI
 * @author    Barada Sahu <barry@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */

namespace Native5\UI;

/**
 * BasicTwigRenderer
 *
 * @category  UI
 * @package   Native5\UI
 * @author    Shamik Datta <shamik@native5.com>
 * @copyright 2014 Native5. All Rights Reserved
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0
 * @link      http://www.docs.native5.com
 * Created :  10-09-2014
 * Last Modified : Wed Sept 10 19:11:53 2014
 */
class BasicTwigRenderer implements Renderer
{

    private $_template;

    private $_basePath;

    private $_twig;


    /**
     * __construct 
     * 
     * @param mixed $template to use
     * @param mixed $basePath to use
     *
     * @access public
     * @return void
     */
    public function __construct($template = null, $basePath = null)
    {
        $this->_template = $template;
        $this->_basePath = $basePath;
        $this->_configure();

    } //end __construct()


    /**
     * render UI on basis of incoming data 
     * 
     * @param mixed $data The data to use. 
     *
     * @access public
     * @return Template
     */
    public function render($data)
    {
        $in_data = array ('items' => $data);
        return $this->_twig->render($this->_template, $in_data);
    } //end render()


    /**
     * Set the template to be used for rendering 
     * 
     * @param mixed $template Template to use for rendering
     *
     * @access public
     * @return void
     */
    public function setTemplate($template)
    {
        $this->_template = $template;

    } //end setTemplate()


    /**
     * Get Rendering template 
     * 
     * @access public
     * @return Template
     */
    public function getTemplate()
    {
        return $this->_template;

    } //end getTemplate()


    /**
     * _configure 
     * 
     * @access private
     * @return void
     */
    private function _configure()
    {
        \Twig_Autoloader::register();

        $loader         =  new \Twig_Loader_Filesystem($this->_basePath);

        $cache_path = defined('CACHE_PATH') ? CACHE_PATH : 'cache';
        $this->_twig = new \Twig_Environment($loader,
            array(
                'debug'      => true,
                'autoreload' => false,
                'autoescape' => true,
                'cache'      => $cache_path,
            ));
        $this->_twig->getExtension('core')->setNumberFormat(2, '.', ',');
        //$this->_twig->addFilter(
            //'nonce',
            //new \Twig_Filter_Function(function($str) {
                //$app=$GLOBALS['app'];
                //if (strpos($str, '?') !== false) {
                    //return $str.'&rand_token='.$app->getSessionManager()->getActiveSession()->getAttribute('nonce');
                //}
                //return $str.'?rand_token='.$app->getSessionManager()->getActiveSession()->getAttribute('nonce');
        //})
        //);
        $this->_twig->addFilter(
            'truncate',
            new \Twig_Filter_Function('StringFilter::truncate')
        );
        $this->_twig->addFilter(
            'isToday',
            new \Twig_Filter_Function('DateFilter::isToday')
        );
        $this->_twig->addFilter(
            'isTomorrow',
            new \Twig_Filter_Function('DateFilter::isTomorrow')
        );
        $this->_twig->addFilter(
            'isLater',
            new \Twig_Filter_Function('DateFilter::isLater')
        );

    } //end _configure()


} //end class

