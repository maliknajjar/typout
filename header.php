<?php include "lang_config.php";

global $wpdb;

// generating new id_key in data base

global $newcode;
// sql command
if(is_user_logged_in()){
    $id = get_current_user_id();
    $result = $wpdb->get_results ( "SELECT * FROM $table_name WHERE ID = $id" );
    $user_id_key = $result[0]->id_key;

    if($_SESSION['is_generated'] == 0){
        $newcode = uniqid("", true);
        $table_name = '_typ_users';
        $data_update = array('id_key' => $newcode);
        $data_where = array('ID' => get_current_user_id());
        $wpdb->update($table_name , $data_update, $data_where);
        $_SESSION['is_generated'] = 1;
        //echo "new code is generated"; 
    }else{
        $newcode = $user_id_key;
        //echo "no new code was generated";
    }
}

// getting current url logic
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
        $url = "https://";   
else  
        $url = "http://";   
// Append the host(domain name, ip) to the URL.   
$url.= $_SERVER['HTTP_HOST'];   

// Append the requested resource location to the URL   
$url.= $_SERVER['REQUEST_URI'];
// removing get request from $url if there is one
if(explode("?", $url)[1]){
    $url = explode("?", $url)[0];
}

// getting user image url from data base
$current_user_id = get_current_user_id();
$db_results = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $current_user_id" );
$profile_image = $db_results[0]->profile_picture;

?>   

