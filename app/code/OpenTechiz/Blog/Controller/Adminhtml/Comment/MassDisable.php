<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 11/07/2018
 * Time: 16:22
 */

namespace OpenTechiz\Blog\Controller\Adminhtml\Comment;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use OpenTechiz\Blog\Model\ResourceModel\Comment\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;
class MassDisable extends Action
{
    protected $filter;
    protected $collectionFactory;
    public function __construct(Action\Context $context ,Filter $filter , CollectionFactory $collectionFactory)
    {
        $this->filter= $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        foreach ($collection as $item) {
            $item->setIsActive(2);
            $item->save();
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been disabled.', $collection->getSize()));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }

}