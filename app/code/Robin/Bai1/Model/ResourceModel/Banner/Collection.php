<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 13/07/2018
 * Time: 14:24
 */

namespace Robin\Bai1\Model\ResourceModel\Banner;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
       $this->_init('Robin\Bai1\Model\Banner','Robin\Bai1\Model\ResourceModel\Banner');
    }
}