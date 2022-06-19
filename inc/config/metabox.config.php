<?php if (!defined('ABSPATH')) {
    die;
} // Cannot access pages directly.
// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// METABOX OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options = array();


$options[] = array(
    'id' => 'download_files',
    'title' => 'فایل های پیوست',
    'post_type' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'sections' => array(
        array(
            'name' => 'group_options',
            'fields' => array(

                array(
                    'id' => 'free_download',
                    'type' => 'switcher',
                    'title' => 'نمایش برای کاربران',
                    'info' => 'فایل های پیوست فقط به کاربران نمایش داده شود',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),

                array(
                    'id' => 'files',
                    'type' => 'group',
                    'title' => 'فایل های پیوست',
                    'button_title' => 'افزودن پیوست',
                    'accordion_title' => 'subject',
                    'fields' => array(

                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'نام فایل',
                        ),

                        array(
                            'id' => 'file',
                            'type' => 'upload',
                            'title' => 'فایل پیوست',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن فایل',
                                'frame_title' => 'فایل را انتخاب کنید',
                                'insert_title' => 'انتخاب این فایل',
                            ),
                        ),

                    )
                ),
                array(
                    'id' => 'info_dowmload',
                    'type'     => 'wysiwyg',
                    'title' => 'راهنما فایل دانلود',
                    'info' => 'در صورت خالی بودن از متن عمومی در تنظیمات قالب استفاده خواهد شد',
                    'settings' => array(
                        'textarea_rows' => 5,
                        'tinymce'       => true,
                        'media_buttons' => false,
                    )
                ),

            ),
        ), // end: group options

    ),
);
$options[] = array(
    'id' => 'fs_post_settings',
    'title' => 'تنظیمات مطلب',
    'post_type' => 'post',
    'context' => 'side',
    'priority' => 'high',
    'sections' => array(

        array(
            'name' => 'section_3',
            'fields' => array(
                array(
                    'id'           => 'show-pic',
                    'type'         => 'switcher',
                    'title'        => 'تصویر شاخص در صفحه مطلب نمایش داده شود؟',
                    'settings'         => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                    'default' => 'true',
                ),
                array(
                    'id' => 'align',
                    'desc' => 'تنظیم تصور شاخص',
                    'type' => 'image_select',
                    'options' => array(
                        'right' => WF_URI . '/assets/img/right.png',
                        'center' => WF_URI . '/assets/img/center.png',
                        'left' => WF_URI . '/assets/img/left.png',
                    ),
                    'default' => 'left',
                    'dependency'   => array( 'show-pic', '==', 'true' ),
                ),
                array(
                    'id'           => 'is_video',
                    'type'         => 'switcher',
                    'title'        => 'مطلب ویدیو می باشد؟',
                    'settings'         => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                    'default' => 'false',
                ),
                array(
                    'id' => 'video-link',
                    'type' => 'upload',
                    'title' => 'فایل ویدیو',
                    'dependency' => array('is_video', '==', 'true'),
                    'settings' => array(
                        'upload_type' => 'video',
                        'button_title' => 'افزودن ویدیو',
                        'frame_title' => 'ویدیو معرفی دوره را انتخاب کنید',
                        'insert_title' => 'انتخاب این ویدیو',
                    ),
                ),

            ),
        ),

    ),
);

CSFramework_Metabox::instance($options);

$opt            = array();

