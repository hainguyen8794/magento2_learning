<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 06/07/2018
 * Time: 16:25
 */

namespace OpenTechiz\Blog\Controller\Adminhtml\Post;
use Magento\Backend\App\Action;


class Edit extends Action
{

    protected $_coreRegistry=null;
    protected $resultPageFactory;
    public function __construct(Action\Context $context,
                                \Magento\Framework\View\Result\PageFactory $resultPageFactory,
                                \Magento\Framework\Registry $registry)
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        parent::__construct($context);
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('OpenTechiz_Blog::save');
    }
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('OpenTechiz_blog::post')
            ->addBreadcrumb(__('Blog'), __('Blog'))
            ->addBreadcrumb(__('Manage Blog Posts'), __('Manage Blog Posts'));
        return $resultPage;
    }
    public function execute()
    {
        $id = $this->getRequest()->getParam('post_id');
        $model = $this->_objectManager->create('OpenTechiz\Blog\Model\Post');
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This post no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('blog_post', $model);
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Blog Post') : __('New Blog Post'),
            $id ? __('Edit Blog Post') : __('New Blog Post')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Blog Posts'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Blog Post'));
        return $resultPage;
    }

}