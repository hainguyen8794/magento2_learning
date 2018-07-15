<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 06/07/2018
 * Time: 16:59
 */

namespace OpenTechiz\Blog\Controller\Adminhtml\Post;
use Magento\Backend\App\Action;
use Magento\TestFramework\ErrorLog\Logger;
use OpenTechiz\Blog\Model\Post;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
class Save extends Action
{
    const ADMIN_RESOURCE = 'OpenTechiz_Blog::post';
    protected $_postFactory;
    protected $_backendSession;
    public function __construct(Action\Context $context,
        \OpenTechiz\Blog\Model\PostFactory $postFactory,
        \Magento\Backend\Model\Session $backendSession)
    {
        $this->_backendSession = $backendSession;
        $this->_postFactory = $postFactory;
        parent::__construct($context);
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('OpenTechiz::save');
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->_objectManager->create('OpenTechiz\Blog\Model\Post');
            $id = $this->getRequest()->getParam('post_id');
            if ($id) {
                $model->load($id);
            }

          /*  $model->setData($data);*/
           /* $model->getUrl();
            $model->getTitle();
            $model->getContent();
            $model->isActive();*/
           $model->setUrlKey($data['url_key']);
           $model->setTitle($data['title']);
           $model->setContent($data['title']);
           $model->setIsActive($data['is_active']);
         /*  $model->save();*/
            $this->_eventManager->dispatch(
                'blog_post_prepare_save',
                ['post' => $model, 'request' => $this->getRequest()]
            );

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved this Post.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['post_id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the post.'));
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['post_id' => $this->getRequest()->getParam('post_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

}