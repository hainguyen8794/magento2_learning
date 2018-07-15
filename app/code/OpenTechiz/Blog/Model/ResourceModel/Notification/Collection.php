<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 15/07/2018
 * Time: 21:06
 */

namespace OpenTechiz\Blog\Model\ResourceModel\Notification;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'noti_id';
    protected function _construct()
    {
        $this->_init('OpenTechiz\Blog\Model\Notification', 'OpenTechiz\Blog\Model\ResourceModel\Notification');
    }
}