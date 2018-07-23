<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 02/07/2018
 * Time: 09:31
 */

namespace local\Meteorify\Observerexample\Model;


class Meteorify_Observerexample_Model_Observer
{
    public function example($observer){
        Mage::log('We just make an observer');
    }
}