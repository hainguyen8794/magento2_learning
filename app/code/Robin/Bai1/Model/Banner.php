<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 13/07/2018
 * Time: 12:36
 */

namespace Robin\Bai1\Model;


class Banner extends \Magento\Framework\Model\AbstractModel
{
 protected function _construct(){
     $this->_init('Robin\Bai1\Model\ResourceModel\Banner');
 }

}