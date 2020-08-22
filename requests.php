<?php

// including all wp functions
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');

// including lang session variable
include "lang_config.php";  

/*>>>>>>>>    inserting a notification row    <<<<<<<<<*/
if(isset($_POST['mission'])){
    if($_POST['mission'] == "inser_notification"){
        $user_id = $_POST['id'];
        $result = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $user_id" );
        $user_id_key = $result[0]->id_key;
        if($_POST['id_key'] == $user_id_key){
            $subscribers = $wpdb->get_results ( "SELECT * FROM `_typ_subscribers` WHERE subscribed_to = $user_id" );
            if($subscribers){
                foreach($subscribers as $item){
                    $wpdb->insert('_typ_notifications', array(
                        'user_id' => $item->subscriber,
                        'creator_id' => $user_id,
                        'purpose' => "post",
                        'post_id' => $_POST['post_id'],
                    ));
                }
            }
        }else{echo "key dont match";}
    }
}

/*>>>>>>>>    resetting the seen in sql database    <<<<<<<<<*/
if(isset($_POST['mission'])){
    if($_POST['mission'] == "reset_seen"){
        $user_id = $_POST['id'];
        $result = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $user_id" );
        $user_id_key = $result[0]->id_key;
        if($_POST['id_key'] == $user_id_key){
            $wpdb->update('_typ_notifications', array('seen'=>1), array('user_id'=>$user_id));
        }else{echo "key dont match";}
    }
}

/*>>>>>>>>    comment logic    <<<<<<<<<*/
if(isset($_POST['mission'])){
    if($_POST['mission'] == "comment"){
        $user_id = $_POST['id'];
        $result = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $user_id" );
        $user_id_key = $result[0]->id_key;
        if($_POST['id_key'] == $user_id_key){

            wp_insert_comment(array(
                "comment_content" => $_POST['body'],
                "comment_post_ID" => $_POST['the_post_id'],
                "user_id" => $user_id
            ));
            echo 'done making the comment';
        }else{echo "key dont match";}
    }
}

/*>>>>>>>>    subscribe logic    <<<<<<<<<*/
if(isset($_POST['mission'])){
    if($_POST['mission'] == "subscribe"){
        $user_id = $_POST['id'];
        $result = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $user_id" );
        $user_id_key = $result[0]->id_key;
        if($_POST['id_key'] == $user_id_key){
            $post_user_id = $_POST['post_user_id']; 
            $result_two = $wpdb->get_results ( "SELECT * FROM `_typ_subscribers` WHERE subscriber = $user_id AND subscribed_to = $post_user_id" )[0]->subscriber;
            if($result_two){
                $where = array( 
                    'subscriber' => $user_id,
                    'subscribed_to' => $post_user_id,
                );
                $table_name = '_typ_subscribers';
                $wpdb->delete( $table_name , $where);
                echo "deleting table is done";
            }
            else{
                $wpdb->insert('_typ_subscribers', array(
                    'subscriber' => $user_id,
                    'subscribed_to' => $post_user_id,
                ));
                echo "inserting table is done";
            }
        }else{echo "this is post id: $user_id";}
    }
}

/*>>>>>>>>    requests to add like or dislike button    <<<<<<<<<*/
if(isset($_POST['post_id'])){
    if(isset($_POST['id']) && $_POST['id'] != 0){
        if(isset($_POST['id_key'])){
            
            $post_id = $_POST['post_id'];
            $user_id = $_POST['id'];
            $result = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $user_id" );
            $user_id_key = $result[0]->id_key;
            if($_POST['id_key'] == $user_id_key){

                $the_result = $wpdb->get_results ( "SELECT * FROM `_typ_likes` WHERE user_id = $user_id AND post_id = $post_id" );

                if($_POST['like_type'] == "like"){
                    if($the_result){
                        $wpdb->update('_typ_likes', array('like_type'=>1), array('post_id'=>$post_id, 'user_id'=>$user_id));
                        echo "changed from dislike to like";
                    }else{
                        $wpdb->insert('_typ_likes', array(
                            'user_id' => $user_id,
                            'post_id' => $post_id,
                            'like_type' => 1,
                        ));
                        echo "success you just added like to this post";
                    }
                }elseif($_POST['like_type'] == "dislike"){
                    if($the_result){
                        $wpdb->update('_typ_likes', array('like_type'=>2), array('post_id'=>$post_id, 'user_id'=>$user_id));
                        echo "changed from like to dislike";
                    }else{
                        $wpdb->insert('_typ_likes', array(
                            'user_id' => $user_id,
                            'post_id' => $post_id,
                            'like_type' => 2,
                        ));
                        echo "success";
                    }
                }elseif($_POST['like_type'] == "delete"){
                    $like_type = $wpdb->get_results ( "SELECT * FROM `_typ_likes` WHERE user_id = $user_id AND post_id = $post_id" )[0]->like_type;
                    $where = array( 
                        'user_id' => $user_id,
                        'post_id' => $post_id,
                    );
                    $table_name = '_typ_likes';
                    $wpdb->delete( $table_name , $where);
                    echo "delete";
                }else{
                    echo "you didnt provide a like type";
                }
            }else{echo "dont try to trick us .. you are not the real user";}
        }else{echo "you didnt send ID key";}
    }else{echo "you are not logged in";}
}

