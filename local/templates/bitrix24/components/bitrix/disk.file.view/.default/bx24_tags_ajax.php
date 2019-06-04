<?php

define('STOP_STATISTICS', true);
define('BX_SECURITY_SHOW_MESSAGE', true);
define("NOT_CHECK_PERMISSIONS", true);

$siteId = isset($_REQUEST['SITE_ID']) && is_string($_REQUEST['SITE_ID'])? $_REQUEST['SITE_ID'] : '';
$siteId = substr(preg_replace('/[^a-z0-9_]/i', '', $siteId), 0, 2);
if(!empty($siteId) && is_string($siteId))
{
    define('SITE_ID', $siteId);
}

require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/prolog_before.php');

if (!CModule::IncludeModule('disk') || !\Bitrix\Main\Application::getInstance()->getContext()->getRequest()->getQuery('action'))
{
    return;
}

$action = \Bitrix\Main\Application::getInstance()->getContext()->getRequest()->getQuery('action');
if ( $action == 'addTags' ) {

    $request = Bitrix\Main\Context::getCurrent()->getRequest();

    if (isset($request['tag_value']))
        $tag_value = $request['tag_value'];

    if (isset($request['file_id']))
        $file_id = $request['file_id'];

    // $request->getPost('test')
    $response['status'] = 'error';

    if ( $tag_value && $file_id ) {
        $response['file_id'] = $file_id;
        $response['tag_value'] = $tag_value;

        if ( CModule::IncludeModule('iblock')  ) {

            $arFields = array(
                "ACTIVE" => "Y",
                "IBLOCK_ID" => IBLOCK_DISK_TAGS_ID,
                "NAME" => $tag_value,
                "PROPERTY_VALUES" => array("FILE_ID" => $file_id )
            );

            $oElement = new CIBlockElement();
            $idElement = $oElement->Add($arFields, false, false, true);
            if ( $idElement ) {
                $response['tag_id'] = $idElement;
                $response['status'] = 'success';
            }

            $response['status'] = 'success';
        }
    }

    echo json_encode($response);
}

if ( $action == 'trashTag' ) {

    $request = Bitrix\Main\Context::getCurrent()->getRequest();

    if (isset($request['tag_id']))
        $tag_id = $request['tag_id'];

    $response['status'] = 'error';

    if ( $tag_id ) {
        $response['tag_id'] = $tag_id;
        if ( CModule::IncludeModule('iblock')  ) {
            if(CIBlockElement::Delete($tag_id)) {
                $response['status'] = 'success';
            }
        }
    }

    echo json_encode($response);
}