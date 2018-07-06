<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 06/07/2018
 * Time: 16:37
 */

namespace OpenTechiz\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use OpenTechiz\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;
class MassDelete extends Action
{
    protected $filter;
    protected $collectionFactory;
    public function __construct(Context $context, Filter $filter, CollectionFactory $collectionFactory)
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();
        foreach ($collection as $item) {
            $item->delete();
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }
}