<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 11/07/2018
 * Time: 10:19
 */

namespace OpenTechiz\Blog\Block\Adminhtml;

use Magento\Backend\Block\Widget\Grid\Container;
class Comment extends  Container
{

    protected function _construct()
    {
        $this->_controller = "adminhtml_comment";
        $this->_blockGroup = "OpenTechiz_Blog";
        $this->_headerText = _('Manage Comment');
        parent::_construct();
        if ($this->_isAllowedAction('OpenTechiz_Blog::save_comment')){
            $this->buttonList->update('add','label',_('Add New Post'));
        }
        else {
            $this->buttonList->remove('add');
        }
    }
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}