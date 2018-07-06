<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 06/07/2018
 * Time: 16:49
 */

namespace OpenTechiz\Blog\Controller\Adminhtml\Post;

use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use OpenTechiz\Blog\Model\ResourceModel\Post\CollectionFactory;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;
class MassEnable extends Action
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
        foreach ($collection as $item) {
            $item->setIsActive(true);
            $item->save();
        }
        $this->messageManager->addSuccess(__('A total of %1 record(s) have been enabled.', $collection->getSize()));

        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath('*/*/');
    }

}