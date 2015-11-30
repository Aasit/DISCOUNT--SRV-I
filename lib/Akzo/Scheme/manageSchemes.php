<?php
/**
 *  Copyright 2014 Native5. All Rights Reserved
 *
 *  Licensed under Native5 License, Version 1.0 (the "License");
 *  You may not use this file except in compliance with the License.
 *
 *  You may obtain a copy of the License at
 *  http://www.native5.com/licenses/LICENSE-1.0
 *  or in the "license" file accompanying this file.
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 *  PHP version 5.3+
 *
 * @category  Scheme Execution
 * @package   None 
 * @author    Shamik Datta <shamik@native5.com>
 * @copyright 2012 Native5. All Rights Reserved
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$
 * @link      http://www.docs.native5.com
 */

require 'vendor/autoload.php';

// Switch to the application root
chdir(__DIR__.'/../../../');

// This will take awhile
set_time_limit(0);

// Need native5 app
\Native5\Application::init();

//$GLOBALS['logger']->info("Running manageSchemes...");
// The console application
$application = new \Symfony\Component\Console\Application('Discount Schemes Manager', '0.1');
$application->add(new \Akzo\Scheme\Command\ExecuteSchemeCommand());
$application->add(new \Akzo\Scheme\Command\GeneratePDFCommand());
$application->run();
