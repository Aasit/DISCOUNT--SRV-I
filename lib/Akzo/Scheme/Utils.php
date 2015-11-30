<?php
namespace Akzo\Scheme;

class Utils
{
    public static function genUniqFloat()
    {
        // Sleep for at least 1 microsecs
        usleep(1);
        return microtime(true);
    }

    public static function condenseProductsPid($products) {
        $condensedPid = '';
        foreach ($products as $idx=>$product) {
            if ($product->excluded === true) {
                $condensedPid .= '-'.$product->pid;
            } else {
                $condensedPid .= '+'.$product->pid;
            }
        }

        return $condensedPid;
    }
}


