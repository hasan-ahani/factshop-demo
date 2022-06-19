<?php if (!defined('ABSPATH')) {
    die;
}


$settings = array(
    'menu_title' => 'تنظیمات فکت شاپ',
    'menu_type' => 'menu',
    'menu_slug' => 'factshop-options',
    'menu_icon' =>  WF_URI . '/assets/img/menuicon.png',
    'ajax_save' => true,
    'show_reset_all' => false,
    'framework_title' => '<img src="' . WF_URI . '/assets/img/wflogo.png"/> تنظیمات قالب فکت شاپ <small>نسخه '.WF_VER.'</small>',
);

$options = array();

$options[] = array(
    'name' => 'public',
    'title' => 'تنظیمات عمومی',
    'icon' => 'fas fa fa-dashboard',
    'fields' => array(

        array(
            'type' => 'heading',
            'content' => 'تنظیمات عمومی قالب',
        ),
        array(
            'id' => 'logo',
            'type' => 'image',
            'title' => 'لوگو',
            'desc' => 'لوگو در هدر سایت استفاده می شود',
        ),
        array(
            'id' => 'favicon',
            'type' => 'image',
            'title' => 'فاوآیکن',
            'desc' => 'اندازه آیکن 32*32',
        ),
        array(
            'id' => 'color-site',
            'type' => 'color_picker',
            'title' => 'رنگ آدرس بار',
            'desc' => 'برای تغییر رنگ آدرس بار مرورگر کروم در موبایل ها این را تغییر دهید.',
        ),
        array(
            'id' => 'is_seo_plugin',
            'type' => 'switcher',
            'title' => 'افزونه مخصوص سئو نصب کرده اید؟',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'desc',
            'type' => 'textarea',
            'title' => 'توضیحات سایت',
            'desc' => 'متن توضیح خود را برای سئو وارد کنید',
            'dependency' => array('is_seo_plugin', '==', 'false'),
        ),
        array(
            'id' => 'keywords',
            'type' => 'textarea',
            'title' => 'توضیحات سایت',
            'desc' => 'کلمات کلیدی سایت را وارد کنید',
            'after' => 'کلمات را با , از هم جدا کنید',
            'dependency' => array('is_seo_plugin', '==', 'false'),
        ),
        array(
            'id' => 'login_page',
            'type' => 'select',
            'title' => 'صفحه ورود به پنل کاربری',
            'desc' => 'صفحه ورود به پنل کاربری را وارد کنید.',
            'options' => 'pages',
            'default_option' => 'انتخاب صفحه'
        ),

        array(
            'id' => 'login_pic',
            'type' => 'image',
            'title' => 'تصویر فرم ورود',
        ),

        array(
            'id' => 'is_local_avatar',
            'type' => 'switcher',
            'title' => 'سیستم آواتار داخلی',
            'desc' => 'درصورتیکه تمایل دارید کاربران از پنل کاربری خود آواتار خود را تغییر دهند این گزینه را فعال کتید.',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'local_avatar_default',
            'type' => 'image',
            'title' => 'آواتار پیشفرض',
        ),



        array(
            'type' => 'subheading',
            'content' => 'صفحه جستجو',
        ),
        array(
            'id' => 'search_query_page',
            'type' => 'select',
            'title' => 'جستجو در بخش',
            'class' => 'horizontal',
            'options' => array(
                'post' => 'مطالب',
                'product' => 'محصولات',
                'all' => 'محصولات و مطالب',
            ),
            'default' => 'post',
        ),
        array(
            'type' => 'notice',
            'class' => 'danger',
            'content' => 'توجه داشته باشید این گزینه محصولات و مطالب را در یک قالب نمایش خواهد داد، بنابرین قیمت محصولات و ... نمایش داده نمی شود.',
            'dependency' => array('search_query_page', '==', 'all'),
        ),
        array(
            'type' => 'subheading',
            'content' => 'جستجو زنده AJAX',
        ),
        array(
            'id' => 'is_ajax_search_header',
            'type' => 'switcher',
            'title' => 'جستجو زنده در هدر',
            'desc' => 'با فعال کردن این گزینه صفحه جستجو فعال خواهد بود و با کلیلک بروی ',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'ajax_search_query',
            'type' => 'checkbox',
            'title' => 'جستجو در بخش',
            'class' => 'horizontal',
            'options' => array(
                'post' => 'مطالب',
                'product' => 'محصولات',
            ),
            'default' => array('post', 'product'),
            'dependency' => array('is_ajax_search_header', '==', 'true'),
        ),
    ),
);
$options[] = array(
    'name' => 'notification',
    'title' => 'اعلانات',
    'icon' => 'fa fa-bell',
    'fields' => array(
        array(
            'id' => 'show-notification',
            'type' => 'switcher',
            'title' => 'نمایش اعلان',
            'desc' => 'اعلان در بالای سایت نمایش داده شود',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),

        array(
            'id' => 'notification-text',
            'type' => 'textarea',
            'title' => 'متن اعلان',
            'desc' => 'این متن در اعلان بالای سایت نمایش داده می شود.',
        ),
        array(
            'id' => 'notification-link',
            'type' => 'text',
            'title' => 'لینک اعلان',
            'desc' => 'لینک ارجاع اعلان را وارد کنید. اگر لینک ارجاع ندارید خالی بگذارید.',
        ),
        array(
            'id' => 'notification-pic',
            'type' => 'image',
            'title' => 'تصور اعلان',
            'desc' => 'ابعاد پیشنهادی 80×1280، اگر برای اعلان تصویر انتخاب کنید متن شما نمایش داده نخواهد شد.',
        ),
        array(
            'id' => 'notification-remove',
            'type' => 'select',
            'title' => 'غیر فعال کردن',
            'desc' => 'تنظیم دکمه برای حذف کردن اعلان برای هر کاربر',
            'options' =>
                array(
                    'one' => 'حذف شدن برای همیشه',
                    'page' => 'حذف شدن در همان صفحه',
                    'no' => 'هیچ وقت حذف نشود'
                )

        ),
        array(
            'id' => 'notification-day',
            'type' => 'fdate',
            'title' => 'زمان انقضا',
            'desc' => 'در صورتی که تمایل به ثبت اعلان زمان دار دارید این قسمت را تکمیل کنید.',

        ),
        array(
            'id' => 'notification-bgcolor',
            'type' => 'color_picker',
            'title' => 'پس زمینه اعلان',
            'desc' => 'در صورت خالی بودن این فیلد پس زمینه پیشفرض انتخاب می شود.',
        ),
        array(
            'id' => 'notification-color',
            'type' => 'color_picker',
            'title' => 'رنگ متن اعلان	',
            'desc' => 'در صورت خالی بودن این فیلد رنگ متن پیشفرض انتخاب می شود.',
        ),
    ),

);
$options[] = array(
    'name' => 'homepage',
    'title' => 'صفحه نخست',
    'icon' => 'fa fa-home',
    'fields' => array(
        array(
            'type' => 'subheading',
            'title' => 'بلاک محصولات',
        ),
        array(
            'id' => 'show-home-product1',
            'type' => 'switcher',
            'title' => 'نمایش بلاک محصولات',
            'default' => true,
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'subject-home-product1',
            'type' => 'text',
            'title' => 'عنوان',
            'default' => 'محصولات جدید',
        ),
        array(
            'id' => 'category-home-product1',
            'type' => 'select',
            'title' => 'دسته محصولات',
            'options' => 'categories',
            'default_option' => 'نمایش همه',
            'query_args' => array(
                'type' => 'product',
                'taxonomy' => 'product_cat',
            ),
        ),
        array(
            'id' => 'number-home-product1',
            'type' => 'number',
            'title' => 'تعداد نمایش',
            'default' => 8,
        ),
        array(
            'id' => 'link-home-product1',
            'type' => 'text',
            'title' => 'لینک عناوین بیشتر',
        ),
        array(
            'type' => 'subheading',
            'title' => 'بلاک مطالب اول',
        ),
        array(
            'id' => 'show-home-post1',
            'type' => 'switcher',
            'title' => 'نمایش بلاک مطالب اول',
            'default' => true,
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'subject-home-post1',
            'type' => 'text',
            'title' => 'عنوان',
            'default' => 'مطالب اخیر',
        ),
        array(
            'id' => 'category-home-post1',
            'type' => 'select',
            'title' => 'دسته مطالب',
            'default_option' => 'نمایش همه',
            'options' => 'categories',
        ),
        array(
            'id' => 'number-home-post1',
            'type' => 'number',
            'title' => 'تعداد نمایش',
            'default' => 8,
        ),
        array(
            'id' => 'link-home-post1',
            'type' => 'text',
            'title' => 'لینک عناوین بیشتر',
        ),
        array(
            'type' => 'subheading',
            'title' => 'بلاک مطالب دوم',
        ),
        array(
            'id' => 'show-home-post2',
            'type' => 'switcher',
            'title' => 'نمایش بلاک مطالب دوم',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'subject-home-post2',
            'type' => 'text',
            'title' => 'عنوان',
        ),
        array(
            'id' => 'category-home-post2',
            'type' => 'select',
            'title' => 'دسته مطالب',
            'default_option' => 'نمایش همه',
            'options' => 'categories',
        ),
        array(
            'id' => 'number-home-post2',
            'type' => 'number',
            'title' => 'تعداد نمایش',
        ),
        array(
            'id' => 'link-home-post2',
            'type' => 'text',
            'title' => 'لینک عناوین بیشتر',
        ),
        array(
            'type' => 'subheading',
            'title' => 'بلاک مطالب سوم',
        ),
        array(
            'id' => 'show-home-post3',
            'type' => 'switcher',
            'title' => 'نمایش بلاک مطالب سوم',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'subject-home-post3',
            'type' => 'text',
            'title' => 'عنوان',
        ),
        array(
            'id' => 'category-home-post3',
            'type' => 'select',
            'title' => 'دسته مطالب',
            'default_option' => 'نمایش همه',
            'options' => 'categories',
        ),
        array(
            'id' => 'number-home-post3',
            'type' => 'number',
            'title' => 'تعداد نمایش',
        ),
        array(
            'id' => 'link-home-post3',
            'type' => 'text',
            'title' => 'لینک عناوین بیشتر',
        ),
        array(
            'type' => 'subheading',
            'title' => 'بلاک مطالب چهارم',
        ),
        array(
            'id' => 'show-home-post4',
            'type' => 'switcher',
            'title' => 'نمایش بلاک مطالب چهارم',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'subject-home-post4',
            'type' => 'text',
            'title' => 'عنوان',
        ),
        array(
            'id' => 'category-home-post4',
            'type' => 'select',
            'title' => 'دسته مطالب',
            'default_option' => 'نمایش همه',
            'options' => 'categories',
        ),
        array(
            'id' => 'number-home-post4',
            'type' => 'number',
            'title' => 'تعداد نمایش',
        ),
        array(
            'id' => 'link-home-post4',
            'type' => 'text',
            'title' => 'لینک عناوین بیشتر',
        ),
        array(
            'type' => 'subheading',
            'title' => 'بلاک محصولات دوم',
        ),
        array(
            'id' => 'show-home-product2',
            'type' => 'switcher',
            'title' => 'نمایش بلاک محصولات دوم',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'subject-home-product2',
            'type' => 'text',
            'title' => 'عنوان',
        ),
        array(
            'id' => 'category-home-product2',
            'type' => 'select',
            'title' => 'دسته محصولات',
            'options' => 'categories',
            'default_option' => 'نمایش همه',
            'query_args' => array(
                'type' => 'product',
                'taxonomy' => 'product_cat',
            ),
        ),
        array(
            'id' => 'number-home-product2',
            'type' => 'number',
            'title' => 'تعداد نمایش',
        ),
        array(
            'id' => 'link-home-product2',
            'type' => 'text',
            'title' => 'لینک عناوین بیشتر',
        ),
        array(
            'type' => 'subheading',
            'title' => 'بلاک محصولات سوم',
        ),
        array(
            'id' => 'show-home-product3',
            'type' => 'switcher',
            'title' => 'نمایش بلاک محصولات سوم',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'subject-home-product3',
            'type' => 'text',
            'title' => 'عنوان',
        ),
        array(
            'id' => 'category-home-product3',
            'type' => 'select',
            'title' => 'دسته محصولات',
            'options' => 'categories',
            'default_option' => 'نمایش همه',
            'query_args' => array(
                'type' => 'product',
                'taxonomy' => 'product_cat',
            ),
        ),
        array(
            'id' => 'number-home-product3',
            'type' => 'number',
            'title' => 'تعداد نمایش',
        ),
        array(
            'id' => 'link-home-product3',
            'type' => 'text',
            'title' => 'لینک عناوین بیشتر',
        ),
        array(
            'type' => 'subheading',
            'title' => 'بلاک محصولات چهارم',
        ),
        array(
            'id' => 'show-home-product4',
            'type' => 'switcher',
            'title' => 'نمایش بلاک محصولات چهارم',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'subject-home-product4',
            'type' => 'text',
            'title' => 'عنوان',
        ),
        array(
            'id' => 'category-home-product4',
            'type' => 'select',
            'title' => 'دسته محصولات',
            'options' => 'categories',
            'default_option' => 'نمایش همه',
            'query_args' => array(
                'type' => 'product',
                'taxonomy' => 'product_cat',
            ),
        ),
        array(
            'id' => 'number-home-product4',
            'type' => 'number',
            'title' => 'تعداد نمایش',
        ),
        array(
            'id' => 'link-home-product4',
            'type' => 'text',
            'title' => 'لینک عناوین بیشتر',
        ),
        array(
            'type' => 'subheading',
            'title' => 'بلاک محصولات پنجم',
        ),
        array(
            'id' => 'show-home-product5',
            'type' => 'switcher',
            'title' => 'نمایش بلاک محصولات دوم',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'subject-home-product5',
            'type' => 'text',
            'title' => 'عنوان',
        ),
        array(
            'id' => 'category-home-product5',
            'type' => 'select',
            'title' => 'دسته محصولات',
            'options' => 'categories',
            'default_option' => 'نمایش همه',
            'query_args' => array(
                'type' => 'product',
                'taxonomy' => 'product_cat',
            ),
        ),
        array(
            'id' => 'number-home-product5',
            'type' => 'number',
            'title' => 'تعداد نمایش',
        ),
        array(
            'id' => 'link-home-product5',
            'type' => 'text',
            'title' => 'لینک عناوین بیشتر',
        ),
        array(
            'type' => 'subheading',
            'title' => 'بلاک محصولات ششم',
        ),
        array(
            'id' => 'show-home-product6',
            'type' => 'switcher',
            'title' => 'نمایش بلاک محصولات ششم',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'subject-home-product6',
            'type' => 'text',
            'title' => 'عنوان',
        ),
        array(
            'id' => 'category-home-product6',
            'type' => 'select',
            'title' => 'دسته محصولات',
            'options' => 'categories',
            'default_option' => 'نمایش همه',
            'query_args' => array(
                'type' => 'product',
                'taxonomy' => 'product_cat',
            ),
        ),
        array(
            'id' => 'number-home-product6',
            'type' => 'number',
            'title' => 'تعداد نمایش',
        ),
        array(
            'id' => 'link-home-product6',
            'type' => 'text',
            'title' => 'لینک عناوین بیشتر',
        ),
        array(
            'type' => 'subheading',
            'title' => 'بلاک محصولات هفتم',
        ),
        array(
            'id' => 'show-home-product7',
            'type' => 'switcher',
            'title' => 'نمایش بلاک محصولات هفتم',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'subject-home-product7',
            'type' => 'text',
            'title' => 'عنوان',
        ),
        array(
            'id' => 'category-home-product7',
            'type' => 'select',
            'title' => 'دسته محصولات',
            'options' => 'categories',
            'default_option' => 'نمایش همه',
            'query_args' => array(
                'type' => 'product',
                'taxonomy' => 'product_cat',
            ),
        ),
        array(
            'id' => 'number-home-product7',
            'type' => 'number',
            'title' => 'تعداد نمایش',
        ),
        array(
            'id' => 'link-home-product7',
            'type' => 'text',
            'title' => 'لینک عناوین بیشتر',
        ),
        array(
            'type' => 'subheading',
            'title' => 'بلاک محصولات هشتم',
        ),
        array(
            'id' => 'show-home-product8',
            'type' => 'switcher',
            'title' => 'نمایش بلاک محصولات هشتم',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'subject-home-product8',
            'type' => 'text',
            'title' => 'عنوان',
        ),
        array(
            'id' => 'category-home-product8',
            'type' => 'select',
            'title' => 'دسته محصولات',
            'options' => 'categories',
            'default_option' => 'نمایش همه',
            'query_args' => array(
                'type' => 'product',
                'taxonomy' => 'product_cat',
            ),
        ),
        array(
            'id' => 'number-home-product8',
            'type' => 'number',
            'title' => 'تعداد نمایش',
        ),
        array(
            'id' => 'link-home-product8',
            'type' => 'text',
            'title' => 'لینک عناوین بیشتر',
        ),

    )
);
$options[] = array(
    'name' => 'header',
    'title' => 'تنظیم سربرگ',
    'icon' => 'fa fa-list-alt',
    'fields' => array(
        array(
            'id' => 'show-topbar',
            'type' => 'switcher',
            'title' => 'نمایش منو بالا',
            'desc' => 'منو بالا نمایش داده شود',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'phone-number',
            'type' => 'text',
            'title' => 'تلفن تماس',
            'desc' => 'تلفن تماس در هیدر بالا نمایش داده می شود',
            'default' => '021-5900',
        ),
        array(
            'id' => 'email-address',
            'type' => 'text',
            'title' => 'آدرس ایمیل',
            'desc' => 'ایمیل در هیدر بالا نمایش داده می شود',
            'default' => 'info@wpfact.ir',
        ),

        array(
            'id' => 'show-search',
            'type' => 'switcher',
            'title' => 'نمایش جستجو',
            'desc' => 'فیلد جستجو نمایش داده شود',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'show-mycart',
            'type' => 'switcher',
            'title' => 'نمایش سبد خرید',
            'desc' => 'آیکن سبد خرید نمایش داده شود',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'show-mycart-mobile',
            'type' => 'switcher',
            'title' => 'نمایش سبد خرید در موبایل',
            'desc' => 'آیکن سبد خرید در موبایل نمایش داده شود',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'show-profile',
            'type' => 'switcher',
            'title' => 'نمایش پروفایل',
            'desc' => 'قسمت پنل کاربری نمایش داده شود',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),

        array(
            'id' => 'show-sticky-header',
            'type' => 'switcher',
            'title' => 'نمایش منو استیکی',
            'desc' => 'منو در اسکرول نمایش داده شود.',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'show-menu-text-responsive',
            'type' => 'switcher',
            'title' => 'نمایش واژه منو در رسپانسیو',
            'desc' => 'دکمه باز کردن منو موبایل همراه واژه باشد.',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'menu-text-responsive',
            'type' => 'text',
            'title' => 'واژه منو رسپانسیو',
            'default' => 'منو',
            'dependency' => array('show-menu-text-responsive', '==', 'true'),
        ),
    )
);
$options[] = array(
    'name' => 'footer',
    'title' => 'تنظیم پاورقی',
    'icon' => 'fa fa-credit-card-alt',
    'fields' => array(
        array(
            'id' => 'show-footer-widgets',
            'type' => 'switcher',
            'title' => 'نمایش ویدجت ها',
            'desc' => 'ویدجت ها در فوتر نمایش داده شود',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),

        array(
            'id' => 'footer-category-post',
            'type' => 'select',
            'title' => 'دسته اعلانات',
            'desc' => 'دسته بندی لیست مطالب در فوتر را وارد کنید.',
            'default_option' => 'نمایش همه',
            'options' => 'categories',
        ),
        array(
            'id' => 'is_show_go_top',
            'type' => 'switcher',
            'title' => 'نمایش دکمه برگشت به بالا',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'footer-copyright',
            'type' => 'textarea',
            'title' => 'متن کپی رایت',
        ),
        array(
            'id' => 'footer-designer',
            'type' => 'textarea',
            'title' => 'متن طراحی و اجرا',
        ),
        array(
            'id' => 'footer-namad1',
            'type' => 'wysiwyg',
            'title' => 'کد نماد اعتماد اول',
            'settings' => array(
                'textarea_rows' => 5,
                'tinymce' => false,
                'media_buttons' => false,
            )
        ),array(
            'id' => 'footer-namad2',
            'type' => 'wysiwyg',
            'title' => 'کد نماد اعتماد دوم',
            'settings' => array(
                'textarea_rows' => 5,
                'tinymce' => false,
                'media_buttons' => false,
            )
        ),
        array(
            'id' => 'footer-mailchimp',
            'type' => 'textarea',
            'title' => 'کد کوتاه فرم خبرنامه',
        ),
    )
);
$options[] = array(
    'name' => 'slider',
    'title' => 'تنظیم اسلایدر',
    'icon' => 'fa fa-sliders',
    'sections' => array(
        array(
            'name' => 'home',
            'title' => 'صفحه اصلی',
            'fields' => array(
                array(
                    'id' => 'home-slider-show',
                    'type' => 'switcher',
                    'title' => 'نمایش اسلایدر',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'homeside',
                    'type' => 'group',
                    'title' => 'اسلاید',
                    'button_title' => 'افزودن اسلاید',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'info' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمیشود',
                        ),
                        array(
                            'id' => 'photo',
                            'type' => 'upload',
                            'title' => 'تصویر اسلاید',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                            'validate' => 'required',
                        ),
                        array(
                            'id' => 'link',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن فقط تصویر بدون لینک خواهد بود',
                        ),
                    )
                ),
            ),
        ),
        array(
            'name' => 'category',
            'title' => 'صفحه دسته بندی',
            'fields' => array(
                array(
                    'id' => 'category-slider-show',
                    'type' => 'switcher',
                    'title' => 'نمایش اسلایدر',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'categoryside',
                    'type' => 'group',
                    'title' => 'اسلاید',
                    'button_title' => 'افزودن اسلاید',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'info' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمیشود',
                        ),
                        array(
                            'id' => 'photo',
                            'type' => 'upload',
                            'title' => 'تصویر اسلاید',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                            'validate' => 'required',
                        ),
                        array(
                            'id' => 'link',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن فقط تصویر بدون لینک خواهد بود',
                        ),
                    )
                ),
            ),
        ),
        array(
            'name' => 'shop',
            'title' => 'صفحه فروشگاه',
            'fields' => array(
                array(
                    'id' => 'shop-slider-show',
                    'type' => 'switcher',
                    'title' => 'نمایش اسلایدر',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'shopside',
                    'type' => 'group',
                    'title' => 'اسلاید',
                    'button_title' => 'افزودن اسلاید',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'info' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمیشود',
                        ),
                        array(
                            'id' => 'photo',
                            'type' => 'upload',
                            'title' => 'تصویر اسلاید',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                            'validate' => 'required',
                        ),
                        array(
                            'id' => 'link',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن فقط تصویر بدون لینک خواهد بود',
                        ),
                    )
                ),
            ),
        ),
        array(
            'name' => 'product',
            'title' => 'صفحه محصول',
            'fields' => array(
                array(
                    'id' => 'product-slider-show',
                    'type' => 'switcher',
                    'title' => 'نمایش اسلایدر',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'productside',
                    'type' => 'group',
                    'title' => 'اسلاید',
                    'button_title' => 'افزودن اسلاید',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'info' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمیشود',
                        ),
                        array(
                            'id' => 'photo',
                            'type' => 'upload',
                            'title' => 'تصویر اسلاید',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                            'validate' => 'required',
                        ),
                        array(
                            'id' => 'link',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن فقط تصویر بدون لینک خواهد بود',
                        ),
                    )
                ),
            ),
        ),
        array(
            'name' => 'page',
            'title' => 'صفحات',
            'fields' => array(
                array(
                    'id' => 'page-slider-show',
                    'type' => 'switcher',
                    'title' => 'نمایش اسلایدر',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'pageside',
                    'type' => 'group',
                    'title' => 'اسلاید',
                    'button_title' => 'افزودن اسلاید',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'info' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمیشود',
                        ),
                        array(
                            'id' => 'photo',
                            'type' => 'upload',
                            'title' => 'تصویر اسلاید',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                            'validate' => 'required',
                        ),
                        array(
                            'id' => 'link',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن فقط تصویر بدون لینک خواهد بود',
                        ),
                    )
                ),
            ),
        ),
        array(
            'name' => 'single',
            'title' => 'صفحه مطلب',
            'fields' => array(
                array(
                    'id' => 'single-slider-show',
                    'type' => 'switcher',
                    'title' => 'نمایش اسلایدر',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'singleside',
                    'type' => 'group',
                    'title' => 'اسلاید',
                    'button_title' => 'افزودن اسلاید',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'info' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمیشود',
                        ),
                        array(
                            'id' => 'photo',
                            'type' => 'upload',
                            'title' => 'تصویر اسلاید',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                            'validate' => 'required',
                        ),
                        array(
                            'id' => 'link',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن فقط تصویر بدون لینک خواهد بود',
                        ),
                    )
                ),
            ),
        ),
    ),

);
$options[] = array(
    'name' => 'image',
    'title' => 'تنظیم اندازه تصاویر',
    'icon' => 'fa fa-crop',
    'fields' => array(
        array(
            'type' => 'notice',
            'class' => 'danger',
            'content' => 'در صورتی که اندازه تصاویر پست ها و محصولات در صفحات و دسته بندی ها برای شما مشکل ایجاد میکند این گزینه ها را تغییر دهید.',
        ),
        array(
            'id' => 'is_image_size_product',
            'type' => 'switcher',
            'title' => 'تغییر اندازه برش تصاویر محصول',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => false,
        ),

        array(
            'type' => 'notice',
            'class' => 'warning',
            'content' => 'ارتفاع پیشفرض تصاویر قالب 170 می باشد.',
            'dependency' => array('is_image_size_product', '==', 'true'),
        ),
        array(
            'id' => 'image_size_height_product',
            'type' => 'number',
            'title' => 'ارتفاع تصویر',
            'settings' => array(
                'min' => 170,
            ),
            'dependency' => array('is_image_size_product', '==', 'true'),
        ),

        array(
            'id' => 'is_image_size_post',
            'type' => 'switcher',
            'title' => 'تغییر اندازه برش تصاویر پست',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => false,
        ),

        array(
            'type' => 'notice',
            'class' => 'warning',
            'content' => 'ارتفاع پیشفرض تصاویر قالب 170 می باشد.',
            'dependency' => array('is_image_size_post', '==', 'true'),
        ),
        array(
            'id' => 'image_size_height_post',
            'type' => 'number',
            'title' => 'ارتفاع تصویر',
            'settings' => array(
                'min' => 170,
            ),
            'dependency' => array('is_image_size_post', '==', 'true'),
        ),


    ),
);
$options[] = array(
    'name' => 'panel',
    'title' => 'تنظیم پنل کاربری',
    'icon' => 'fa fa-user-circle-o',
    'fields' => array(
        array(
            'type' => 'subheading',
            'content' => 'تنظیمات منو کاربری',
        ),
        array(
            'id' => 'user_panel_menu_items',
            'type' => 'checkbox',
            'title' => 'نمایش منو های کاربری',
            'options' => wc_get_account_menu_items(),
            'default' => array(
                'dashboard',
                'orders',
                'downloads',
                'edit-address',
                'edit-account',
                'favorites',
                'announcements',
                'sendpost',
                'myposts',
                'customer-logout',
            )

        ),
    ),
);
$options[] = array(
    'name' => 'post',
    'title' => 'تنظیم صفحه مطلب',
    'icon' => 'fa fa-newspaper-o',
    'fields' => array(
        array(
            'id' => 'show-post-share',
            'type' => 'switcher',
            'title' => 'نمایش اشتراک گذاری',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'show-post-shortlink',
            'type' => 'switcher',
            'title' => 'نمایش لینک کوتاه',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'show-post-tags',
            'type' => 'switcher',
            'title' => 'نمایش برچسب ها',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),

        array(
            'id' => 'show-post-bio',
            'type' => 'switcher',
            'title' => 'نمایش بیوگرافی نویسنده',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'show-post-related',
            'type' => 'switcher',
            'title' => 'نمایش مطالب مرتبط',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'show-post-related_before_comment',
            'type' => 'switcher',
            'title' => 'نمایش مطالب مرتبط قبل از دیدگاه ها',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
            'dependency' => array('show-post-related', '==', 'true'),
        ),
        array(
            'type' => 'subheading',
            'title' => 'جعبه دانلود',
        ),
        array(
            'id' => 'show-post-download-box',
            'type' => 'switcher',
            'title' => 'نمایش جعبه دانلود',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'show-post-download-password',
            'type' => 'switcher',
            'title' => 'نمایش فیلد پسوورد فایل دانلودی',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'post-download-box-pass',
            'type' => 'text',
            'title' => 'رمز فایل های دانلودی',
            'dependency' => array('show-post-download-password', '==', 'true'),
        ),
        array(
            'id' => 'post-download-info',
            'type' => 'textarea',
            'title' => 'راهنما پیشفرض دانلود',
        ),
        array(
            'type' => 'subheading',
            'title' => 'Meta Data',
        ),
        array(
            'id' => 'show-post-meta-cat',
            'type' => 'switcher',
            'title' => 'نمایش دسته بندی',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'show-post-meta-date',
            'type' => 'switcher',
            'title' => 'نمایش تاریخ',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'show-post-meta-author',
            'type' => 'switcher',
            'title' => 'نمایش نویسنده',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'show-post-meta-views',
            'type' => 'switcher',
            'title' => 'نمایش تعداد بازدید',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'show-post-meta-comments',
            'type' => 'switcher',
            'title' => 'نمایش تعداد دیدگاه',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'show-post-like',
            'type' => 'switcher',
            'title' => 'نمایش دکمه علاقه مندی مطلب',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
        array(
            'id' => 'show-comment-like',
            'type' => 'switcher',
            'title' => 'نمایش دکمه علاقه مندی در دیدگاه ها',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'default' => true,
        ),
    ),
);

$options[] = array(
    'name' => 'pages',
    'title' => 'تنظیم اطلاع رسانی',
    'icon' => 'fa fa-envelope-open',
    'sections' => array(
        array(
            'name' => 'setting-email',
            'title' => 'تنظیمات',
            'fields' => array(
                array(
                    'id' => 'email-logo',
                    'type' => 'upload',
                    'title' => 'لوگو ایمیل',
                    'settings' => array(
                        'upload_type' => 'image',
                        'button_title' => 'افزودن تصویر',
                        'frame_title' => 'تصویر را انتخاب کنید',
                        'insert_title' => 'انتخاب این تصویر',
                    ),
                ),
                array(
                    'id' => 'email-name',
                    'type' => 'text',
                    'title' => 'عنوان ایمیل ها',
                    'desc' => 'عنوان مثال (فروشگاه فکت شاپ | FactShop)',
                ),
                array(
                    'id' => 'email-sender',
                    'type' => 'text',
                    'title' => 'ایمیل ارسال کننده',
                ),
                array(
                    'id' => 'email-desc',
                    'type' => 'wysiwyg',
                    'title' => 'توضیح سایت',
                    'desc' => 'شما در این مکان می توانید هر متن یا عکسی قرار دهید.',
                    'settings' => array(
                        'textarea_rows' => 5,
                        'tinymce' => false,
                        'media_buttons' => false,
                    )
                ),
                array(
                    'id' => 'email-copyright',
                    'type' => 'wysiwyg',
                    'title' => 'کپی رایت ایمیل ها',
                    'default' => 'تمامی حقوق برای فکت شاپ محفوظ است',
                    'settings' => array(
                        'textarea_rows' => 5,
                        'tinymce' => false,
                        'media_buttons' => false,
                    )
                ),
            ),
        ),
        array(
            'name' => 'admin-email',
            'title' => 'مدیر',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => 'عضو جدید',
                ),

                array(
                    'id' => 'email-admin-user-registered-is',
                    'type' => 'switcher',
                    'title' => 'ارسال ایمیل کاربر جدید',
                    'desc' => 'درصورتیکه کاربر جدید ثبت نام کند یک ایمیل به مدیر ارسال می شود',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'email-admin-user-registered-sub',
                    'type' => 'text',
                    'title' => 'موضوع',
                ),
                array(
                    'id' => 'email-admin-user-registered-content',
                    'type' => 'wysiwyg',
                    'title' => 'پیام ایمیل',
                    'after' => '<p>از این کد ها می توانید استفاده کنید  <code>[user-name]</code>  <code>[user-email]</code>  <code>[admin-name]</code></p>',
                    'settings' => array(
                        'textarea_rows' => 5,
                        'tinymce' => false,
                        'media_buttons' => false,
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'دیدگاه جدید',
                ),

                array(
                    'id' => 'email-admin-comment-post-is',
                    'type' => 'switcher',
                    'title' => 'ارسال ایمیل دیدگاه جدید',
                    'desc' => 'درصورتیکه دیدگاه جدید ثبت شود یک ایمیل به مدیر ارسال می شود',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'email-admin-comment-post-sub',
                    'type' => 'text',
                    'title' => 'موضوع',
                ),
                array(
                    'id' => 'email-admin-comment-post-content',
                    'type' => 'wysiwyg',
                    'title' => 'پیام ایمیل',
                    'after' => '<p>از این کد ها می توانید استفاده کنید  <code>[date]</code>  <code>[comment]</code>   <code>[email]</code>   <code>[post-title]</code>   <code>[ip]</code>  <code>[admin-name]</code></p>',
                    'settings' => array(
                        'textarea_rows' => 5,
                        'tinymce' => false,
                        'media_buttons' => false,
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'پست جدید',
                ),

                array(
                    'id' => 'email-admin-comment-post-is',
                    'type' => 'switcher',
                    'title' => 'ارسال ایمیل پست جدید',
                    'desc' => 'درصورتیکه پست جدید ثبت شود که نیاز به تایید داشته باشد یک ایمیل به مدیر ارسال می شود',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'email-admin-submit-post-sub',
                    'type' => 'text',
                    'title' => 'موضوع',
                ),
                array(
                    'id' => 'email-admin-submit-post-content',
                    'type' => 'wysiwyg',
                    'title' => 'پیام ایمیل',
                    'after' => '<p>از این کد ها می توانید استفاده کنید  <code>[user-name]</code>  <code>[title]</code>   <code>[link]</code>  <code>[admin-name]</code></p>',
                    'settings' => array(
                        'textarea_rows' => 5,
                        'tinymce' => false,
                        'media_buttons' => false,
                    )
                ),
            ),
        ),
        array(
            'name' => 'user-email',
            'title' => 'کاربران',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => 'ثبت نام',
                ),

                array(
                    'id' => 'email-user-signup-is',
                    'type' => 'switcher',
                    'title' => 'ارسال ایمیل ثبت نام در سایت',
                    'desc' => 'درصورتیکه کاربر در سایت ثبت نام کند این ایمیل برای اون ارسال شود',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'email-user-signup-sub',
                    'type' => 'text',
                    'title' => 'موضوع',
                ),
                array(
                    'id' => 'email-user-signup-content',
                    'type' => 'wysiwyg',
                    'title' => 'پیام ایمیل',
                    'after' => '<p>از این کد ها می توانید استفاده کنید  <code>[user-name]</code>  <code>[user-email]</code></p>',
                    'settings' => array(
                        'textarea_rows' => 5,
                        'tinymce' => false,
                        'media_buttons' => false,
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'تایید ایمیل کاربری',
                ),
                array(
                    'id' => 'email-user-verify-sub',
                    'type' => 'text',
                    'title' => 'موضوع',
                ),
                array(
                    'id' => 'email-user-verify-content',
                    'type' => 'wysiwyg',
                    'title' => 'پیام ایمیل',
                    'desc' => 'لینک تایید به صورت خودکار ارسال می شود',
                    'after' => '<p>از این کد ها می توانید استفاده کنید  <code>[user-name]</code>  <code>[user-email]</code></p>',
                    'settings' => array(
                        'textarea_rows' => 5,
                        'tinymce' => false,
                        'media_buttons' => false,
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'ورود به سایت',
                ),

                array(
                    'id' => 'email-user-signin-is',
                    'type' => 'switcher',
                    'title' => 'ارسال ایمیل ورود به سایت',
                    'desc' => 'درصورتیکه کاربر به سایت وارد شود این ایمیل برای اون ارسال شود',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'email-user-signin-sub',
                    'type' => 'text',
                    'title' => 'موضوع',
                ),
                array(
                    'id' => 'email-user-signin-content',
                    'type' => 'wysiwyg',
                    'title' => 'پیام ایمیل',
                    'after' => '<p>از این کد ها می توانید استفاده کنید  <code>[user-name]</code>  <code>[user-email]</code> <code>[time]</code></p>',
                    'settings' => array(
                        'textarea_rows' => 5,
                        'tinymce' => false,
                        'media_buttons' => false,
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'ورود ناموفق به سایت',
                ),

                array(
                    'id' => 'email-user-signin-fail-is',
                    'type' => 'switcher',
                    'title' => 'ارسال ایمیل ورود ناموفق به سایت',
                    'desc' => 'درصورتیکه ورود ناموفق باشد به صاحب حساب کاربری ایمیل ارسال شود',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'email-user-signin-fail-sub',
                    'type' => 'text',
                    'title' => 'موضوع',
                ),
                array(
                    'id' => 'email-user-signin-fail-content',
                    'type' => 'wysiwyg',
                    'title' => 'پیام ایمیل',
                    'after' => '<p>از این کد ها می توانید استفاده کنید  <code>[user-name]</code>  <code>[user-email]</code> <code>[time]</code></p>',
                    'settings' => array(
                        'textarea_rows' => 5,
                        'tinymce' => false,
                        'media_buttons' => false,
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'فراموشی رمز عبور',
                ),
                array(
                    'type' => 'content',
                    'content' => 'فراموشی رمز عبور مهم می باشد و قابلیت غیر فعال شدن ندارد. لینک ثبت رمز عبور جدید خودکار ارسال می شود، فقط متن دلخواه را وارد کنید.',
                ),
                array(
                    'id' => 'email-user-forgetpass-sub',
                    'type' => 'text',
                    'title' => 'موضوع',
                ),
                array(
                    'id' => 'email-user-forgetpass-content',
                    'type' => 'wysiwyg',
                    'title' => 'پیام ایمیل',
                    'after' => '<p>از این کد ها می توانید استفاده کنید  <code>[user-name]</code>  <code>[user-email]</code> <code>[time]</code> <code>[ip]</code></p>',
                    'settings' => array(
                        'textarea_rows' => 5,
                        'tinymce' => false,
                        'media_buttons' => false,
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'ثبت دیدگاه',
                ),

                array(
                    'id' => 'email-user-comment-is',
                    'type' => 'switcher',
                    'title' => 'ارسال ایمیل ثبت دیدگاه',
                    'desc' => 'درصورتیکه کاربری ثبت دیدگاه انجام دهد ایمیل ارسال شود',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'email-user-comment-sub',
                    'type' => 'text',
                    'title' => 'موضوع',
                ),
                array(
                    'id' => 'email-user-comment-content',
                    'type' => 'wysiwyg',
                    'title' => 'پیام ایمیل',
                    'after' => '<p>از این کد ها می توانید استفاده کنید  <code>[post-title]</code>  <code>[comment]</code> <code>[date]</code> <code>[ip]</code></p>',
                    'settings' => array(
                        'textarea_rows' => 5,
                        'tinymce' => false,
                        'media_buttons' => false,
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'اطلاعیه',
                ),

                array(
                    'id' => 'email-user-notification-is',
                    'type' => 'switcher',
                    'title' => 'ارسال ایمیل اطلاعیه',
                    'desc' => 'درصورتیکه اطلاعیه جدید ثبت شود به کاربران ایمیل ارسال شود',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'email-user-notification-sub',
                    'type' => 'text',
                    'title' => 'موضوع',
                ),
                array(
                    'id' => 'email-user-notification-content',
                    'type' => 'wysiwyg',
                    'title' => 'پیام ایمیل',
                    'after' => '<p>از این کد ها می توانید استفاده کنید  <code>[post-title]</code>  <code>[user-name]</code> <code>[date]</code> <code>[user-email]</code></p>',
                    'settings' => array(
                        'textarea_rows' => 5,
                        'tinymce' => false,
                        'media_buttons' => false,
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'ارسال پست',
                ),

                array(
                    'id' => 'email-user-post_created-is',
                    'type' => 'switcher',
                    'title' => 'ارسال ایمیل ثبت پست',
                    'desc' => 'درصورتیکه پست جدید توسط یک نویسنده ایجاد شود برای او ایمیل ارسال شود',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'email-user-post_created-sub',
                    'type' => 'text',
                    'title' => 'موضوع',
                ),
                array(
                    'id' => 'email-user-post_created-content',
                    'type' => 'wysiwyg',
                    'title' => 'پیام ایمیل',
                    'after' => '<p>از این کد ها می توانید استفاده کنید  <code>[post-title]</code>  <code>[user-name]</code> <code>[date]</code> <code>[user-email]</code> <code>[link]</code> <code>[ip]</code></p>',
                    'settings' => array(
                        'textarea_rows' => 5,
                        'tinymce' => false,
                        'media_buttons' => false,
                    )
                ),

            ),
        ),
    )
);
$options[] = array(
    'name' => 'woocomerce',
    'title' => 'تنظیم فروشگاه',
    'icon' => 'fa fa-shopping-bag',
    'fields' => array(

        array(
            'id' => 'show-product-first-tab',
            'type' => 'switcher',
            'title' => 'حذف تب جزئیات محصول',
            'desc' => 'تب جزئیات محصول به صورت پیشفرض در ووکامرس وجود ندارد و تنها در قالب فکت شاپ وجود دارد.',
            'default' => false,
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'show-product-img-little',
            'type' => 'switcher',
            'title' => 'نمایش کوچک تصویر محصول',
            'desc' => 'در صورت غیر فعال بودن تصویر شاخص بزرگ نمایش داده می شود.',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'show-product-related',
            'type' => 'switcher',
            'title' => 'نمایش محصولات مرتبط',
            'default' => true,
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'show-product-like',
            'type' => 'switcher',
            'title' => 'نمایش دکمه علاقه مندی',
            'default' => true,
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'show-product-details',
            'type' => 'switcher',
            'title' => 'نمایش باکس اطلاعات محصول',
            'default' => true,
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'show-product-date',
            'type' => 'switcher',
            'title' => 'نمایش تاریخ انتشار',
            'default' => true,
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'dependency' => array('show-product-details', '==', 'true'),
        ),
        array(
            'id' => 'show-product-updated',
            'type' => 'switcher',
            'title' => 'نمایش تاریخ بروزرسانی',
            'default' => true,
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'dependency' => array('show-product-details', '==', 'true'),
        ),
        array(
            'id' => 'show-product-sales',
            'type' => 'switcher',
            'title' => 'نمایش تعداد فروش',
            'default' => true,
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'dependency' => array('show-product-details', '==', 'true'),
        ),
        array(
            'id' => 'show-product-views',
            'type' => 'switcher',
            'title' => 'نمایش تعداد بازدید',
            'default' => true,
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'dependency' => array('show-product-details', '==', 'true'),
        ),
        array(
            'id' => 'show-product-comments',
            'type' => 'switcher',
            'title' => 'نمایش تعداد دیدگاه',
            'default' => true,
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'dependency' => array('show-product-details', '==', 'true'),
        ),
        array(
            'id' => 'show-product-filetype',
            'type' => 'switcher',
            'title' => 'نمایش نوع فایل',
            'default' => true,
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'dependency' => array('show-product-details', '==', 'true'),
        ),
        array(
            'id' => 'show-product-filesize',
            'type' => 'switcher',
            'title' => 'نمایش حجم فایل',
            'default' => true,
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'show-product-category',
            'type' => 'switcher',
            'title' => 'نمایش دسته بندی',
            'default' => true,
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'dependency' => array('show-product-details', '==', 'true'),
        ),
        array(
            'id' => 'show-product-tags',
            'type' => 'switcher',
            'title' => 'نمایش برچسب ها',
            'default' => true,
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'dependency' => array('show-product-details', '==', 'true'),
        ),
        array(
            'id' => 'show-product-tagsinbox',
            'type' => 'switcher',
            'title' => 'نمایش برچسب ها در باکس جداگانه',
            'default' => true,
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
            'dependency' => array('show-product-details', '==', 'true'),
        ),
        array(
            'id' => 'free-product-downloadinsingle',
            'type' => 'switcher',
            'title' => 'دانلود محصولات رایگان در صفحه محصول',
            'desc' => 'محصولات رایگان فقط در صفحه محصول قابل دانلود باشند.',
            'default' => true,
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'product_pyments',
            'type' => 'wysiwyg',
            'title' => 'توضیح قبل از خرید	',
            'default' => 'خرید محصول توسط کلیه کارت های شتاب امکان پذیر است و بلافاصله پس از خرید، لینک دانلود محصول در اختیار شما قرار خواهد گرفت. لطفا قبل از خرید در سایت ثبت نام کنید تا از اپدیت های بعدی این محصول به صورت رایگان بهره مند شوید.',
            'settings' => array(
                'textarea_rows' => 5,
                'tinymce' => false,
                'media_buttons' => false,
            )
        ),
        array(
            'id' => 'product_mazaya',
            'type' => 'wysiwyg',
            'title' => 'مزایا خرید	',
            'default' => '<strong>با خرید این محصول از مزایای زیر بهره‌مند می‌شوید:</strong>
            <ul>
                <li>دسترسی به فایل محصول به صورت مادام‌العمر</li>
                <li>۶ ماه پشتیبانی کاملا رایگان و تضمین شده</li>
            </ul>',
            'settings' => array(
                'textarea_rows' => 5,
                'tinymce' => false,
                'media_buttons' => false,
            )
        ),
        array(
            'id' => 'product_pyments_free',
            'type' => 'wysiwyg',
            'title' => 'توضیح قبل از دانلود رایگان(نمایش برای محصول رایگان)',
            'default' => 'خرید محصول توسط کلیه کارت های شتاب امکان پذیر است و بلافاصله پس از خرید، لینک دانلود محصول در اختیار شما قرار خواهد گرفت. لطفا قبل از خرید در سایت ثبت نام کنید تا از اپدیت های بعدی این محصول به صورت رایگان بهره مند شوید.',
            'settings' => array(
                'textarea_rows' => 5,
                'tinymce' => false,
                'media_buttons' => false,
            )
        ),
        array(
            'id' => 'product_mazaya_free',
            'type' => 'wysiwyg',
            'title' => 'مزایا دانلود رایگان(نمایش برای محصول رایگان)',
            'default' => '<strong>با خرید این محصول از مزایای زیر بهره‌مند می‌شوید:</strong>
            <ul>
                <li>دسترسی به فایل محصول به صورت مادام‌العمر</li>
                <li>۶ ماه پشتیبانی کاملا رایگان و تضمین شده</li>
            </ul>',
            'settings' => array(
                'textarea_rows' => 5,
                'tinymce' => false,
                'media_buttons' => false,
            )
        ),
        array(
            'type' => 'subheading',
            'content' => 'تنظیمات پرداخت نهایی',
        ),
        array(
            'id' => 'woo-checkout-billing-fields',
            'type' => 'checkbox',
            'title' => 'فیلد های صورت حساب',
            'options' => array(
                'billing_first_name' => 'نام',
                'billing_last_name' => 'نام خانوادگی',
                'billing_company' => 'شرکت',
                'billing_phone' => 'موبایل',
                'billing_email' => 'ایمیل',
                'billing_country' => 'کشور',
                'billing_state' => 'استان',
                'billing_city' => 'شهر',
                'billing_address_1' => 'آدرس 1',
                'billing_address_2' => 'آدرس 2',
                'billing_postcode' => 'کد پستی',
                'order_comments' => 'توضیحات',
            ),
            'default' => array('billing_first_name', 'billing_last_name', 'billing_phone')

        ),
        array(
            'id' => 'woo-checkout-shipping-fields',
            'type' => 'checkbox',
            'title' => 'فیلد های حمل و نقل',
            'options' => array(
                'shipping_first_name' => 'نام',
                'shipping_last_name' => 'نام خانوادگی',
                'shipping_company' => 'شرکت',
                'shipping_country' => 'کشور',
                'shipping_state' => 'استان',
                'shipping_city' => 'شهر',
                'shipping_address_1' => 'آدرس 1',
                'shipping_address_2' => 'آدرس 2',
                'shipping_postcode' => 'کد پستی',
            ),
        ),
    ),

);

$options[] = array(
    'name' => 'secure',
    'title' => 'تنظیم امنیت',
    'icon' => 'fa fa-delicious',
    'fields' => array(
        array(
            'id' => 'secure-section',
            'type' => 'notice',
            'class' => 'danger',
            'content' => 'این قسمت حساس می باشد، لطفا با دقت تنظیمات را انجام دهید.',
        ),
        array(
            'id' => 'login-fail-number',
            'type' => 'number',
            'title' => 'تعداد دفعات مجاز به ورود',
            'desc' => 'تعداد دفعاتی که کاربر مجاز به ورود ناموفق می باشد.',
            'default' => '5',
            'attributes' => array(
                'min' => '3',
                'max' => '100',
            )

        ),
        array(
            'id' => 'login-fail-after',
            'type' => 'number',
            'title' => 'زمان مسدود بودن',
            'desc' => 'زمان مسدود شدن کاربر برای ورود',
            'after' => 'به دقیقه وارد کنید',
            'default' => '10',
            'attributes' => array(
                'min' => '1',
                'max' => '100',
            )
        ),
        array(
            'id' => 'secure-login',
            'type' => 'notice',
            'class' => 'danger',
            'content' => 'توجه: اول از عملکرد سایت و فرم ورود در سایت خود اطمینان حاصل کنید و بعد گزینه "صفحه لاگین وردپرس" را فعال کنید.',
        ),
        array(
            'id' => 'wp-login-redirect',
            'type' => 'switcher',
            'title' => 'غیرفعال کردن صفحه لاگین وردپرس',
            'desc' => 'صفحه ورود پیشفرض در وردپرس غیرفعال شود.',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'user_email_required',
            'type' => 'switcher',
            'title' => 'برای ورود نیاز به تایید ایمیل باشد',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),

        array(
            'id' => 'user_can_change_email',
            'type' => 'switcher',
            'title' => 'تغییر ایمیل توسط کاربر',
            'desc' => 'کابر در پنل کاربری قادر به تغییر ایمیل خود باشد.',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'is_google_captcha',
            'type' => 'switcher',
            'title' => 'اعتبار سنجی گوگل',
            'desc' => 'سیستم ورود اعتبار سنجی گوگل برای جلوگیری از ورود ربات ها می باشد',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'google_captcha_sitekey',
            'type' => 'text',
            'title' => 'Site Key',
            'dependency' => array('is_google_captcha', '==', 'true'),
        ),
        array(
            'id' => 'google_captcha_secretkey',
            'type' => 'text',
            'title' => 'Secret Key',
            'dependency' => array('is_google_captcha', '==', 'true'),
        ),

        array(
            'id' => 'secure-login',
            'type' => 'notice',
            'class' => 'warning',
            'content' => 'برای دریافت مقدار ورودی برای سایت خود به این لینک https://www.google.com/recaptcha/admin مراجعه کنید',
            'dependency' => array('is_google_captcha', '==', 'true'),
        ),
//        array(
//            'id' => 'is_captcha_comment',
//            'type' => 'switcher',
//            'title' => 'اعتبار سنجی دیدگاه',
//            'desc' => 'برای ارسال دیدگاه گوگل کپتچا فعال باشد',
//            'dependency' => array('is_google_captcha', '==', 'true'),
//            'settings' => array(
//                'on' => 'بله',
//                'off' => 'خیر',
//            ),
//        ),
    ),
);
$options[] = array(
    'name' => 'ads',
    'title' => 'تبلیغات',
    'icon' => 'fa fa-adn',
    'sections' => array(
        array(
            'name' => 'home-ads',
            'title' => 'صفحه اصلی',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه اول',
                ),
                array(
                    'id' => 'show-home-ad-1',
                    'type' => 'switcher',

                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'homeads1',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'desc' => 'این جایگاه ابتدای صفحه نخست می باشد',
                    'button_title' => 'افزودن تبلیغ',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه دوم',
                ),
                array(
                    'id' => 'show-home-ad-2',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'homeads2',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'desc' => 'این جایگاه بعد از اسلایدر می باشد',
                    'button_title' => 'افزودن تبلیغ',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان  جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن  تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه سوم',
                ),
                array(
                    'id' => 'show-home-ad-3',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'homeads3',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه بعد از بلاک محصولات می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان  جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن  تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),

                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه چهارم',
                ),
                array(
                    'id' => 'show-home-ad-4',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'homeads4',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'desc' => 'این جایگاه بعد از بلاک مطالب 1 می باشد',
                    'button_title' => 'افزودن تبلیغ',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان  جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن  تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه پنجم',
                ),
                array(
                    'id' => 'show-home-ad-5',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'homeads5',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'desc' => 'این جایگاه بعد از بلاک مطالب 2 می باشد',
                    'button_title' => 'افزودن تبلیغ',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان  جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن  تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه ششم',
                ),
                array(
                    'id' => 'show-home-ad-6',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'homeads6',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'desc' => 'این جایگاه بعد از بلاک مطالب 3 می باشد',
                    'button_title' => 'افزودن تبلیغ',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان  جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن  تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه هفتم',
                ),
                array(
                    'id' => 'show-home-ad-7',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'homeads7',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'desc' => 'این جایگاه بعد از بلاک مطالب 4 می باشد',
                    'button_title' => 'افزودن تبلیغ',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان  جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن  تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه هشتم',
                ),
                array(
                    'id' => 'show-home-ad-8',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'homeads8',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'desc' => 'این جایگاه انتهای صفحه نخست می باشد',
                    'button_title' => 'افزودن تبلیغ',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان  جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن  تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),

            ),
        ),
        array(
            'name' => 'page-ads',
            'title' => 'برگه ها',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه اول',
                ),
                array(
                    'id' => 'show-page-ad-1',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'pageads1',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه دوم',
                ),
                array(
                    'id' => 'show-page-ad-2',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'pageads2',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه سوم',
                ),
                array(
                    'id' => 'show-page-ad-3',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'pageads3',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه بعد از بلاک محصولات می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه چهارم',
                ),
                array(
                    'id' => 'show-page-ad-4',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'pageads4',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه بعد از بلاک محصولات می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه پنجم',
                ),
                array(
                    'id' => 'show-page-ad-5',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'pageads5',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه بعد از بلاک محصولات می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه ششم',
                ),
                array(
                    'id' => 'show-page-ad-6',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'pageads6',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه بعد از بلاک محصولات می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
            ),
        ),
        array(
            'name' => 'shop-ads',
            'title' => 'فروشگاه',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه اول',
                ),
                array(
                    'id' => 'show-shop-ad-1',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'shopads1',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه ابتدای صفحه فروشگاه می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه دوم',
                ),
                array(
                    'id' => 'show-shop-ad-2',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'shopads2',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه انتهای صفحه فروشگاه می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
            ),
        ),
        array(
            'name' => 'single-ads',
            'title' => 'صفحه مطلب',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه اول',
                ),
                array(
                    'id' => 'show-single-ad-1',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'singleads1',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه ابتدای صفحه مطلب می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه دوم',
                ),
                array(
                    'id' => 'show-single-ad-2',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'singleads2',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه قبل از اسلایدر در صفحه نخست می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه سوم',
                ),
                array(
                    'id' => 'show-single-ad-3',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'singleads3',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه قبل از مطلب می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),

                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه چهارم',
                ),
                array(
                    'id' => 'show-single-ad-4',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'singleads4',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه بعد از مطلب می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),

                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه پنجم',
                ),
                array(
                    'id' => 'show-single-ad-5',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'singleads5',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه بعد از باکس دانلود می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),

                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه ششم',
                ),
                array(
                    'id' => 'show-single-ad-6',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'singleads6',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه بعد بیوگرافی نویسنده مطلب می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه هفتم',
                ),
                array(
                    'id' => 'show-single-ad-7',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'singleads7',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه بعد از دیدگاه ها در مطلب می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه هشتم',
                ),
                array(
                    'id' => 'show-single-ad-8',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'singleads8',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه انتهای صفحه مطلب می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
            ),
        ),
        array(
            'name' => 'product-ads',
            'title' => 'صفحه محصول',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه اول',
                ),
                array(
                    'id' => 'show-product-ad-1',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'productads1',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه ابتدای صفحه محصول می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه دوم',
                ),
                array(
                    'id' => 'show-product-ad-2',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'productads2',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه قبل از اسلایدر می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه سوم',
                ),
                array(
                    'id' => 'show-product-ad-3',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'productads3',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه قبل از تصویر محصول می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),

                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه چهارم',
                ),
                array(
                    'id' => 'show-product-ad-4',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'productads4',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه قبل از اطلاعات محصول می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),

                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه پنجم',
                ),
                array(
                    'id' => 'show-product-ad-5',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'productads5',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه بعد از اطلاعات محصول می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'جایگاه ششم',
                ),
                array(
                    'id' => 'show-product-ad-6',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'productads6',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'desc' => 'این جایگاه انتهای صفحه محصول می باشد',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
            ),
        ),
        array(
            'name' => 'myaccount',
            'title' => 'پنل کاربری',
            'fields' => array(
                array(
                    'type' => 'subheading',
                    'content' => 'ابتدای صفحه',
                ),
                array(
                    'id' => 'show-myaccount-ad-1',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'myaccountads1',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'انتهای صفحه',
                ),
                array(
                    'id' => 'show-myaccount-ad-2',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'myaccountads2',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'ابتدای سایدبار',
                ),
                array(
                    'id' => 'show-myaccount-ad-3',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'myaccountads3',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
                array(
                    'type' => 'subheading',
                    'content' => 'انتهای سایدبار',
                ),
                array(
                    'id' => 'show-myaccount-ad-4',
                    'type' => 'switcher',
                    'title' => 'نمایش جایگاه',
                    'desc' => 'در صورتی که تبلیغ در این جایگاه وجود نداشته باشد نیز نمایش داده نخواهد شد',
                    'settings' => array(
                        'on' => 'بله',
                        'off' => 'خیر',
                    ),
                ),
                array(
                    'id' => 'myaccountads4',
                    'type' => 'group',
                    'title' => 'تبلیغ',
                    'button_title' => 'افزودن تبلیغ',
                    'accordion_title' => 'subject',
                    'fields' => array(
                        array(
                            'id' => 'subject',
                            'type' => 'text',
                            'title' => 'عنوان',
                            'desc' => 'عنوان جنبه مدیریتی دارد و در سایت نمایش داده نمی شود.',
                        ),
                        array(
                            'id' => 'adphoto',
                            'type' => 'upload',
                            'title' => 'تصویر تبلیغ',
                            'settings' => array(
                                'upload_type' => 'image',
                                'button_title' => 'افزودن تصویر',
                                'frame_title' => 'تصویر را انتخاب کنید',
                                'insert_title' => 'انتخاب این تصویر',
                            ),
                        ),
                        array(
                            'id' => 'adlink',
                            'type' => 'text',
                            'title' => 'لینک ارجاع',
                            'info' => 'در صورت خالی بودن تبلیغ بدون لینک خواهد بود',
                        ),
                    )
                ),
            ),
        ),
    ),
);
$options[] = array(
    'name' => 'social',
    'title' => 'شبکه های اجتماعی',
    'icon' => 'fa fa-share-alt',
    'fields' => array(
        array(
            'id' => 'show-social-in-header',
            'type' => 'switcher',
            'title' => 'نمایش آیکن های شکه اجتماعی هدر',
            'desc' => 'آیکن های شبکه های اجتماعی در هدر نمایش داده شود.',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'show-social-in-footer',
            'type' => 'switcher',
            'title' => 'نمایش آیکن های شبکه اجتماعی فوتر',
            'desc' => 'آیکن های شبکه های اجتماعی در فوتر نمایش داده شود.',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'show-social-colored',
            'type' => 'switcher',
            'title' => 'آیکن های رنگی',
            'desc' => 'آیکن های شبکه های اجتماعی رنگی نمایش داده شود؟',
            'settings' => array(
                'on' => 'بله',
                'off' => 'خیر',
            ),
        ),
        array(
            'id' => 'social-instagram',
            'type' => 'text',
            'title' => 'نام کاربری اینستاگرام',
            'after' => 'https://instagram.com',
        ),
        array(
            'id' => 'social-telegram',
            'type' => 'text',
            'title' => 'نام کاربری تلگرام',
            'after' => 'https://t.me',
        ),
        array(
            'id' => 'social-facebook',
            'type' => 'text',
            'title' => 'نام کاربری فیس بوک',
            'after' => 'https://facebook.com',
        ),
        array(
            'id' => 'social-aparat',
            'type' => 'text',
            'title' => 'نام کاربری آپارات',
            'after' => 'https://www.aparat.com',
        ),
        array(
            'id' => 'social-google',
            'type' => 'text',
            'title' => 'نام کاربری گوگل پلاس',
            'after' => 'https://plus.google.com',
        ),

        array(
            'id' => 'social-twitter',
            'type' => 'text',
            'title' => 'نام کاربری توئیتر',
            'after' => 'https://twitter.com',
        ),
        array(
            'id' => 'social-pintrest',
            'type' => 'text',
            'title' => 'نام کاربری پینترست',
            'after' => 'https://www.pintrest.com',
        ),

    )
);
$options[] = array(
    'name' => 'translate',
    'title' => 'ترجمه',
    'icon' => 'fa fa-language',
    'fields' => array(
        array(
            'id' => 'translate-welcome',
            'type' => 'text',
            'title' => 'خوش آمدید',
        ),
        array(
            'id' => 'translate-whatsearch',
            'type' => 'text',
            'title' => 'دنبال چی می گردی؟',
        ),
        array(
            'id' => 'translate-signup',
            'type' => 'text',
            'title' => 'ثبت نام',
        ),
        array(
            'id' => 'translate-login',
            'type' => 'text',
            'title' => 'ورود',
        ),
        array(
            'id' => 'translate-gotohome',
            'type' => 'text',
            'title' => 'بازگشت به صفحه نخست',
        ),
        array(
            'id' => 'translate-learnvideo',
            'type' => 'text',
            'title' => 'آموزش ویدیویی',
        ),
        array(
            'id' => 'translate-morepost',
            'type' => 'text',
            'title' => 'ادامه مطلب',
        ),
        array(
            'id' => 'translate-blog',
            'type' => 'text',
            'title' => 'بلاگ',
        ),
        array(
            'id' => 'translate-socialmedia',
            'type' => 'text',
            'title' => 'شبکه های اجتماعی',
        ),
        array(
            'id' => 'translate-shoar',
            'type' => 'text',
            'title' => 'به جمع صد‌ها هزار نفری همراهان وردپرس بپیوندید.',
        ),
        array(
            'id' => 'translate-namad',
            'type' => 'text',
            'title' => 'نماد اعتماد',
        ),
        array(
            'id' => 'translate-free',
            'type' => 'text',
            'title' => 'رایگان',
        ),
        array(
            'id' => 'translate-moresubjects',
            'type' => 'text',
            'title' => 'عناوین بیشتر',
        ),
        array(
            'id' => 'translate-sale',
            'type' => 'text',
            'title' => 'فروش',
        ),
        array(
            'id' => 'translate-preview',
            'type' => 'text',
            'title' => 'پیشنمایش آنلاین',
        ),
        array(
            'id' => 'translate-preview',
            'type' => 'text',
            'title' => 'افزود به سبد خرید',
        ),
        array(
            'id' => 'translate-noproduct',
            'type' => 'text',
            'title' => 'محصولی وجود ندارد',
        ),
        array(
            'id' => 'translate-nopost',
            'type' => 'text',
            'title' => 'مطلبی وجود ندارد',
        ),
        array(
            'id' => 'translate-relatedpost',
            'type' => 'text',
            'title' => 'مطالب مرتبط',
        ),
        array(
            'id' => 'translate-productinfo',
            'type' => 'text',
            'title' => 'اطلاعات محصول',
        ),
        array(
            'id' => 'translate-createdate',
            'type' => 'text',
            'title' => 'تاریخ ثبت:',
        ),
        array(
            'id' => 'translate-updatedate',
            'type' => 'text',
            'title' => 'تاریخ بروزرسانی:',
        ),
        array(
            'id' => 'translate-countsale',
            'type' => 'text',
            'title' => 'تعداد فروش:',
        ),
        array(
            'id' => 'translate-countview',
            'type' => 'text',
            'title' => 'تعداد بازدید:',
        ),
        array(
            'id' => 'translate-countcomment',
            'type' => 'text',
            'title' => 'تعداد دیدگاه:',
        ),
        array(
            'id' => 'translate-filetype',
            'type' => 'text',
            'title' => 'نوع فایل:',
        ),
        array(
            'id' => 'translate-filesize',
            'type' => 'text',
            'title' => 'حجم فایل:',
        ),
        array(
            'id' => 'translate-pcategory',
            'type' => 'text',
            'title' => 'دسته:',
        ),
        array(
            'id' => 'translate-ptags',
            'type' => 'text',
            'title' => 'برچسب:',
        ),
        array(
            'id' => 'translate-download',
            'type' => 'text',
            'title' => 'دانلود',
        ),
    ),

);
$options[] = array(
    'name' => 'codes',
    'title' => 'کدهای شخصی سازی',
    'icon' => 'fa fa-code',
    'fields' => array(
        array(
            'id' => 'custom_css',
            'type' => 'textarea',
            'title' => 'کد های شخصی css',
            'attributes' => array(
                'rows' => 20,
                'style' => 'direction: ltr !important; text-align: left !important;'

            ),
        ),

        array(
            'id' => 'custom_js',
            'type' => 'textarea',
            'title' => 'کد های شخصی javascript',
            'attributes' => array(
                'rows' => 20,
                'style' => 'direction: ltr !important; text-align: left !important;'
            ),
        ),
    ),
);

$options[] = array(
    'name' => 'backup_section',
    'title' => 'پشتیبان گیری',
    'icon' => 'fa fa-shield',
    'fields' => array(
        array(
            'type' => 'notice',
            'class' => 'warning',
            'content' => 'شما در این قسمت می توانید تنظیمات فعلی خود را ذخیره کنید. پشتیبان تنظیمات را دانلود یا وارد کنید.',
        ),
        array(
            'type' => 'backup',
        ),
    )
);
CSFramework::instance($settings, $options);
