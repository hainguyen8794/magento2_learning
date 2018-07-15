<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 15/07/2018
 * Time: 20:30
 */

namespace OpenTechiz\Blog\Controller\Notification;
use \Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use OpenTechiz\Blog\Api\Data\NotificationInterface;
use OpenTechiz\Blog\Model\ResourceModel\Comment\Collection as CommentCollection;

class Load extends  Action
{
    protected $_resultJsonFactory;
    protected $_notificationCollectionFactory;
    protected $_customerSession;
    function __construct(Context $context,
                         \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
                         \OpenTechiz\Blog\Model\ResourceModel\Notification\CollectionFactory $notificationCollectionFactory,
                         \Magento\Customer\Model\Session $customerSession)
    {
        $this->_resultFactory = $context->getResultFactory();
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_notificationCollectionFactory = $notificationCollectionFactory;
        $this->_customerSession = $customerSession;
        parent::__construct($context);
    }
    public function execute()
    {
        // TODO: Implement execute() method.
        if(!$this->_customerSession->isLoggedIn()) return false;
        $postData = (array) $this->getRequest()->getPostValue();
        $page = 1;
        if(isset($postData['page']))
        {
            $page = $postData['page'];
        }

        $user_id = $this->_customerSession->getCustomer()->getId();
        $jsonResultResponse = $this->_resultJsonFactory->create();

        $comments = $this->_notificationCollectionFactory
            ->create()
            ->addFieldToFilter('is_viewed', 0)
            ->addFieldToFilter('user_id', $user_id)
            ->toArray();
        $commentsTotal = $this->_notificationCollectionFactory
            ->create()
            ->addFieldToFilter('user_id', $user_id)
            ->setPageSize(5)
            ->setCurPage($page)
            ->addOrder(
                NotificationInterface::CREATION_TIME,
                CommentCollection::SORT_ORDER_DESC
            )->toArray();

        if($commentsTotal['totalRecords']==0) return false;
        if(ceil($commentsTotal['totalRecords']/5)<$page) return $jsonResultResponse->setData('end');;
        $comments['items'] = $commentsTotal['items'];
        $jsonResultResponse->setData($comments);
        return $jsonResultResponse;
    }
}