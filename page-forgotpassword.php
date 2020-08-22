<?php 

include "lang_config.php";

// global variables
$error_div = "";

if (isset($_POST['email'])){
    $this_user_id = get_user_by("email", $_POST['email']);
    if($this_user_id){
        $user_pass = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $this_user_id->ID " )[0]->user_pass;
        wp_mail($_POST['email'], "Reset your password", "click on this link to reset your password: https://typout.com/forgotpassword/?reset&user_pass=$user_pass&user_id=$this_user_id->ID");
        $error_div = '<div style="width: 320px; text-align: center; border: 1.6px solid black; border-radius: 5px; margin: 0 0 20px 0; padding: 15px; font-size: larger;">the recovery link was successfuly sent to your email</div>';
    }else{
        $error_div = '<div style="width: 320px; text-align: center; border: 1.6px solid black; border-radius: 5px; margin: 0 0 20px 0; padding: 15px; font-size: larger;">This email is not registered</div>';
    }
}

if (isset($_POST['password'])){
    if($_POST['password'] == $_POST['confirm_password']){

        // what happens if the user realy knows his current password
        wp_set_password($_POST['password'], $_POST['user_id']);

        // sign in user again because wp_Set_password() logs out the user
        wp_clear_auth_cookie();
        do_action('wp_login', $_POST['user_id']);
        wp_set_current_user($_POST['user_id']);
        wp_set_auth_cookie($_POST['user_id'], true);
        header('location: https://typout.com/');
        exit();
    }else{
        $error_div = '<div style="width: 320px; text-align: center; border: 1.6px solid black; border-radius: 5px; margin: 0 0 20px 0; padding: 15px; font-size: larger;">Your password does not match</div>';
    }
}

?>
<head>
    <link rel="shortcut icon" type="image/png" href="https://typout.com/wp-content/themes/typout/img/typout_icon.png"/>
    <link href="https://fonts.googleapis.com/css?family=Almarai&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head();?>
</head>

<div class="form_container">
    <div class="the_groupper_login">
        <div class="logo_form_container">
            <a href="https://typout.com/"><img class="logo_image_of_form" src="https://typout.com/wp-content/themes/typout/img/logo.svg" alt=""></a>
        </div>
        <?php
        if($error_div){
            echo $error_div;
        }
        ?>
        <div class="form">
            <form method="POST">
                <?php if(!isset($_GET['reset'])){
                    ?>
                    <div dir="auto">
                        <label for="email"><?php echo $lang[94] ?></label><br>
                        <input class="text_input" type="text" name="email"><br>
                    </div>
                    <div class="form_button_checkbox">
                        <div style="margin: 0; display: none;">
                            <input name="rememberme" type="checkbox" id="rememberme" value="1">
                            <label for="rememberme"><?php echo $lang[96] ?></label>
                        </div>
                            <div style="margin: 0;">
                            <button><?php echo $lang[136] ?></button>
                        </div>
                    </div>
                    <?php 
                }else{ 
                    $the_url_user_id = $_GET['user_id'];
                    $user_pass = $wpdb->get_results ( "SELECT * FROM `_typ_users` WHERE ID = $the_url_user_id" )[0]->user_pass;
                    if($user_pass == $_GET['user_pass']){
                        ?>
                        <div dir="auto">
                            <label for="fname"><?php echo $lang[135] ?></label><br>
                            <input class="text_input" type="password" name="password" required><br>
                        </div>
                        <div dir="auto">
                            <label for="fname"><?php echo $lang[135] ?></label><br>
                            <input class="text_input" type="password" name="confirm_password" required><br>
                        </div>
                        <div style="display: none;" dir="auto">
                            <input class="text_input" type="text" name="user_id" value="<?php echo $_GET['user_id'] ?>"><br>
                        </div>
                        <div class="form_button_checkbox">
                            <div style="margin: 0; display: none;">
                                <input name="rememberme" type="checkbox" id="rememberme" value="1">
                                <label for="rememberme"><?php echo $lang[96] ?></label>
                            </div>
                                <div style="margin: 0;">
                                <button><?php echo $lang[113] ?></button>
                            </div>
                        </div>
                        <?php
                    }else{
                        echo "you cannot be here";
                    }
                } ?>
            </form>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
