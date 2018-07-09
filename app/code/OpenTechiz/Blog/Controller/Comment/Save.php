<?php
///*/*/**
// * Created by PhpStorm.
// * User: hainh
// * Date: 05/07/2018
// * Time: 23:36
// */
//
//namespace OpenTechiz\Blog\Controller\Comment;
//
//use Magento\Framework\App\Action\Action;
//use Magento\Framework\App\Action\Context;
//use Magento\Framework\Controller\ResultFactory;
//class Save extends Action
//{
//    protected $_resultPageFactory;
//    function __construct(Context $context,\OpenTechiz\Blog\Model\Post $post)
//    {
//        $this->_resultPageFactory = $context->getResultFactory();
//        $this->_post =$post;
//        parent::__construct($context);
//
//    }
//    public function execute()
//    {
//
//        $resultRedirect = $this->_resultPageFactory->create(ResultFactory::TYPE_REDIRECT);
//        $postData = (array) $this->getRequest()->getPost();
//        if(!empty($postData)){
//            $author = $postData['author'];
//            $content = $postData['content'];
//            $post_id = $postData['post_id'];
//            $this->_post->load($post_id);
//            $urlPost = $this->_post->getUrl();
//            $comment = $this->_objectManager->create('OpenTechiz\Blog\Model\Comment');
//            $comment->setAuthor($author);
//            $comment->setContent($content);
//            $comment->setPostID($post_id);
//            $comment->save();
//            // Display the succes form validation message
//            $this->messageManager->addSuccessMessage('Comment added succesfully!');
//            if($urlPost)
//            {
//                $resultRedirect->setUrl($urlPost);
//            } else $resultRedirect->setUrl('/magento2.2/blog/');
//            return $resultRedirect;
//        }
//        $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE;
//        $transport = $this->_transportBuilder
//            ->setTemplateIdentifier($this->scopeConfig->getValue'blog/general/template',$storeScope)
//            ->setTemplateOptions(
//                'area'=>\Magento\Backend\App\Area\FrontNameResolver::AREA_CODE,
//
//    )
//
//        $resultRedirect->setUrl('/magento2.2/blog/');
//        return $resultRedirect;
//    }
//
//}
//*/

namespace OpenTechiz\Blog\Controller\Comment;
use \Magento\Framework\App\Action\Action;
class Save extends Action
{
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    protected $_resultJsonFactory;
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $_sendEmail;
    function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \OpenTechiz\Blog\Helper\SendEmail $sendEmail,
        \Magento\Framework\App\Action\Context $context
    )
    {
        $this->_resultFactory = $context->getResultFactory();
        $this->_resultJsonFactory = $resultJsonFactory;
        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_sendEmail = $sendEmail;
        parent::__construct($context);
    }
    public function execute()
    {
        $error = false;
        $message = '';
        $postData = (array) $this->getRequest()->getPostValue();
        if(!$postData)
        {
            $error = true;
            $message = "Your submission is not valid. Please try again!";
        }
        $this->_inlineTranslation->suspend();
        $postObject = new \Magento\Framework\DataObject();
        $postObject->setData($postData);
        // validate data
        if(!\Zend_Validate::is(trim($postData['author']), 'NotEmpty'))
        {
            $error = true;
            $message = "Name can not be empty!";
        }
        $jsonResultResponse = $this->_resultJsonFactory->create();
        if(!$error)
        {
            // save data to database
            $author   = $postData['author'];
            $content    = $postData['content'];
            $post_id = $postData['post_id'];
            $email = $postData['email'];
            $comment = $this->_objectManager->create('OpenTechiz\Blog\Model\Comment');
            $comment->setAuthor($author);
            $comment->setContent($content);
            $comment->setPostID($post_id);
            $comment->setEmail($email);
            $comment->save();
            $jsonResultResponse->setData([
                'result' => 'success',
                'message' => 'Thank you for your submission. Our Admins will review and approve shortly'
            ]);
            // send email to user
            $this->_sendEmail->approvalEmail($email, $author);
        } else {
            $jsonResultResponse->setData([
                'result' => 'error',
                'message' => $message
            ]);
        }
        return $jsonResultResponse;
    }
}