/*>>>>>>>>    requests for uploading cover or profile picture    <<<<<<<<<*/
if(isset($_POST['mission'])){
    
    // fetching user_id_key from the database
    $user_id = $_POST['user_id'];
    $result = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $user_id" );
    $user_id_key = $result[0]->id_key;
    if($_POST['user_id_key'] == $user_id_key){
        
        // uploading cover image
        if($_POST['mission'] == 'uploading_cover_image'){
            if($_FILES["file"]["name"] != ''){
                $test = explode('.', $_FILES["file"]["name"]);
                $ext = strtolower(end($test));
                $name = uniqid("", true) . '.' . $ext;
                $location = 'upload/' . $name;
                $allowed = array('jpg', 'png', 'jpeg', "gif");
                if(in_array($ext, $allowed)){
                    move_uploaded_file($_FILES["file"]["tmp_name"], $location);
                    $the_url = 'https://typout.com/wp-content/themes/typout/'.$location;

                    // adding this url in the data base
                    $table_name = '_typ_users';
                    $data_update = array('cover_picture' => $the_url);
                    $data_where = array('ID' => $user_id);
                    $wpdb->update($table_name , $data_update, $data_where);

                    // response
                    echo "success";
                }else{echo "you are not allowed to upload this file format";}
            }else{echo "the file has no name";}
        }elseif($_POST['mission'] == 'uploading_profile_image'){

            // uploading profile image
            if($_FILES["file"]["name"] != ''){
                $test = explode('.', $_FILES["file"]["name"]);
                $ext = strtolower(end($test));
                $name = uniqid("", true) . '.' . $ext;
                $location = 'upload/' . $name;
                $allowed = array('jpg', 'png', 'jpeg', "gif");
                if(in_array($ext, $allowed)){
                    move_uploaded_file($_FILES["file"]["tmp_name"], $location);
                    $the_url = 'https://typout.com/wp-content/themes/typout/'.$location;

                    // adding this url in the data base
                    $table_name = '_typ_users';
                    $data_update = array('profile_picture' => $the_url);
                    $data_where = array('ID' => $user_id);
                    $wpdb->update($table_name , $data_update, $data_where);

                    // response
                    echo "success";
                }else{echo "you are not allowed to upload this file format";}
            }else{echo "the file has no name";}
        }
    }else{
        echo "you cant make this order";
    }
}

/*>>>>>>>>    requests for changing the UI language for the user    <<<<<<<<<*/
if(isset($_POST['lang'])){
    if(isset($_POST['id'])){
        if(isset($_POST['id_key'])){

            // making sure that the user made this request
            global $wpdb;

            $table_name = '_typ_users';
            $user_id = $_POST['id'];
            $user_key = $_POST['id_key'];
            $lang = stripslashes_deep($_POST['lang']);

            $result = $wpdb->get_results ( "SELECT * FROM $table_name WHERE ID = $user_id" );
            $user_id_key = $result[0]->id_key;
            if($user_id_key == $user_key){

                // sql command
                $data_update = array('user_lang' => $lang);
                $data_where = array('ID' => $user_id);
                $wpdb->update($table_name , $data_update, $data_where);

                // response
                echo "your language in saved";

            }else{}
        }else{}
    }else{}
}else{}

/*>>>>>>>>    making my own rest api    <<<<<<<<<*/
if(isset($_POST['page'])){
    $language = array(
        'en' => '361',
        'es' => '366',
        'fr' => '364',
        'ru' => '365',
        'ar' => '362',
        'zh' => '363'
    );

    $args = array(
        'posts_per_page' => 15,
        'paged' => $_POST['page'],
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => '_thumbnail_id',
                'compare' => 'EXISTS'
            ),
        ),
    );

    // what happens if there is a categories POST request 
    if($_POST['categories']){
        $args['tax_query'] = array(array('taxonomy' => 'category','field' => 'id','terms' => array( $language[$_SESSION['lang']], $_POST['categories']),'operator' => 'AND'));
    }elseif($_POST['language']){
        $args['cat'] = $_POST['language'];
    }else{
        $args['cat'] = $language[$_SESSION['lang']];
    }

    // what happens if there is an author_id POST request 
    if(isset($_POST['author_id'])){
        $args['author'] = $_POST['author_id'];
        unset($args['cat']);
    }

    //what happens if there is an search_term POST request
    if(isset($_POST['search_term'])){
        $args['s'] = $_POST['search_term'];
        unset($args['cat']);
    }

    $recommended_posts = new WP_Query($args);

    // the array of the loop of requested posts
    $articles = array();
    
    while($recommended_posts->have_posts()){
        $recommended_posts->the_post();
        $article = array();
        if(get_the_post_thumbnail(get_the_ID(), 'small_thumbnail')){
            if(strpos(get_the_post_thumbnail(get_the_ID(), 'small_thumbnail'),'width="1"')){
                $article['the_post_thumbnail'] = '<img width="260" height="188" src="https://typout.com/wp-content/themes/typout/img/default_image_thumbnail.svg" class="attachment-small_thumbnail size-small_thumbnail wp-post-image" alt="">';
            }else{
                $article['the_post_thumbnail'] = get_the_post_thumbnail(get_the_ID(), 'small_thumbnail');
            }
        }else{
            $article['the_post_thumbnail'] = '<img width="260" height="188" src="https://typout.com/wp-content/themes/typout/img/default_image_thumbnail.svg" class="attachment-small_thumbnail size-small_thumbnail wp-post-image" alt="">';
        }
        $article['the_permalink'] = get_permalink();
        $article['the_title'] = get_the_title(get_the_ID());
        $article['the_author_posts_link'] = get_the_author_posts_link();
        // views sql query
        $current_post_id = get_the_id();
        $article['views'] = $wpdb->get_results("SELECT * FROM `_typ_posts` WHERE ID = $current_post_id")[0]->views;
        array_push($articles, $article);
    }
    echo json_encode($articles);
}

?>
