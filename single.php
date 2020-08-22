<?php
include "lang_config.php";
require "custom_php_functions/insert_text_inside_html_element.php"; 

$user_ad_code = '
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- index -->
    <ins class="adsbygoogle"
        style="display:inline-block;width:300px;height:250px"
        data-ad-client="ca-pub-3058408336389780"
        data-ad-slot="8118485095"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
';
    


// when you add another language you should add it here as well
$language = array(
    'en' => '361',
    'es' => '366',
    'fr' => '364',
    'ru' => '365',
    'ar' => '362',
    'zh' => '363'
);

// getting current link
$current_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$logged_in_user_id = get_current_user_id();

get_header();

// getting the language of the post
while(have_posts()) {
    the_post(); 
    $post_language = get_the_category()[1]->slug;
    
    //fetching likes and the dislikes of the current post
    $current_post_id = get_the_id();

}

// views sql query
$views = $wpdb->get_results("SELECT * FROM `_typ_posts` WHERE ID = $current_post_id")[0]->views;
$wpdb->update('_typ_posts', array('views' => $views + 1), array('ID'=>$current_post_id));

// knowing if the user already likes or disliked this article
$like_type = $wpdb->get_results ( "SELECT * FROM `_typ_likes` WHERE post_id = $current_post_id AND user_id = $logged_in_user_id" )[0]->like_type;
$likes = count($wpdb->get_results ( "SELECT * FROM `_typ_likes` WHERE post_id = $current_post_id AND like_type = 1" ));
$dislikes = count($wpdb->get_results ( "SELECT * FROM `_typ_likes` WHERE post_id = $current_post_id AND like_type = 2" ));

// <><><><><><><><><><><><><> this is the reversed template for arabic and farsi and hebrew (rtl) etc... <><><><><><><><><><><><><><><><><>

