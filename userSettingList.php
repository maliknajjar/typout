<?php $uri = $_SERVER['REQUEST_URI'];?>
<div class="user_control_panel_side_bar">
    <div class="profile_image_section_in_side_bar">
        <div class="profile_image_part" style="background-image: url('https://typout.com/wp-content/themes/typout/img/default_profile.svg');"></div>
        <div class="profile_name_part"><?php echo $current_user->display_name ?></div>
    </div>
    <div class="setting_list_in_side_bar">
        <a href="https://typout.com/articles/"><div class="first_in_list <?php if($uri == "/articles" . "/"){echo "selected_page_in_control_panel";} ?>" style="background-image: url(<?php echo get_theme_file_uri('/img/articles_icon.svg') ?>);"><?php echo $lang[34]; ?></div></a>
        <a href="#"><div class="second_in_list" style="display: none; background-image: url(<?php echo get_theme_file_uri('/img/analytics_icon.svg') ?>);"><?php echo $lang[35]; ?></div></a>
        <a href="https://typout.com/advertisement/?Transactions"><div class="third_in_list <?php if(strpos($uri, 'advertisement') !== false){echo "selected_page_in_control_panel";} ?>" style="background-image: url(<?php echo get_theme_file_uri('/img/ads_icon_for_settings.svg') ?>);"><?php echo $lang[36]; ?></div></a>
        <a href="https://typout.com/profile/"><div class="fourth_in_list <?php if($uri == "/profile" . "/"){echo "selected_page_in_control_panel";} ?>" style="background-image: url(<?php echo get_theme_file_uri('/img/profile_icon.svg') ?>);"><?php echo $lang[37]; ?></div></a>
        <a href="#"><div class="fifth_in_list" style="display: none; background-image: url(<?php echo get_theme_file_uri('/img/settings_icon.svg') ?>);"><?php echo $lang[38]; ?></div></a>
    </div>
</div>