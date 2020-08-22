<?php 

include "lang_config.php";

// global variables
$error_div = "";

if ( isset($_POST['email']) && isset($_POST['password']) ){

    // login user function

    function login_wordpress($email, $password){
        $creds = array();
        $creds['user_login'] = $email;
        $creds['user_password'] = $password;
        $creds['remember'] = true;
        $user = wp_signon( $creds, false );
        global $error_div;
        if ( is_wp_error($user) ) {
            $error = $user->get_error_message();
            if(strpos($error, "nknown username. Check again or try your email address")){
                $error_div = '<div class="error_place">' . $lang[92] . '</div>';
            }
            elseif(strpos($error, "The password you entered for the email address")){
                $error_div = '<div class="error_place">' . $lang[93] . '</div>';
            }else{
                $error_div = '<div class="error_place">' . $error . ' 😥</div>';
            }
        } else {
            wp_clear_auth_cookie();
            do_action('wp_login', $user->ID);
            wp_set_current_user($user->ID);
            wp_set_auth_cookie($user->ID, true);
            header("Location: https://typout.com/");
        }
    }

    login_wordpress($_POST['email'], $_POST['password']);
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
            <form method="POST" >
                <div dir="auto">
                    <label for="fname"><?php echo $lang[94] ?></label><br>
                    <input class="text_input" type="text" name="email"><br>
                </div>
                <div dir="auto">
                    <label for="fname"><?php echo $lang[95] ?></label><br>
                    <input class="text_input" type="password" name="password"><br>
                </div>
                <div class="form_button_checkbox">
                    <div style="margin: 0;">
                        <input name="rememberme" type="checkbox" id="rememberme" value="1">
                        <label for="rememberme"><?php echo $lang[96] ?></label>
                    </div>
                        <div style="margin: 0;">
                        <button><?php echo $lang[97] ?></button>
                    </div>
                </div> 
            </form>
        </div>
        <div style="width: 320px; text-align: center; border: 1.6px solid black; border-radius: 5px; margin: 20px 0 0 0; padding: 15px; font-size: normal;">If you forgot your password <a href="https://typout.com/forgotpassword/" style="color: blue;">click here</a></div>
    </div>
</div>

<?php wp_footer(); ?>