if($post_language == 'ar'){

while(have_posts()) {
the_post(); 

// sql command to fetch id_key //////////////////////////////////////////////////////////////
global $wpdb;

$table_name = '_typ_users';
$user_id = get_the_author_meta( 'ID' );

$result = $wpdb->get_results ( "SELECT * FROM $table_name WHERE ID = $user_id" );

// sql command to fetch id_key //////////////////////////////////////////////////////////////

// getting user image url from data base
$db_results = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $user_id" );
$profile_image = $db_results[0]->profile_picture;
$current_user_image = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $logged_in_user_id" )[0]->profile_picture;

// getting subscribe info
$result_two = $wpdb->get_results ( "SELECT * FROM `_typ_subscribers` WHERE subscriber = $logged_in_user_id AND subscribed_to = $user_id" )[0]->subscriber;

?>

    <main dir="rtl" data-language="<?php foreach(get_the_category() as $item){foreach($language as $n){if($n == $item->term_id){echo $n;}}} ?>">
        <div class="article_container" id="aticle_page">
            <div class="first_column first_column_rtl" data-userpostid="<?php echo $user_id; ?>" data-currentpostid="<?php echo $current_post_id; ?>" style="margin-right: 0px;">
                <div class="article_header_container">
                    <div class="article_title" dir="auto"><?php the_title() ?></div>
                    <div dir="ltr" class="header_buttons_container">
                        <div class="buttons_left_side">
                            <div class="article_date" ><?php the_time('d.m.Y') ?></div>
                            <div class="article_views">&nbsp;|&nbsp;<?php echo $views; ?>&nbsp;<img src="https://typout.com/wp-content/themes/typout/img/views_black.svg" style="height: 15px; width: 15px; margin-bottom: -2.5px;"></div>
                        </div>
                        <div class="buttons_right_side">
                            <div class="article_like <?php if($like_type == 1){echo "clicked";} ?>" style="background-image: url(<?php echo get_theme_file_uri('/img/like_button.svg') ?>);"><?php echo $likes ?></div>
                            <div class="article_dislike <?php if($like_type == 2){echo "clicked";} ?>"style="background-image: url(<?php echo get_theme_file_uri('/img/dislike_button.svg') ?>);"><?php echo $dislikes ?></div>
                            <img style="display: none;" src="<?php echo get_theme_file_uri('/img/like_indicator/sad_face.svg') ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="social_media_place" dir="ltr">
                    <a style="background-image: url('https://typout.com/wp-content/themes/typout/img/facebook_icon.svg'); background-color: #CED5E5;" href="http://www.facebook.com/sharer.php?u=<?php echo $current_link; ?>" target="_blank"></a>
                    <a style="background-image: url('https://typout.com/wp-content/themes/typout/img/twitter_icon.svg'); background-color: #BFEAFA;" href="https://twitter.com/share?url=<?php echo $current_link; ?>&amp;text=<?php echo get_the_title(); ?>&amp;hashtags=typout" target="_blank"></a>
                    <a style="background-image: url('https://typout.com/wp-content/themes/typout/img/vkontakte_icon.svg'); background-color: #D3DFED;" href="http://vkontakte.ru/share.php?url=<?php echo $current_link; ?>" target="_blank"></a>
                    <a style="background-image: url('https://typout.com/wp-content/themes/typout/img/thumbler_icon.svg'); background-color: #C9D0D6;" href="http://www.tumblr.com/share/link?url=<?php echo $current_link; ?>&amp;title=<?php echo get_the_title(); ?>" target="_blank"></a>
                    <a style="background-image: url('https://typout.com/wp-content/themes/typout/img/reddit_icon.svg'); background-color: #FECFC5;" href="http://reddit.com/submit?url=<?php echo $current_link; ?>&amp;title=<?php echo get_the_title(); ?>" target="_blank"></a>
                    <a style="background-image: url('https://typout.com/wp-content/themes/typout/img/linkedin_icon.svg'); background-color: #BFDDEC;" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $current_link; ?>" target="_blank"></a>
                </div>
                <div class="post_thumbnail_container" style="background-image: url('<?php echo the_post_thumbnail_url() ?>');"></div>
                <div class="article_author_bar">
                    <div class="author_bar_left_side">
                        <div class="for_flex">
                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>"><img src="<?php if($profile_image){echo $profile_image;}else{echo 'https://typout.com/wp-content/themes/typout/img/default_profile.svg';} ?>" alt=""></a>
                            <div class="two_text" style="margin-left: none; margin-right: 10px;">
                                <p class="first_bar_text author"><?php the_author_posts_link() ?></p>
                                <p style="display: none;" class="second_bar_text">... <?php echo $lang[18]; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="subscriber_button" <?php if($user_id == $logged_in_user_id){echo 'style="display: none;"';} ?> data-subscribe="<?php echo $lang[19]; ?>" data-subscribed="<?php echo $lang[127]; ?>" <?php if($result_two){echo 'style="background-color: #e3e3e3"';}else{} ?> ><p><?php if($result_two){echo $lang[127];}else{echo $lang[19];} ?></p></div>
                </div>
                <article class="article_place" dir="auto">
                    <?php
                    echo $user_ad_code;
                    echo get_the_content();
                    // echo html_insert(get_the_content(), '</div>', $user_ad_code, 1);
                    ?>
                </article>
            <?php } //the end of the article page loop ?>

                <div class="comment_section_place"><div class="comment_section_title"><?php echo $lang[20]; ?></div>
                    <div class="comment_input">
                        <div class="comment_input_left_side" style="padding: 0 0 0 10px"> 
                            <div class="profile_image_in_comments" style='background-image: url("<?php if($current_user_image){echo $current_user_image;}else{echo 'https://typout.com/wp-content/themes/typout/img/default_profile.svg';} ?>")'></div>
                            <div class="comment_text_input" style="margin: 0 5px 0 0"><input class="the_input" type="text" placeholder="<?php echo $lang[128] ?>..."></div>
                        </div>
                        <div class="comment_button" data-currentimageurl="<?php if($current_user_image){echo $current_user_image;}else{echo 'https://typout.com/wp-content/themes/typout/img/default_profile.svg';} ?>" data-currentuserdisplayname="<?php echo get_user_by( "ID", get_current_user_id() )->display_name ; ?>"><p><?php echo $lang[21]; ?></p></div>
                    </div>
                    <div class="comment_loop_place">
                        <?php
                        $comment_query = array(
                            "post_id" => $current_post_id,
                            "number" => 10
                        );
                        $comments = get_comments($comment_query); 
                        foreach($comments as $comment){
                            $current_user_profile_picture = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $comment->user_id" )[0]->profile_picture;
                            ?>
                            <div class="comment_loop_header">
                                <div class="comment_header_left_side">
                                    <div class="profile_image_in_comments" style='background-image: url("<?php if($current_user_profile_picture){echo $current_user_profile_picture;}else{echo 'https://typout.com/wp-content/themes/typout/img/default_profile.svg';} ?>)'></div>
                                    <p style="margin: 0 7.5px 0 0;"><?php echo get_user_by( "ID", $comment->user_id )->display_name ; ?></p> 
                                </div>
                                <div class="comment_header_right_side" style="display: none;"><img src="" alt=""></div>
                            </div>
                            <div class="comment_loop_body" style="margin-bottom: 15px;"> 
                                <div class="comment_body_text"><?php echo $comment->comment_content; ?></div>
                            </div>
                        <?php
                        } ?>
                    </div>
                </div>
            </div>
            <div class="second_column">
                <div class="comment_section_title"><?php echo $lang[26]; ?></div>
                <div class="side_bar_posts_container"></div>
                <div id="hidden_box"></div>
            </div>
        </div>
    </main>

<?php // <><><><><><><><><><><><><><><><> this is the normal template for english and most languages (ltr) etc...<><><><><><><><><><><><><><><><>
}else{

while(have_posts()) {
the_post(); 

// sql command to fetch id_key //////////////////////////////////////////////////////////////
global $wpdb;

$table_name = '_typ_users';
$user_id = get_the_author_meta( 'ID' );

// sql command to fetch id_key //////////////////////////////////////////////////////////////

// getting user image url from data base
$db_results = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $user_id" );
$profile_image_eng = $db_results[0]->profile_picture;

?>

    <main data-language="<?php foreach(get_the_category() as $item){foreach($language as $n){if($n == $item->term_id){echo $n;}}} ?>">
        <div class="article_container" id="aticle_page">
            <div class="first_column" data-userpostid="<?php echo $user_id; ?>" data-currentpostid="<?php echo $current_post_id; ?>">
                <div class="article_header_container">
                    <div class="article_title" dir="auto"><?php the_title() ?></div>
                    <div class="header_buttons_container">
                        <div class="buttons_left_side">
                            <div class="article_date" ><?php the_time('d.m.Y') ?></div>
                            <div class="article_views">&nbsp;|&nbsp;<?php echo $views; ?>&nbsp;<img src="https://typout.com/wp-content/themes/typout/img/views_black.svg" style="height: 15px; width: 15px; margin-bottom: -2.5px;"></div>
                        </div>
                        <div class="buttons_right_side">
                        <div class="article_like <?php if($like_type == 1){echo "clicked";} ?>" style="background-image: url(<?php echo get_theme_file_uri('/img/like_button.svg') ?>);"><?php echo $likes ?></div>
                            <div class="article_dislike <?php if($like_type == 2){echo "clicked";} ?>"style="background-image: url(<?php echo get_theme_file_uri('/img/dislike_button.svg') ?>);"><?php echo $dislikes ?></div>
                            <img style="display: none;" src="<?php echo get_theme_file_uri('/img/like_indicator/sad_face.svg') ?>" alt="">
                        </div>
                    </div>
                </div>
                <div class="social_media_place" dir="ltr">
                    <a style="background-image: url('https://typout.com/wp-content/themes/typout/img/facebook_icon.svg'); background-color: #CED5E5;" href="http://www.facebook.com/sharer.php?u=<?php echo $current_link; ?>" target="_blank"></a>
                    <a style="background-image: url('https://typout.com/wp-content/themes/typout/img/twitter_icon.svg'); background-color: #BFEAFA;" href="https://twitter.com/share?url=<?php echo $current_link; ?>&amp;text=<?php echo get_the_title(); ?>&amp;hashtags=typout" target="_blank"></a>
                    <a style="background-image: url('https://typout.com/wp-content/themes/typout/img/vkontakte_icon.svg'); background-color: #D3DFED;" href="http://vkontakte.ru/share.php?url=<?php echo $current_link; ?>" target="_blank"></a>
                    <a style="background-image: url('https://typout.com/wp-content/themes/typout/img/thumbler_icon.svg'); background-color: #C9D0D6;" href="http://www.tumblr.com/share/link?url=<?php echo $current_link; ?>&amp;title=<?php echo get_the_title(); ?>" target="_blank"></a>
                    <a style="background-image: url('https://typout.com/wp-content/themes/typout/img/reddit_icon.svg'); background-color: #FECFC5;" href="http://reddit.com/submit?url=<?php echo $current_link; ?>&amp;title=<?php echo get_the_title(); ?>" target="_blank"></a>
                    <a style="background-image: url('https://typout.com/wp-content/themes/typout/img/linkedin_icon.svg'); background-color: #BFDDEC;" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $current_link; ?>" target="_blank"></a>
                </div>
                <div class="post_thumbnail_container" style="background-image: url('<?php echo the_post_thumbnail_url() ?>');"></div>
                <div class="article_author_bar">
                    <div class="author_bar_left_side">
                        <div class="for_flex">
                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')) ?>"><img src="<?php if($profile_image_eng){echo $profile_image_eng;}else{echo 'https://typout.com/wp-content/themes/typout/img/default_profile.svg';} ?>" alt=""></a>
                            <div class="two_text">
                                <p class="first_bar_text author"><?php the_author_posts_link() ?></p>
                                <p style="display: none;" class="second_bar_text">... <?php echo $lang[18]; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="subscriber_button" <?php if($user_id == $logged_in_user_id){echo 'style="display: none;"';} ?> data-subscribe="<?php echo $lang[19]; ?>" data-subscribed="<?php echo $lang[127]; ?>" <?php if($result_two){echo 'style="background-color: #e3e3e3"';}else{} ?> ><p><?php if($result_two){echo $lang[127];}else{echo $lang[19];} ?></p></div>
                </div>
                <article class="article_place" dir="auto">
                    <?php
                    echo $user_ad_code;
                    echo get_the_content();
                    // echo html_insert(get_the_content(), '</div>', $user_ad_code, 1); 
                    ?>
                </article>
            <?php } //the end of the article page loop ?>

                <div class="comment_section_place">
                    <div class="comment_section_title"><?php echo $lang[20]; ?></div>
                    <div class="comment_input">
                        <div class="comment_input_left_side">
                            <div class="profile_image_in_comments" style='background-image: url("<?php if($current_user_image){echo $current_user_image;}else{echo 'https://typout.com/wp-content/themes/typout/img/default_profile.svg';} ?>")'></div>
                            <div class="comment_text_input"><input class="the_input" type="text" placeholder="<?php echo $lang[128] ?>..."></div>
                        </div>
                        <div class="comment_button" data-currentimageurl="<?php if($current_user_image){echo $current_user_image;}else{echo 'https://typout.com/wp-content/themes/typout/img/default_profile.svg';} ?>" data-currentuserdisplayname="<?php echo get_user_by( "ID", get_current_user_id() )->display_name ; ?>"><p><?php echo $lang[21]; ?></p></div>
                    </div>
                    <div class="comment_loop_place">
                        <?php
                        $comment_query = array(
                            "post_id" => $current_post_id,
                            "number" => 10
                        );
                        $comments = get_comments($comment_query); 
                        foreach($comments as $comment){
                            $current_user_profile_picture = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $comment->user_id" )[0]->profile_picture;
                            ?>
                            <div class="comment_loop_header">
                                <div class="comment_header_left_side">
                                    <div class="profile_image_in_comments" style='background-image: url("<?php if($current_user_profile_picture){echo $current_user_profile_picture;}else{echo 'https://typout.com/wp-content/themes/typout/img/default_profile.svg';} ?>)'></div>
                                    <p style="margin: 0 7.5px 0 0;"><?php echo get_user_by( "ID", $comment->user_id )->display_name ; ?></p> 
                                </div>
                                <div class="comment_header_right_side" style="display: none;"><img src="" alt=""></div>
                            </div>
                            <div class="comment_loop_body" style="margin-bottom: 15px;"> 
                                <div class="comment_body_text"><?php echo $comment->comment_content; ?></div>
                            </div>
                        <?php
                        } ?>
                    </div>
                </div>
            </div>
            <div class="second_column">
                <div class="comment_section_title"><?php echo $lang[26]; ?></div>
                <div class="side_bar_posts_container"></div>
                <div id="hidden_box"></div>
            </div>
        </div>
    </main>
<?php }
    get_footer();
?>