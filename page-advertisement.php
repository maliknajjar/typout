<?php include "lang_config.php";

?>
<!-- adding website icon in the title place because its not working for some reason -->
<head>
    <link rel="shortcut icon" type="image/png" href="https://typout.com/wp-content/themes/typout/img/typout_icon.png"/>
</head>
<?php

if(is_user_logged_in()){ 

    // getting the current url
    $uri = $_SERVER['REQUEST_URI'];

    // sql command
    $user_id = get_current_user_id();
    $payment = json_decode( hex2bin($wpdb->get_results("SELECT * FROM `_typ_users` WHERE ID = $user_id")[0]->payment), true);
    $y_impresions = $wpdb->get_results("SELECT * FROM `_typ_users` WHERE ID = $user_id")[0]->y_impressions;
    $y_profit = $wpdb->get_results("SELECT * FROM `_typ_users` WHERE ID = $user_id")[0]->y_profit;
    $balance = $wpdb->get_results("SELECT * FROM `_typ_users` WHERE ID = $user_id")[0]->balance;
    $referrals_m = $wpdb->get_results("SELECT * FROM `_typ_users` WHERE ID = $user_id")[0]->referrals_m;

    $referral_count = count($wpdb->get_results("SELECT * FROM `_typ_users` WHERE invited_by = $user_id", ARRAY_A));

    // changing or adding the payment method to the database
    if(isset($_POST['paypal_email'])){
        $array = array();
        $array['Payment_method'] = 'Paypal';
        $array['Paypal_email'] = $_POST['paypal_email'];
        $array = json_encode($array);

        // fetching the real key
        $request_user_id = $_POST['user_id'];
        $user_key = $_POST['user_key'];
        $the_key = $wpdb->get_results("SELECT * FROM `_typ_users` WHERE ID = $request_user_id")[0]->id_key;
        if($user_key == $the_key){
            $wpdb->update('_typ_users', array('payment' => bin2hex($array)), array('id'=>$request_user_id));
        }
        echo "
        <script>
            window.location = 'https://typout.com/advertisement/?PaymentMethods';
        </script>
        ";
    }elseif(isset($_POST['nameonbank'])){
        $array = array();
        $array['Payment_method'] = 'Bank transfer';
        $array['Name_on_bank'] = $_POST['nameonbank'];
        $array['Bank_name'] = $_POST['bankname'];
        $array['SWIFT_BIC'] = $_POST['swift'];
        $array['IBAN'] = $_POST['iban'];
        $array = json_encode($array);

        // fetching the real key
        $request_user_id = $_POST['user_id'];
        $user_key = $_POST['user_key'];
        $the_key = $wpdb->get_results("SELECT * FROM `_typ_users` WHERE ID = $request_user_id")[0]->id_key;
        if($user_key == $the_key){
            $wpdb->update('_typ_users', array('payment' => bin2hex($array)), array('id'=>$request_user_id));
        }
        echo "
        <script>
            window.location = 'https://typout.com/advertisement/?PaymentMethods';
        </script>
        ";
    }elseif(isset($_POST['first_name'])){
        
        $array = array();
        $array['Payment_method'] = 'Western union';
        $array['First_name'] = $_POST['first_name'];
        $array['Last_name'] = $_POST['last_name'];
        $array = json_encode($array);

        // fetching the real key
        $request_user_id = $_POST['user_id'];
        $user_key = $_POST['user_key'];
        $the_key = $wpdb->get_results("SELECT * FROM `_typ_users` WHERE ID = $request_user_id")[0]->id_key;
        if($user_key == $the_key){
            $wpdb->update('_typ_users', array('payment' => bin2hex($array)), array('id'=>$request_user_id));
        }
        echo "
        <script>
            window.location = 'https://typout.com/advertisement/?PaymentMethods';
        </script>
        ";
    }

    get_header();

    ?>
    <main class="main_for_user_ads_page" data-paypal="<?php echo $lang[39]; ?>" data-bank="<?php echo $lang[40]; ?>" data-western="<?php echo $lang[41]; ?>" data-sentence="<?php echo $lang[54]; ?>" data-paypalemail="<?php echo $lang[55]; ?>" data-save="<?php echo $lang[99]; ?>" data-nameonbank="<?php echo $lang[100]; ?>" data-bankname="<?php echo $lang[101]; ?>" data-swift="<?php echo $lang[102]; ?>" data-iban="<?php echo $lang[103]; ?>" data-first="<?php echo $lang[104]; ?>" data-last="<?php echo $lang[105]; ?>">
        <?php include "userSettingList.php"; ?>
        <div class="container_of_the_content">
            <div class="user_control_page_title"><?php echo $lang[125]; ?></div>
            <!-- <div style="min-width: 700px; text-align: center; border: 1.6px solid black; background-color: red; color: white; line-height: 150%; border-radius: 5px; margin: 0 0 20px 0; padding: 15px; font-size: larger;">
                لقد تم حظرنا من قوقل .. و سيتم ازالة الحظر يوم 8 من شهر اغسطس .. اموالكم لن تضيع ولكن لن نستطيع تسديد استحقاقاتكم الى حين انتهاء مدة الحظر
            </div> -->
            <div style="min-width: 700px; text-align: center; border: 1.6px solid black; border-radius: 5px; margin: 0 0 20px 0; padding: 15px; font-size: larger;">
                <?php echo $lang[131]; ?>
            </div>
            <div class="balance_area">
                <div>
                    <div style="margin-top: 7.5px;">
                        <div style="font-size: 35px"><?php echo $y_impresions; ?></div>
                        <div><?php echo $lang[106]; ?></div>
                    </div>
                </div>
                <div>
                    <div style="margin-top: 7.5px;">
                        <div style="font-size: 35px"><?php echo $y_profit; ?>€</div>
                        <div><?php echo $lang[107]; ?></div>
                    </div>
                </div>
                <div>
                    <div style="font-size: 50px"><?php echo $balance; ?>€</div>
                    <div><?php echo $lang[108]; ?></div>
                </div>
            </div>
            <div class="navigation_balance_bar">
                <a href="https://typout.com<?php echo explode("?", $uri)[0]; ?>?Transactions" <?php if(explode("?", $uri)[1] == "Transactions"){echo 'class="selected"';} ?>><?php echo $lang[109]; ?></a>
                <a href="https://typout.com<?php echo explode("?", $uri)[0]; ?>?Referrals" <?php if(explode("?", $uri)[1] == "Referrals"){echo 'class="selected"';} ?>><?php echo $lang[110]; ?></a>
                <a href="https://typout.com<?php echo explode("?", $uri)[0]; ?>?PaymentMethods" <?php if(explode("?", $uri)[1] == "PaymentMethods"){echo 'class="selected"';} ?>><?php echo $lang[111]; ?></a>
            </div>
            <?php
            if(isset($_GET['PaymentMethods'])){
                // here is the PaymentMethods page
                echo '<div style="display: none;" class="PaymentMethods"></div>';
                if($payment){
                    $payment_keys = array_keys($payment);
                    ?>
                    <div class="ads_form_container">
                        <div class="balance_content">
                            <div style="text-align: center; margin-bottom: 15px;"><?php echo $lang[112]; ?></div>
                            <div style="display: flex; justify-content: center;">
                                <div style="display: flex; justify-content: center; border: 1.6px dashed black; border-radius: 5px; padding: 15px; margin: 5px;">
                                    <div style="margin-right: 40px; ">
                                    <?php
                                    foreach($payment_keys as $n){
                                        echo '<div>' . $n . ':</div>';
                                    }
                                    ?>
                                    </div>
                                    <div>
                                    <?php
                                    foreach($payment as $i){
                                        echo '<div>' . $i . '</div>';
                                    }
                                    ?>
                                    </div>
                                </div>
                            </div>
                            <div style="display: flex; justify-content: center; margin-top: 20px;">
                                <div class="payment_button"><?php echo $lang[113]; ?></div>
                            </div>
                        </div>
                    </div>
                    <?php
                }else{
                    ?>
                    <div class="ads_form_container">
                        <div class="balance_content">
                            <div style="display: flex; justify-content: center; margin-bottom: 20px">
                                <div><?php echo $lang[114]; ?></div>
                            </div>
                            <div style="display: flex; justify-content: center;">
                                <div class="payment_button"><?php echo $lang[115]; ?></div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }elseif(isset($_GET['Referrals'])){
                // here is the Referrals page
                ?>
                <div class="ads_form_container">
                    <div class="balance_content" style="padding: 50px;">
                        <div style="text-align: center; border: 1.6px solid black; border-radius: 5px; margin: 0 0 25px 0; padding: 15px; font-size: larger;">
                            <?php echo $lang[130]; ?>
                        </div>
                        <div style="font-size: large;"><?php echo $lang[116]; ?></div>
                        <div style="cursor: text; border: 1.6px dashed black; border-radius: 5px; margin: 5px 0; padding: 15px; font-size: larger;">
                            <div>https://typout.com/register/?u=<?php echo $current_user->ID ?></div>
                        </div>
                        <div style="font-size: large; margin-top: 25px; margin-bottom: 5px;"><?php echo $lang[117]; ?></div>
                        <div class="balance_area_refferal">
                            <div style="margin-left: 0; margin-top: 0;">
                                <div style="margin-top: 7.5px;">
                                    <div style="font-size: 35px"><?php if($referral_count){echo $referral_count;}else{echo "0";} ?></div>
                                    <div><?php echo $lang[118]; ?></div>
                                </div>
                            </div>
                            <div style="margin-right: 0; margin-left: 0; margin-top: 0;">
                                <div style="margin-top: 7.5px;">
                                    <div style="font-size: 35px"><?php echo $referrals_m; ?>€</div>
                                    <div><?php echo $lang[119]; ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }elseif(isset($_GET['Transactions'])){
                // here is the Transactions page
                ?>
                <div class="ads_form_container">
                    <div style="border: none;" class="user_control_page_container" data-public="تم تغيير الحالة بنجاح" data-draft="تم تغيير الحالة بنجاح">
                        <div class="user_control_page_container_header">
                            <div class="posts_list_title" style="flex: 1;"><?php echo $lang[120]; ?></div>
                            <div class="posts_list_views"><?php echo $lang[121]; ?></div>
                            <div class="posts_list_comments"><?php echo $lang[122]; ?></div>
                            <div class="posts_list_statue"><?php echo $lang[123]; ?></div>
                        </div>
                        <div class="user_control_page_container_body">
                            <div class="posts_list_title the_title_place" style="flex: 1;">...</div>
                            <div class="posts_list_views">...</div>
                            <div class="posts_list_comments">...</div>
                            <div class="posts_list_statue statue_remove_padding">...</div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <div style="padding: 25px 0;">
                <div class="payment_notification" style="padding: 10px 15px; border-radius: 5px; background-color: #d1d1d1; min-width: 245px; text-align: center;"><?php echo $lang[124]; ?></div>
            </div>
        </div>
    </main>

<?php 
}else{
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.location.href='https://typout.com/login';
    </SCRIPT>");
} 

?>

<?php get_footer(); ?>