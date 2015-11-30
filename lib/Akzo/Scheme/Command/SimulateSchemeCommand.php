<?php
/**
 * Copyright © 2014 Native5
 * 
 * All Rights Reserved.  
 * Licensed under the Native5 License, Version 1.0 (the "License"); 
 * You may not use this file except in compliance with the License. 
 * You may obtain a copy of the License at
 *  
 *      http://www.native5.com/legal/npl-v1.html
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *  PHP version 5.3+
 *
 * @category  Schemes
 * @package   Akzo\Scheme
 * @author    Shamik Datta <shamik@native5.com>
 * @copyright 2014 Native5. All Rights Reserved 
 * @license   See attached LICENSE for details
 * @version   GIT: $gitid$ 
 * @link      http://www.docs.native5.com 
 */

namespace Akzo\Scheme\Command;

/**
 * SimulateSchemeCommand
 * 
 * @category  Schemes
 * @category  Command
 * @package   Akzo\Scheme\Command
 * @author    Shamik Datta <shamik@native5.com>
 * @copyright 2014 Native5. All Rights Reserved 
 * @license   See attached NOTICE.md for details
 * @version   Release: 1.0 
 * @link      http://www.docs.native5.com 
 * Created :  20-07-2014
 * Last Modified : Fri July 20 13:30:00 2014
 */

class SimulateSchemeCommand extends \Symfony\Component\Console\Command\Command
{
    const OPT_CODE = 'code';
    const OPT_CODE_SHORT = 'c';
    const OPT_OFFSET = 'offset';
    const OPT_OFFSET_SHORT = 'o';

    protected function configure() {
        $this
            ->setName('simulate')
            ->setDescription('Simulate a Discount Scheme using Target Data')
            ->addOption(
                self::OPT_CODE,
                self::OPT_CODE_SHORT,
                \Symfony\Component\Console\Input\InputOption::VALUE_REQUIRED,
                'Scheme Code'
            )
            ->addOption(
                self::OPT_OFFSET,
                self::OPT_OFFSET_SHORT,
                \Symfony\Component\Console\Input\InputOption::VALUE_OPTIONAL,
                'Dealer offset to start execution from',
                0
            )
        ;
    }

    protected function execute(
        \Symfony\Component\Console\Input\InputInterface $input,
        \Symfony\Component\Console\Output\OutputInterface $output
    )
    {
        // scheme code
        $code = $input->getOption(self::OPT_CODE);
        // dealer offset
        $offset = $input->getOption(self::OPT_OFFSET);
        
        // Start the simulation
        $result = \Akzo\Scheme\Service::getInstance()->initiateSimulation($code, $offset);

        // Check if the scheme has been executed for all dealers, otherwise replay this command with the new offset
        if (isset($result['moreDealersLeft']) && $result['moreDealersLeft']) {
            $cmd = 'php '.__DIR__.'/../manageSchemes.php simulate -c '.$code.' -o '.$result['moreDealersOffset'];

            // FIXME: Use Symfony Process instead of plain exec
            //$process = new \Symfony\Component\Process\Process(
                //$cmd
            //);
            //$process->start();

            if ($offset == 670) {
                if (function_exists('xdebug_start_trace')) {
                    xdebug_start_trace();
                }
                $cmd = 'php '.__DIR__.'/../manageSchemesX.php simulate -c '.$code.' -o '.$result['moreDealersOffset'];
            }

            $GLOBALS['logger']->info("Starting scheme for more dealers from offset ** {$result['moreDealersOffset']} **".PHP_EOL."Command: $cmd");

            $output = array(); $returnVal = 123;
            exec($cmd.' >/dev/null 2>&1 &', $output, $returnVal);

            $GLOBALS['logger']->info("Got output :".PHP_EOL.print_r($output, 1).PHP_EOL."Return val: ".$returnVal);
        }
    }

}

