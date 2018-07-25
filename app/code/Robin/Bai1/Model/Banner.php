<?php
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 13/07/2018
 * Time: 12:36
 */

namespace Robin\Bai1\Model;
use Robin\Bai1\Api\Data\BannerInterface;

class Banner extends \Magento\Framework\Model\AbstractModel implements BannerInterface
{
    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;
 protected function _construct(){
     $this->_init('Robin\Bai1\Model\ResourceModel\Banner');
 }
 function getID()
 {
   return $this->getData(self::BANNER_ID);
 }
 function getImage()
 {
     return $this->getData(self::IMAGE);
 }
 function getLink()
 {
    return $this->getData(self::LINK);
 }
 function setImage($image)
 {
     $this->setData(self::IMAGE,$image);
     return $this;
 }
 function setLink($link)
 {
     $this->setData(self::LINK,$link);
 }
}