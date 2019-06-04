<?php
use \Bitrix\Main\Localization\Loc;

if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

Loc::loadMessages(__DIR__ . '/template.php');
?>

<div class="bx24-disk-tags-add" id="bx24-disk-tags-add" style="">
    <form action="<?php echo POST_FORM_ACTION_URI ?>" method="post" name="bx24-disk-tagsform-add" id="bx24-disk-tagsform-add" enctype="multipart/form-data">
        <input type="hidden" id="bx24-disk-tagsform-input-hidden-file_id" value="<?= $arResult['FILE']['ID'] ?>" />
        <input type="text" class="bx24-disk-tagsform-input-text" id="bx24-disk-tagsform-input-text" value="" />
        <input type="submit" class="bx24-disk-tagsform-input-submit" value="<?= Loc::getMessage('DISK_FILE_VIEW_TAGS_SAVE') ?>" />
    </form>
</div>

<div class="bx24-disk-tags-results" id="bx24-disk-tags-results">
    <? if ( !empty( $arResult['TAGS'] ) ) {
        foreach ( $arResult['TAGS'] as $arItem ) { ?>
            <div class="bx24-disk-tag-wrap bx24-disk-tag-wrap-<?= $arItem['ID'] ?>" id="bx24-disk-tag-wrap-<?= $arItem['ID'] ?>">
                <a href="<?= BX24\Disk\Tags::GetLinkFilterTag($arItem['NAME']) ?>" class="bx24-disk-tag bx24-disk-tag-<?= $arItem['ID'] ?>"><?= $arItem['NAME'] ?></a>
                <a href="#" class="bx24-disk-tag-trash" data-id="<?= $arItem['ID'] ?>">х</a>
            </div>
        <? }
    }?>
</div>


<script type="text/javascript">
    BX(function () {

        var urlAjax = "/local/templates/bitrix24/components/bitrix/disk.file.view/.default/bx24_tags_ajax.php";

        BX.bindDelegate(
            BX('bx24-disk-tags-results'), 'click', {className: 'bx24-disk-tag-trash' },
            function(e){
                if(!e) {
                    e = window.event;
                }

                var tag_id = this.getAttribute('data-id');
                if ( tag_id ) {
                    BX.ajax.submitAjax(BX('bx24-disk-tagsform-add'), {
                        url: BX.Disk.addToLinkParam(urlAjax, 'action', 'trashTag'),
                        dataType : "json",
                        method : "POST",
                        data: {
                            tag_id: tag_id
                        },
                        onsuccess: BX.delegate(function (response){
                            var node = "bx24-disk-tag-wrap-"+tag_id;
                            if (!response) {
                                //BX.removeClass(BX('bx-disk-submit-uf-file-edit-form'), 'clock');
                                return;
                            }
                            if(response.status === 'error') {

                            }
                            if(response.status === 'success') {
                                var trashTag = document.getElementById(node);
                                trashTag.remove();
                            }
                        }, this)
                    });
                }

                return BX.PreventDefault(e);
            }
        );


        var showFormAddTags = function (e) {
            BX.addClass( BX('bx24-disk-tags-add'), 'opened' );
            BX.PreventDefault(e);
        }

        var submitForm = function(e){

            /*
            if(BX.hasClass(BX('bx-disk-submit-uf-file-edit-form'), 'clock'))
            {
                BX.PreventDefault(e);
                return;
            }
            */

            BX.ajax.submitAjax(BX('bx24-disk-tagsform-add'), {
                url: BX.Disk.addToLinkParam(urlAjax, 'action', 'addTags'),
                dataType : "json",
                method : "POST",
                data: {
                    file_id: BX('bx24-disk-tagsform-input-hidden-file_id').value,
                    tag_value: BX('bx24-disk-tagsform-input-text').value
                },
                onsuccess: BX.delegate(function (response){
                    if (!response) {
                        //BX.removeClass(BX('bx-disk-submit-uf-file-edit-form'), 'clock');
                        return;
                    }
                    if(response.status === 'error') {

                    }
                    if(response.status === 'success') {

                        BX.append(BX.create('div', {
                            attrs: {
                                className: 'bx24-disk-tag-wrap bx24-disk-tag-wrap-'+response.tag_id,
                                id: 'bx24-disk-tag-wrap-'+response.tag_id
                            },
                            text: "",
                            children: [
                                BX.create('a', {
                                    attrs: {
                                        className: 'bx24-disk-tag bx24-disk-tag-id'+response.tag_id,
                                        href: '#'
                                    },
                                    text: response.tag_value
                                }),
                                BX.create('a', {
                                    attrs: {
                                        className: 'bx24-disk-tag-trash',
                                        href: '#',
                                        'data-id': response.tag_id
                                    },
                                    text: "х"
                                })
                            ]
                        }), BX('bx24-disk-tags-results') );
                    }
                }, this)
            });

            BX.PreventDefault(e);
        };

        BX.bind(BX('disk-tags-add'), 'click', showFormAddTags);
        BX.bind(BX('bx24-disk-tagsform-add'), 'submit', submitForm);
    });
</script>

