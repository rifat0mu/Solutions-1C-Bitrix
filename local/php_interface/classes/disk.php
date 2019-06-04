<?php
namespace BX24\Disk;

class Tags {
    function GetLinkFilterTag( $tag ) {
        global $USER;
        $User_ID = $USER->GetID();
        if ( $User_ID ) {
            return "/company/personal/user/{$User_ID}/disk/path/?tag={$tag}";
        }
        return false;
    }
}