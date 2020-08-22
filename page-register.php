<?php 

include "lang_config.php";

// error message
$error_div = "";

if ( isset($_POST['user_email']) && isset($_POST['user_name']) && isset($_POST['user_password']) && isset($_POST['user_confirm_password']) ){
    $user_name = explode('@', $_POST['user_email'])[0];
    $username_exists = username_exists($user_name);
    $index = 1;
    while($username_exists){
        $test_name = explode('@', $_POST['user_email'])[0] . $index;
        $username_exists = username_exists($test_name);
        $user_name = $test_name;
        $index = $index + 1;
    }
    if($_POST['user_email'] == "" or $_POST['user_name'] == "" or $_POST['user_password'] == "" or $_POST['user_confirm_password'] == ""){
        $error_div = '<div class="error_place">' . $lang[83] . '</div>';
    }else{
        if($_POST['user_password'] != $_POST['user_confirm_password']){
            $error_div = '<div class="error_place">' . $lang[84] . '</div>';
        }else{
            // removing all white space from email
            $_POST['user_email'] = trim($_POST['user_email']," ");
            // checking if the email is valid
            if (filter_var($_POST['user_email'], FILTER_VALIDATE_EMAIL)){
                // checking if email exists
                if(email_exists($_POST['user_email'])){
                    $error_div = '<div class="error_place">' . $lang[85] . '</div>';
                }else{
                    // what happens if there is no empty fields and paswords matches and email is valid
                    // making the new user
                    $user_id = wp_insert_user(array(
                        'user_login'        =>  $user_name,
                        'user_email'        =>  $_POST['user_email'],
                        'first_name'        =>  $_POST['user_name'],
                        'user_pass'         =>  $_POST['user_password'],
                        'role'              =>  'subscriber'
                    ));
                    if(isset($_POST['invited_by'])){
                        $invited_by = $_POST['invited_by'];
                        $wpdb->update('_typ_users', array('invited_by' => $invited_by), array('id'=>$user_id));
                    }

                    // loging in the new user
                    $creds = array();
                    $creds['user_login'] = $_POST['user_email'];
                    $creds['user_password'] = $_POST['user_password'];
                    $creds['remember'] = true;
                    $user = wp_signon( $creds, false );
                    if ( is_wp_error($user) ) {
                        $error = $user->get_error_message();
                        $error_div = '<div class="error_place">' . $error . ' 😥</div>';
                    } else {
                        wp_clear_auth_cookie();
                        do_action('wp_login', $user->ID);
                        wp_set_current_user($user->ID);
                        wp_set_auth_cookie($user->ID, true);
                        // redirectig to the homepage
                        header("Location: https://typout.com/");
                    }
                }
            }else{
                $error_div = '<div class="error_place">' . $lang[86] . '</div>';
            }
        }
    }
}

?>

<head>
    <link rel="shortcut icon" type="image/png" href="https://typout.com/wp-content/themes/typout/img/typout_icon.png"/>
    <link href="https://fonts.googleapis.com/css?family=Almarai&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head();?>
</head>

<?php
if($error_div){
    echo $error_div;
}
?>
<div class="form_container">
    <div class="the_groupper_login">
        <div class="logo_form_container">
            <a href="https://typout.com/"><img class="logo_image_of_form" src="https://typout.com/wp-content/themes/typout/img/logo.svg" alt=""></a>
        </div>
        <div class="form">
            <form method="POST">
                <div dir="auto">
                    <label for="user_email"><?php echo $lang[87] ?></label><br>
                    <input class="text_input" type="text" name="user_email">
                </div>
                <div dir="auto">
                    <label for="user_name"><?php echo $lang[88] ?></label><br>
                    <input class="text_input" type="text" name="user_name">
                </div>
                <div dir="auto">
                    <label for="user_password"><?php echo $lang[89] ?></label><br>
                    <input class="text_input" type="password" name="user_password">
                </div>
                <div dir="auto">
                    <label for="user_confirm_password"><?php echo $lang[90] ?></label><br>
                    <input class="text_input" type="password" name="user_confirm_password">
                </div>
                <?php if(isset($_GET['u'])){
                    ?>
                    <div style="display: none;">
                        <input class="text_input" type="text" name="invited_by" value="<?php echo $_GET['u'] ?>">
                    </div>
                    <?php
                } ?>
                <div class="form_button_checkbox">
                    <div style="margin: 0;"></div>
                    <div style="margin: 0;">
                        <button><?php echo $lang[91] ?></button> 
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
