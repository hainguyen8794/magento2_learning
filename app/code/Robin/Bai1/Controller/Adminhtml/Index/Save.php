<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Robin\Bai1\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Cms\Model\Page;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Robin\Bai1\Model\BannerFactory;
/**
 * Authorization level of a basic admin session
 */
class Save extends Action
{
    /**
     * Authorization level of a basic admin session
     */
    const ADMIN_RESOURCE = 'Robin_Bai1::save';
    protected $dataProcessor;
    protected $dataPersistor;
    protected $bannerFactory;
    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor,
        BannerFactory $bannerFactory
    )
    {
        $this->bannerFactory =$bannerFactory;
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            // Optimize data
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Banner::STATUS_ENABLED;
            }
            if (empty($data['id'])) {
                $data['id'] = null;
            }
            if (empty($data['images'])) {
                $data['images'] = null;
            }
            // Init model and load by ID if exists
            /*  $model = $this->_objectManager->create('Hainh\Banner\Model\Banner');*/
            $model = $this->bannerFactory->create();
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }
            // Validate data
            if (!$this->dataProcessor->validateRequireEntry($data)) {
                // Redirect to Edit page if has error
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
            }
            $data['image']= $data['images'][0]['name'];

            // Update model
            $model->setData($data);
            // Save data to database
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the image.'));
                $this->dataPersistor->clear('banner');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the image.'));
            }
            $this->dataPersistor->set('banner', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        // Redirect to List page
        return $resultRedirect->setPath('*/*/');
    }
}