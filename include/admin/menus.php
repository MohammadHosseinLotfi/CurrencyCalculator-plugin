<?php
add_action('admin_menu', 'Currency_Calculator_Register_Menus');
// CurrencyCalculator
function Currency_Calculator_Register_Menus()
{
    add_menu_page(
        'Display_Currency',
        'محاسبه گر ارزها',
        'manage_options',
        'Currnecy_Calculator_Menu',
        'CurrencyCalculator_main_menu_handler'
    );
    add_submenu_page(
        'Currnecy_Calculator_Menu',
        'تنیمات عمومی',
        'تنظیمات عمومی',
        'manage_options',
        'general_Setting',
        'CurrencyCalculator_general_setting_handler'
    );
}

function CurrencyCalculator_main_menu_handler() {
   include WP_CC_TPL . 'admin/main.php';
}

function CurrencyCalculator_general_setting_handler() {
    include WP_CC_TPL . 'admin/generalSetting.php';
}
?>
