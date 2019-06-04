<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

// $arResult
\Bitrix\Main\Page\Asset::getInstance()->addCss('/local/templates/bitrix24/components/bitrix/disk.file.view/.default/bx24_tags.css');

if ( CModule::IncludeModule('iblock') ) {
    $arSelect = Array("ID", "NAME", "PROPERTY_FILE_ID");
    $arFilter = Array(
        "IBLOCK_ID" => IBLOCK_DISK_TAGS_ID,
        "ACTIVE" => "Y",
        "PROPERTY_FILE_ID" => $arResult['FILE']['ID']
    );
    $rsTags = CIBlockElement::GetList(array(), $arFilter, false, array(),  $arSelect );
    while($tagFields = $rsTags->GetNext()) {
        $arResult['TAGS'][] = $tagFields;
    }
}