<!DOCTYPE html>
<html>
  <head>
    <?php wp_head();?>
    <link rel="shortcut icon" type="image/png" href="https://typout.com/wp-content/themes/typout/img/typout_icon.png"/>
    <link href="https://fonts.googleapis.com/css?family=Almarai&display=swap" rel="stylesheet">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="7f1kWkDBg_rHV-5o_CkS1T5ZJl6gQxj9at0u4-H5XPU" />
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-46112375-4"></script>
    <script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', 'UA-46112375-4');
    </script>
    <!-- for adsense account -->
        <script data-ad-client="ca-pub-3058408336389780" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- for adsense account -->
  </head>
  <body>
    <header class="site_header" data-userpostid="<?php echo $user_id; ?>" data-usercodeid="<?php echo $newcode ?>" data-userid="<?php echo get_current_user_id() ?>">
        <div class="header-container">
            <div class="header-left">
                <div class="language" style="background-image: url(<?php echo get_theme_file_uri('img/language_icon.svg') ?>), url(<?php echo get_theme_file_uri('img/language_icon2.svg') ?>);"><p class="chosen_language"><?php echo $lang[0]; ?></p></div>
                <div class="website_language_list" style="display: none;">
                <?php if(is_user_logged_in()){ ?>
                    <p data-lang="en">English</p>
                    <p data-lang="ar">العربية</p>
                    <p data-lang="zh" style="display: none;">中文</p>
                    <p data-lang="fr" >Français</p>
                    <p data-lang="ru" style="display: none;">Pусский</p>
                    <p data-lang="es" style="display: none;">Español</p>
                <?php }else{ ?>
                    <a href="<?php echo $url . "?lang=en"; ?>"><p>English</p></a>
                    <a href="<?php echo $url . "?lang=ar"; ?>"><p>العربية</p></a>
                    <a href="<?php echo $url . "?lang=zh"; ?>" style="display: none;"><p>中文</p></a>
                    <a href="<?php echo $url . "?lang=fr"; ?>"><p>Français</p></a>
                    <a href="<?php echo $url . "?lang=ru"; ?>" style="display: none;"><p>Pусский</p></a>
                    <a href="<?php echo $url . "?lang=es"; ?>" style="display: none;"><p>Español</p></a>
                <?php } ?>
                </div>
                <div class="search">
                    <form autocomplete="off" role="search" method="get" action="https://typout.com/">
                        <input type="text" value="" name="s" placeholder="<?php echo $lang[17]; ?>" id="search_input">
                        <button type="submit" value="Search">
                            <img class="search_img" src="<?php echo get_theme_file_uri('/img/search_icon.svg') ?>" alt="">
                        </button>
                        <div class="mobile_search">
                            <img class="search_img_mobile" src="<?php echo get_theme_file_uri('/img/search_icon.svg') ?>" alt="">
                        </div>
                    </form>
                </div>
            </div>
            <div class="header-center">
                <a href="<?php echo site_url() ?>"><img src="<?php echo get_theme_file_uri('/img/logo.svg') ?>" alt=""></a>
            </div>
            <div class="header-right" data-saving="<?php echo $lang[72]; ?>" data-publishing="<?php echo $lang[73]; ?>">
                <?php if(explode('?', $_SERVER['REQUEST_URI'], 2)[0] == '/'.'editor/'){ ?>
                    <?php if(get_post_status(explode('=', $_SERVER['REQUEST_URI'], 2)[1]) == "draft"){ ?>
                        <div id="draft_button" class="create_post" style="background-color: #670700; background-image: url(<?php echo get_theme_file_uri('/img/save_icon.svg') ?>);"><?php echo $lang[1]; ?></div>
                    <?php }else{ ?>
                        <div id="draft_button" class="create_post" style="background-image: url(<?php echo get_theme_file_uri('/img/save_icon.svg') ?>);"><?php echo $lang[2]; ?></div>
                    <?php } ?>
                <?php }else{?>
                    <?php if(is_user_logged_in()){ ?>
                    <a href="https://typout.com/editor/"><div class="create_post" style="margin-top:7px; background-image: url(<?php echo get_theme_file_uri('/img/create_post.svg') ?>);"><?php echo $lang[3]; ?></div></a>
                    <?php }else{ ?>
                    <a href="https://typout.com/register/"><div class="create_post" style="background-image: url(<?php echo get_theme_file_uri('/img/create_account_icon.svg') ?>);"><?php echo $lang[4]; ?></div></a>
                    <?php } ?>
                <?php } ?>
                <?php if(is_user_logged_in()){?>
                    <?php if(explode('?', $_SERVER['REQUEST_URI'], 2)[0] == '/'.'editor/'){?>
                        <?php if(explode('=', $_SERVER['REQUEST_URI'], 2)[1]){ ?>
                            <?php if(get_post_status(explode('=', $_SERVER['REQUEST_URI'], 2)[1]) == "draft"){ ?>
                            <div id="create_post_button" class="create_post" style="background-image: url(<?php echo get_theme_file_uri('/img/save_post.svg') ?>); background-color: white; border: 1.6px solid black; color: black; line-height: 24px; margin-left: 10px;" data-text="<?php echo $lang[5]; ?>"><?php echo $lang[5]; ?></div>
                            <?php }else{?>
                            <div id="create_post_button" class="create_post" style="background-image: url(<?php echo get_theme_file_uri('/img/save_post.svg') ?>); background-color: #DDFFCB; border: 1.6px solid black; color: black; line-height: 24px; margin-left: 10px;" data-text="<?php echo $lang[5]; ?>"><?php echo $lang[6]; ?></div>
                            <?php } ?>
                        <?php }else{?><div id="create_post_button" class="create_post" style="background-image: url(<?php echo get_theme_file_uri('/img/save_post.svg') ?>); background-color: white; border: 1.6px solid black; color: black; line-height: 24px; margin-left: 10px;" data-text="<?php echo $lang[5]; ?>"><?php echo $lang[7]; ?></div><?php } ?>
                    <?php } ?>
                <?php 
                $new_notification = $wpdb->get_results( "SELECT * FROM `_typ_notifications` WHERE user_id = $current_user_id AND seen = 0 LIMIT 1" )[0];
                ?>
                <div class="notification_bell" style='background-image: url("<?php if($new_notification){echo "https://typout.com/wp-content/themes/typout/img/bell_on.svg";}else{echo "https://typout.com/wp-content/themes/typout/img/bell.svg";} ?>");'></div>
                <div class="menu_for_bell_icon" style="display: none;">
                    <div class="notification_title" dir="auto" style="font-weight: bold; border-bottom: 1.6px solid black;"><?php echo $lang[133]; ?></div> 
                    <div class="notifications_container" style="padding: 0;">
                    <?php 
                    $notitfications = $wpdb->get_results( "SELECT * FROM `_typ_notifications` WHERE user_id = $current_user_id ORDER BY Date DESC LIMIT 15" );
                    if($notitfications){
                        
                        foreach($notitfications as $item){
                            $creator_user_id = $item->creator_id;
                            $the_user_id = get_userdata($creator_user_id);
                            if($item->purpose == "post"){
                                if($_SESSION['lang'] == "ar"){
                                    ?>
                                    <?php echo '<a href="' . get_permalink($item->post_id) . '">' . '<div dir="rtl">' . $the_user_id->data->display_name . " " . $lang[132] . get_the_title($item->post_id) . '</div>' . '</a>'; ?>
                                    <?php 
                                }else{
                                    ?>
                                    <?php echo '<a href="' . get_permalink($item->post_id) . '">' . '<div>' . $the_user_id->data->display_name . " " . $lang[132] . get_the_title($item->post_id) . '</div>' . '</a>'; ?>
                                    <?php
                                }
                            }
                        }
                    }else{echo '<div style="text-align: center;">لا توجد لديك اية اشعارات</div>';}
                    ?>
                    </div>
                </div>
                <div class="header_image_container">
                    <img src="<?php if($profile_image){echo $profile_image;}else{echo 'https://typout.com/wp-content/themes/typout/img/default_profile.svg';} ?>" alt="">
                    <div class="menu_for_image_container" style="display: none;">
                        <ul>
                            <a href="<?php echo get_author_posts_url(get_current_user_id()); ?>"><p style="border-top: none;"><?php echo $lang[98]; ?></p></a>
                            <a href="https://typout.com/articles/"><p><?php echo $lang[8]; ?></p></a>
                            <a href="https://typout.com/advertisement/?Transactions"><p><?php echo $lang[10]; ?></p></a>
                            <a href="https://typout.com/profile/"><p><?php echo $lang[11]; ?></p></a>
                            <?php/*
                            <a href="https://typout.com/articles/"><p><?php echo $lang[12]; ?></p></a>
                            */?>
                            <a href="<?php echo wp_logout_url("https://typout.com/") ?>"><p style="color: red; border-bottom: none;"><?php echo $lang[74]; ?></p></a>
                        </ul>
                    </div>
                </div>
                <?php }else{ ?>
                <a href="<?php echo "https://typout.com/login/" ?>"><div class="account" style="background-image: url(<?php echo get_theme_file_uri('/img/account_icon.svg') ?>); margin-top: 0 ;"><p><?php echo $lang[13]; ?></p></div></a>
                <?php } ?>
            </div>
        </div>
    </header>
    
    <div class="site_prompt_container" style="display: none;">
        <div class="site_prompt">
            <div class="prompt_title"><p><?php echo $lang[14]; ?></p></div>
            <div class="first_yes_no_container">
                <div class="yes_no_container">
                    <div id="no" style="background-color: #ff8080;"><?php echo $lang[15]; ?></div>
                    <div id="yes" style="background-color: #82ff80;"><?php echo $lang[16]; ?></div>
                </div>
            </div>                         
        </div>
        <div class="site_prompt_background"></div>  
    </div>

    <div class="save_alert_container">
        <div class="save_notification" style="display: none;"><?php echo $lang[56]; ?></div>
    </div>

    <?php
    if($_GET['share_notification'] == "true"){
        $this_current_link = explode("?", "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
        $this_current_link = $this_current_link[0];
        ?> 
        <div class="site_prompt_container" style="display: flex;">
            <div class="site_prompt" style="">
                <div style="position: absolute; top: 5px; left: 10px; font-size: 30px; cursor: pointer;" onclick="this.parentNode.parentNode.remove()">x</div>
                <div dir="auto" style="font-size: 20px; margin-bottom: 15px; line-height: 150%;">
                    قم بنشر مقالك على مواقع التواصل الاجتماعي لزيادة أرباحكم
                </div>
                <div class="social_media_place" style="display: flex; border: none; height: unset;" dir="ltr">
                    <a style="margin-right: 10px; width: 60px; padding-bottom: 13%; border-radius: 50%; border: solid 1.6px black; background-image: url('https://typout.com/wp-content/themes/typout/img/facebook_icon.svg'); background-color: #CED5E5;" href="http://www.facebook.com/sharer.php?u=<?php echo $this_current_link; ?>" target="_blank"></a>
                    <a style="margin-right: 10px; width: 60px; padding-bottom: 13%; border-radius: 50%; border: solid 1.6px black; background-image: url('https://typout.com/wp-content/themes/typout/img/twitter_icon.svg'); background-color: #BFEAFA;" href="https://twitter.com/share?url=<?php echo $this_current_link; ?>&amp;text=<?php echo get_the_title(); ?>&amp;hashtags=typout" target="_blank"></a>
                    <a style="margin-right: 10px; width: 60px; padding-bottom: 13%; border-radius: 50%; border: solid 1.6px black; background-image: url('https://typout.com/wp-content/themes/typout/img/vkontakte_icon.svg'); background-color: #D3DFED;" href="http://vkontakte.ru/share.php?url=<?php echo $this_current_link; ?>" target="_blank"></a>
                    <a style="margin-right: 10px; width: 60px; padding-bottom: 13%; border-radius: 50%; border: solid 1.6px black; background-image: url('https://typout.com/wp-content/themes/typout/img/thumbler_icon.svg'); background-color: #C9D0D6;" href="http://www.tumblr.com/share/link?url=<?php echo $this_current_link; ?>&amp;title=<?php echo get_the_title(); ?>" target="_blank"></a>
                    <a style="margin-right: 10px; width: 60px; padding-bottom: 13%; border-radius: 50%; border: solid 1.6px black; background-image: url('https://typout.com/wp-content/themes/typout/img/reddit_icon.svg'); background-color: #FECFC5;" href="http://reddit.com/submit?url=<?php echo $this_current_link; ?>&amp;title=<?php echo get_the_title(); ?>" target="_blank"></a>
                    <a style="width: 60px; padding-bottom: 13%; border-radius: 50%; border: solid 1.6px black; background-image: url('https://typout.com/wp-content/themes/typout/img/linkedin_icon.svg'); background-color: #BFDDEC;" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $this_current_link; ?>" target="_blank"></a>
                </div>                    
            </div>
            <div class="site_prompt_background"></div>  
        </div>
        <?php
    }
    ?>