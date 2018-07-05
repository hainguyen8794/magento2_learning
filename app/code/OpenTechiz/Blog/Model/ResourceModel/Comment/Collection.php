<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 05/07/2018
 * Time: 16:55
 */

namespace OpenTechiz\Blog\Model\ResourceModel\Comment;


class Collection extends  \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName ='comment_id';
    protected  function _construct()
    {
        $this->_init('OpenTechiz\Blog\Model\Comment','OpenTechiz\Blog\Model\ResourceModel\Comment');
    }

}