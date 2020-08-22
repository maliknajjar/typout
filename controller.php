<?php

// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< FUNCTIONS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
// including all wp functions
require($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
// get the number from percentage
function get_number_from_percentage($percentage, $total)
{
  return ($percentage / 100) * $total;
}
// get the percenatage from the number
function get_percentage_from_number($number, $total)
{
  return round($number / ($total / 100),2);
}

// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<< EVENTS >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

if(isset($_POST['reset'])){

    // <<<<<<<<<<<<<<<<<<< reseting yesterday info to zero to all users >>>>>>>>>>>>>>>>
    $all_users = $wpdb->get_results ( "SELECT * FROM `_typ_users`" );
    foreach($all_users as $item){
        // not doing anything if the url has no author
        $wpdb->update('_typ_users', array('y_impressions'=> 0), array('ID'=>$item->ID));
        $wpdb->update('_typ_users', array('y_profit'=> 0), array('ID'=>$item->ID));
    }
    echo "all y_impressions and y_profit are reseted to 0 for all users<br><br><br><br><br>";
    // <<<<<<<<<<<<<<<<<<< reseting yesterday info to zero to all users >>>>>>>>>>>>>>>>


}

if(isset($_POST['input'])){

    $posts_array = json_decode(stripslashes($_POST['input']), true);
    $total_money = $_POST['money'];        // you assign this number manualy

    // <<<<<<<<<<<<< checking the real number of views >>>>>>>>>>>>>>>>
    $total_views = 0; // this number is assigned automatically
    foreach($posts_array as $item){
        $the_post_id = url_to_postid(explode("/", $item['Page'])[1]);
        $the_post_user_id = get_post_field( 'post_author', $the_post_id );
        if($the_post_id == 0 || $the_post_user_id == 1){
            continue;
        }else{
            if(gettype($item['Unique Pageviews']) == "string"){
                $uniquePageviews = $item['Unique Pageviews'];
                $uniquePageviews = explode(",", $uniquePageviews);
                $uniquePageviews = implode("", $uniquePageviews);
            }else{
                $uniquePageviews = $item['Unique Pageviews'];
            }
            $total_views = $total_views + $uniquePageviews;
        }
    }
    echo "total views is: " . $total_views . "<br><br><br>";
    
    // <<<<<<<<<<<<< adding money for each user that made views >>>>>>>>>>>>>>>>
    $total_money_spent = 0;
    foreach($posts_array as $item){
        // variables
        $the_post_id = url_to_postid(explode("/", $item['Page'])[1]);
        $the_post_user_id = get_post_field( 'post_author', $the_post_id );

        // not doing anything if the url has no author
        if($the_post_id == 0 || $the_post_user_id == 1){
            continue;
        }

        // when unique pageview exceeds a thousand google turns it to a string instead of number
        // so we turning this from string to an integer for it to work properly
        if(gettype($item['Unique Pageviews']) == "string"){
            $uniquePageviews = $item['Unique Pageviews'];
            $uniquePageviews = explode(",", $uniquePageviews);
            $uniquePageviews = implode("", $uniquePageviews);
        }else{
            $uniquePageviews = $item['Unique Pageviews'];
        }

        $money = get_percentage_from_number($uniquePageviews, $total_views);
        $author_money = get_number_from_percentage($money, $total_money);

        $y_impressions = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $the_post_user_id" )[0]->y_impressions;
        $y_profit = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $the_post_user_id" )[0]->y_profit;
        $balance = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $the_post_user_id" )[0]->balance;

        // if the author was invited by a user
        $invited_by = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $the_post_user_id" )[0]->invited_by;
        if($invited_by){
            $referrals_m = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $invited_by" )[0]->referrals_m;
            $invited_by_balance = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $invited_by" )[0]->balance;
            $invited_by_y_profit = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $invited_by" )[0]->y_profit;

            $invited_by_money = get_number_from_percentage(10, $author_money);
            $invited_by_money = rtrim(sprintf('%f',floatval($invited_by_money)),'0');

            // giving 90% percent to the user
            $author_money = get_number_from_percentage(90, $author_money);
            $author_money = rtrim(sprintf('%f',floatval($author_money)),'0');

            // giving 10% percent to the invited_by user
            $wpdb->update('_typ_users', array('balance'=> $invited_by_balance + $invited_by_money), array('ID'=>$invited_by));
            $wpdb->update('_typ_users', array('y_profit'=> $invited_by_y_profit + $invited_by_money), array('ID'=>$invited_by));
            $wpdb->update('_typ_users', array('referrals_m'=> $referrals_m + $invited_by_money), array('ID'=>$invited_by));

            echo "we gave $invited_by 10% percent: $invited_by_money | and gave the user his 90% percent: $author_money<br><br>";
        }else{
            // giving 90% percent to the user and 10% for the website
            $author_money = get_number_from_percentage(90, $author_money);
            $author_money = rtrim(sprintf('%f',floatval($author_money)),'0');
        }

        $wpdb->update('_typ_users', array('y_impressions'=> $y_impressions + $uniquePageviews), array('ID'=>$the_post_user_id)); 
        $wpdb->update('_typ_users', array('y_profit'=> $y_profit + $author_money), array('ID'=>$the_post_user_id));
        $wpdb->update('_typ_users', array('balance'=> $balance + $author_money), array('ID'=>$the_post_user_id));

        echo "we gave $the_post_user_id: $author_money € for this amount of views: " . $uniquePageviews . "<br><br>";
        $total_money_spent = $total_money_spent + $author_money;
    }
    $gained = $total_money - $total_money_spent;
    echo "<br>Typout gained: $gained";
    echo "<br>we spent $total_money_spent € for all Users<br><br><br>";

    // <<<<<<<<<<<<<<<<<< calculating the total money to spend on users next month >>>>>>>>>>>>>>>>
    $money_next_month = 0;
    $the_all_users = $wpdb->get_results ( "SELECT * FROM `_typ_users`" );
    foreach($the_all_users as $item){
        // not doing anything if the url has no author
        $balance = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $item->ID" )[0]->balance;
        $money_next_month = $money_next_month + $balance;
    }
    echo "total money to spend on users next month is: $money_next_month €<br><br><br>";
}

if(get_current_user_ID() == 1){
    ?>
    <div class="form">
        <form method="POST">
            <div>
                <label for="input">add user's posts</label>
                <textarea rows="5" cols="80" name="input"></textarea>
            </div>
            <div>
                <label for="money">money spent on users</label>
                <textarea name="money"></textarea>
            </div>
            <div class="form_button_checkbox">
                <div style="margin: 0;"></div>
                <div style="margin: 0;">
                    <button>send</button> 
                </div>
            </div>
        </form>
        <form method="POST">
            <div style="display: none;">
                <label for="reset">add user's posts</label>
                <textarea rows="5" cols="80" name="reset"></textarea>
            </div>
            <button>reset</button> 
        </form>
    </div>
    <?php
}else{
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.location.href='https://typout.com/';
    </SCRIPT>");
} 


?>