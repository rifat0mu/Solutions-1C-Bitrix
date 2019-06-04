<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$request = Bitrix\Main\Context::getCurrent()->getRequest();

if ( !empty( $request['tag'] ) ) {
    $arResult["CURRENT_PRESET"]["FIND"] = $request['tag'];

    foreach ( $arResult['PRESETS'] as $arKeyPresets => $arItemPresets ) {

        if ( $arItemPresets['ID'] == 'tmp_filter' ) {
            foreach ( $arItemPresets['FIELDS'] as $arKeyPresetFields => $arPresetFields ) {
                if ( $arPresetFields['ID'] == 'field_TAGS' ) {
                    $arPresetFields['VALUE'] = $request['tag'];

                    $arResult['PRESETS'][ $arKeyPresets ]['FIELDS'][ $arKeyPresetFields ]['VALUE'] = $request['tag'];
                }
            }
        }
    }

    foreach ( $arResult['CURRENT_PRESET']['FIELDS'] as $arKeyCurrentPreset => $arCurrentPresetField ) {
        if ( $arCurrentPresetField['ID'] == 'field_TAGS' ) {
            $arCurrentPresetField['VALUE'] = $request['tag'];
            $arResult['CURRENT_PRESET']['FIELDS'][ $arKeyCurrentPreset ]['VALUE'] = $request['tag'];
        }
    }

}