<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 11/07/2018
 * Time: 17:04
 */

namespace OpenTechiz\Blog\Controller\Adminhtml\Comment;
use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;
use OpenTechiz\Blog\Model\CommentFactory;
use Magento\Backend\Model\Session;
use Magento\Framework\Registry;

class Edit extends Action
{
    protected $_coreRegistry = null;
    protected $resultPageFactory;
    protected $_commentFactory;
    public function __construct(Action\Context $context ,PageFactory $resultPageFactory,CommentFactory $commentFactory,
                                Session  $backendSession, Registry $registry)
    {
        $this->_coreRegistry =$registry;
        $this->_commentFactory = $commentFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->_backendSession = $backendSession;
        parent::__construct($context);
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('OpenTechiz_Blog::save_comment');
    }
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('OpenTechiz_Blog::comment')
            ->addBreadcrumb(__('Blog'), __('Blog'))
            ->addBreadcrumb(__('Manage Blog Comments'), __('Manage Blog Comments'));
        return $resultPage;
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('comment_id');
        $model = $this->_commentFactory->create();
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This comment no longer exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        $data = $this->_backendSession->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
        $this->_coreRegistry->register('blog_comment', $model);
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Blog Comment') : __('New Blog Comment'),
            $id ? __('Edit Blog Comment') : __('New Blog Comment')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Blog Comments'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getTitle() : __('New Blog Comment'));
        return $resultPage;
    }
}