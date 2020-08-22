<?php include "lang_config.php";

// getting the wp_user object of the current profile page
$curauth = ( get_query_var( 'author_name' ) ) ? get_user_by( 'slug', get_query_var( 'author_name' ) ) : get_userdata( get_query_var( 'author' ) );
$page_user_id = $curauth->ID;
// return a boolean if its or its not the logged in user's page
$is_current_user_page = get_current_user_id() == $curauth->ID;
$logged_in_user_id = get_current_user_id();
// getting cover image url from data base
$db_results = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $curauth->ID" );
$cover_image = $db_results[0]->cover_picture;
$profile_image = $db_results[0]->profile_picture;
// getting the number of subscribers
$result_two = count($wpdb->get_results ( "SELECT * FROM `_typ_subscribers` WHERE subscribed_to = $page_user_id" ));
// getting subscribe info
$result_one = $wpdb->get_results ( "SELECT * FROM `_typ_subscribers` WHERE subscriber = $logged_in_user_id AND subscribed_to = $page_user_id" )[0]->subscriber;

?>

<?php get_header(); ?>

<! –– start main ––>

<div class="main_user_page">
    <?php if($is_current_user_page){echo '<label for="cover_image">';} ?>
        <div class="profile_cover<?php if($is_current_user_page){echo " hover_effect";} ?>" style="background-image: url('<?php if($is_current_user_page){echo "https://typout.com/wp-content/themes/typout/img/upload_image_icon.svg";} ?>'), url('<?php if($cover_image){echo $cover_image;}else{echo 'https://typout.com/wp-content/themes/typout/img/defalt_cover.svg';} ?>');"></div>
    <?php if($is_current_user_page){echo '</label>';} ?>
    <input style="display: none;" id="cover_image" name="cover_image" type="file">
    <div class="user_bar">
        <div class="user_bar_container">
            <div class="left_bar_side">
                <?php if($is_current_user_page){echo '<label for="profile_image">';} ?>
                    <div class="profile_image_container<?php if($is_current_user_page){echo " hover_effect_profile_picture";} ?>" style="background-image: url('<?php if($is_current_user_page){echo "https://typout.com/wp-content/themes/typout/img/upload_image_icon.svg";} ?>'), url('<?php if($profile_image){echo $profile_image;}else{echo 'https://typout.com/wp-content/themes/typout/img/default_profile.svg';} ?>');"></div>
                <?php if($is_current_user_page){echo '</label>';} ?>
                <input style="display: none;" id="profile_image" name="profile_image" type="file">
                <div class="user_profile_information">
                    <p class="profile_name">
                        <?php echo $curauth->display_name; ?>
                    </p>
                    <p class="subscribers_count"><?php echo $result_two . "&nbsp;" . $lang[28]; ?></p>
                </div>
            </div>
            <div class="right_bar_side">
            <div class="subscriber_button" <?php if($is_current_user_page){echo 'style="display: none;"';} ?> data-userpageid="<?php echo $page_user_id; ?>" data-subscribe="<?php echo $lang[19]; ?>" data-subscribed="<?php echo $lang[127]; ?>" <?php if($result_one){echo 'style="background-color: #e3e3e3"';}else{} ?> ><p><?php if($result_one){echo $lang[127];}else{echo $lang[19];} ?></p></div>
            </div>
        </div>
    </div>
    <div class="nav_and_posts" data-pageUserId="<?php echo $page_user_id ?>"></div>
    <div id="hidden_box"></div>
</div>
<! –– END MAIN ––>

<?php get_footer(); ?>