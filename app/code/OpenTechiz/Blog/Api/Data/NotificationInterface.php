<?php
namespace OpenTechiz\Blog\Api\Data;
/**
 * Created by PhpStorm.
 * User: hainh
 * Date: 14/07/2018
 * Time: 00:51
 */
interface NotificationInterface
{
    const  NOTI_ID = 'noti_id';
    const  CONTENT  = 'conent';
    const POST_ID = 'post_id';
    const USER_ID = 'user_id';
    const COMMENT_ID = 'comment_id';
    const IS_VIEWED = 'is_viewed';
    const CREATION_TIME = 'creation_time';
    function getID();
    function getContent();
    function getPostID();
    function getUserID();
    function getCommentID();
    function isViewed();
    function getCreationTime();
    function setID($id);
    function setContent($content);
    function setPostID($postID);
    function setCommentID($commentID);
    function setIsViewed($isViewed);
    function setUserID($userID);
    function setCreationTime($creatTime);
 }