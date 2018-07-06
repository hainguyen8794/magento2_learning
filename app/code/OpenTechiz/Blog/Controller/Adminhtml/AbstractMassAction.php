<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 06/07/2018
 * Time: 15:47
 */

namespace OpenTechiz\Blog\Controller\Adminhtml;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action;

class AbstractMassAction extends Action
{
    const ID_FIELD='entity_id';
    const REDIRECT_URL='*/*/';
    protected $collection ='Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection';
    protected $model = 'Magento\Framework\Model\AbstractModel';
    protected $status = true;
    public function execute()
    {
        $selected= $this->getRequest()->getParam('selected');
        $excluded=$this->getRequest()->getParam('excluded');
        try {
            if (isset($excluded)) {
                if (!empty($excluded)) {
                    $this->excludedSetStatus($excluded);
                } else {
                    $this->setStatusAll();
                }
            } elseif (!empty($selected)) {
                $this->selectedSetStatus($selected);
            } else {
                $this->messageManager->addError(__('Please select item(s).'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addError($e->getMessage());
        }
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setPath(static::REDIRECT_URL);
    }
    protected function setStatusAll(){
        $collection=$this->_objectManager->get($this->collection);
        $this->setStatus($collection);
    }
    protected function excludedSetStatus(array $excluded)
    {
        /** @var AbstractCollection $collection */
        $collection = $this->_objectManager->get($this->collection);
        $collection->addFieldToFilter(static::ID_FIELD, ['nin' => $excluded]);
        $this->setStatus($collection);
    }
    protected function selectedSetStatus(array $selected)
    {
        /** @var AbstractCollection $collection */
        $collection = $this->_objectManager->get($this->collection);
        $collection->addFieldToFilter(static::ID_FIELD, ['in' => $selected]);
        $this->setStatus($collection);
    }
    protected function setStatus(AbstractCollection $collection)
    {
        foreach ($collection->getAllIds() as $id) {
            /** @var \Magento\Framework\Model\AbstractModel $model */
            $model = $this->_objectManager->get($this->model);
            $model->load($id);
            $model->setIsActive($this->status);
            $model->save();
        }
    }

}