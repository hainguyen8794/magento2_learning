<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 05/07/2018
 * Time: 16:44
 */

namespace OpenTechiz\Blog\Block;

use  Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use OpenTechiz\Blog\Model\ResourceModel\Comment\Collection as CommentCollection;
class CommentList extends Template
{
    protected $_commentCollectionFactory;

	protected $_request;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \OpenTechiz\Blog\Model\ResourceModel\Post\CollectionFactory $commentCollectionFactory,
        \Magento\Framework\App\RequestInterface $request,
        array $data = []
    )
    {
        $this->_commentCollectionFactory = $commentCollectionFactory;
        $this->_request = $request;
        parent::__construct($context, $data);
    }
    public function getPostID(){
        return $this->_request->getParam('post_id',false);
    }
    public function getComments(){
        $post_id= $this->getPostID();
        if(!$this->hasData("cmt")){
            $comment = $this->_commentCollectionFactory
                ->create()
                ->addFilter('post_id',$post_id)
                ->addOrder(CommentInterface::CREATION_TIME,
					CommentCollection::SORT_ORDER_DESC
                		);
            $this->setData("cmt",$comment);
        }
        return $this->getData("cmt");
    }
}