$opt[]            = array(
    'name'              => 'factshop-style',
    'title'             => 'تنظیمات فکت شاپ',
    'description'       => 'اصلاح گرافیک فکت شاپ',
    'sections'          => array(

        // begin: section
        array(
            'name'          => 'public',
            'title'         => 'تنظیمات عمومی',
            'settings'      => array(
                array(
                    'name'          => 'site_font',
                    'default' => 'yekan-bakh',
                    'control'       => array(
                        'label'       => 'فونت سایت',
                        'type'        => 'select',
                        'choices'     => array(
                            'droidarabickufi' => 'دروید کوفی',
                            'droidarabicnaskh' => 'دروید نسخ',
                            'iransans' => 'ایران سنس',
                            'iransansfanum' => 'ایران سنس(اعداد فارسی)',
                            'iransansdn' => 'ایران سنس دست نویس',
                            'iransansdnfanum' => 'ایران سنس دست نویس (اعداد فارسی)',
                            'Yekan' => 'یکان',
                            'yekan-bakh' => 'یکان باخ',
                            'iranyekan' => 'ایران یکان',
                            'iranyekanfanum' => 'ایران یکان(اعداد فارسی)',
                        )
                    ),
                ),
                array(
                    'name'          => 'flat_site',
                    'control'       => array(
                        'type'        => 'cs_field',
                        'options'     => array(
                            'type'      => 'switcher',
                            'title'     => 'حالت فلت',
                        ),
                    ),
                ),

                array(
                    'name'      => 'back-color',
                    'default'   => '#ffffff',
                    'control'   => array(
                        'type'    => 'cs_field',
                        'options' => array(
                            'type'  => 'color_picker',
                            'title' => 'رنگ پس زمینه',
                            'rgba' => false,
                        ),
                    ),
                ),

                array(
                    'name'      => 'text-color',
                    'default'   => '#666666',
                    'control'   => array(
                        'type'    => 'cs_field',
                        'options' => array(
                            'type'  => 'color_picker',
                            'title' => 'رنگ متن',
                            'rgba' => false,
                        ),
                    ),
                ),

                array(
                    'name'      => 'primary-color',
                    'default'   => '#007bff',
                    'control'   => array(
                        'type'    => 'cs_field',
                        'options' => array(
                            'type'  => 'color_picker',
                            'title' => 'رنگ اصلی',
                            'rgba' => false,
                        ),
                    ),
                ),
                array(
                    'name'      => 'post-hover-btn',
                    'default'   => '#007bff',
                    'control'   => array(
                        'type'    => 'cs_field',
                        'options' => array(
                            'type'  => 'color_picker',
                            'title' => 'رنگ هاور دکمه پست',
                            'rgba' => false,
                        ),
                    ),
                ),
                array(
                    'name'      => 'product-hover-btn',
                    'default'   => '#007bff',
                    'control'   => array(
                        'type'    => 'cs_field',
                        'options' => array(
                            'type'  => 'color_picker',
                            'title' => 'رنگ هاور دکمه محصول',
                            'rgba' => false,
                        ),
                    ),
                ),

            ),
        ),
        // end: section

        // begin: section
        array(
            'name'          => 'layout',
            'title'         => 'رابط کاربری',
            'settings'      => array(

                array(
                    'name'          => 'product_card',
                    'default' => 'one',
                    'control'       => array(
                        'label'       => 'طرح کارت های محصول',
                        'type'        => 'select',
                        'choices'     => array(
                            'one' => 'طرح اولیه',
                            'two' => 'طرح دوم',
                            'three' => 'طرح سوم',
                        )
                    ),
                ),
                array(
                    'name'          => 'post_card',
                    'default' => 'one',
                    'control'       => array(
                        'label'       => 'طرح کارت های مطالب',
                        'type'        => 'select',
                        'choices'     => array(
                            'one' => 'طرح اولیه',
                            'two' => 'طرح دوم',
                        )
                    ),
                ),
                array(
                    'name'          => 'block_title',
                    'default' => 'one',
                    'control'       => array(
                        'label'       => 'طرح عناوین بلاک ها',
                        'type'        => 'select',
                        'choices'     => array(
                            'one' => 'طرح اولیه',
                            'two' => 'طرح دوم',
                        )
                    ),
                ),
                array(
                    'name'          => 'widget_title',
                    'default' => 'one',
                    'control'       => array(
                        'label'       => 'طرح عناوین ابزارک ها',
                        'type'        => 'select',
                        'choices'     => array(
                            'one' => 'طرح اولیه',
                            'two' => 'طرح دوم',
                        )
                    ),
                ),
                array(
                    'name'      => 'card_radius',
                    'control'   => array(
                        'type'    => 'cs_field',
                        'options' => array(
                            'type'  => 'number',
                            'title' => 'حاشیه کارت ها',
                        ),
                    ),
                ),

            ),
        ),
        // end: section

    ),
    // end: sections

);


CSFramework_Customize::instance( $opt );
