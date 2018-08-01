<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 13/07/2018
 * Time: 14:21
 */

namespace Robin\Bai1\Model\ResourceModel;


class Banner extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
   protected function _construct()
   {
       $this->_init('banner','id');
   }

   protected function _afterSave(\Magento\Framework\Model\AbstractModel $object)
   {
     $image = $object->getData('image');
     if($image != null){
         $imageUpload = \Magento\Framework\App\ObjectManager::getInstance()->get('Robin\Bai1\BannerImageUpload');
         $imageUpload->moveFileFromTmp($image);
     }
     return $this;
   }
}