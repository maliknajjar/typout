<?php 
include "lang_config.php";

// error div variable
$error_div = '';

// if error is stored in get request variable 
if(isset($_GET['message'])){
    $error_div = '<div class="error_place" style="border-radius: 5px; margin: 15px; background-color: ' . $_GET['color'] . ';">' . $_GET['message'] . '</div>';
}

if(isset($_POST['id_number']) and isset($_POST['id_key'])){
    $table_name = '_typ_users';
    $id = $_POST['id_number'];
    $result = $wpdb->get_results ( "SELECT * FROM $table_name WHERE ID = $id" );
    $original_key = $result[0]->id_key;
    // making sure the user is logged in
    if($original_key == $_POST['id_key']){ 
        // make sure all fields are not empty
        if($_POST['display_name']){
            wp_update_user( array(
                'ID' => $_POST['id_number'],
                'display_name' => $_POST['display_name']
            ));
            // what happens if you include old and new password
            if($_POST['old_password'] and $_POST['new_password']){
                $userdata = get_user_by('ID', $_POST['id_number']);
                $doesUserKnowPassword = wp_check_password($_POST['old_password'], $userdata->user_pass, $_POST['id_number']);
                // what happens if the user realy knows his current password
                if($doesUserKnowPassword){
                    wp_set_password($_POST['new_password'], $_POST['id_number']);
                    // sign in user again because wp_Set_password() logs out the user
                    wp_clear_auth_cookie();
                    do_action('wp_login', $userdata->ID);
                    wp_set_current_user($userdata->ID);
                    wp_set_auth_cookie($userdata->ID, true);
                    header('location: https://typout.com/profile/?message=your account was successfully updated&color=green');
                    exit();
                }else{
                    header('location: https://typout.com/profile/?message=your old password is wrong&color=red');
                    exit();
                }
            }elseif($_POST['old_password'] xor $_POST['new_password']){
                header('location: https://typout.com/profile/?message=make sure the old and new password field are not empty&color=red');
                exit();
            }
            header('location: https://typout.com/profile/?message=your account was successfully updated&color=green');
        }else{
            $error_div = '<div class="error_place" style="border-radius: 5px; margin: 15px;">make sure all the fields are not empty</div>';
        }
    }else{
        $error_div = '<div class="error_place" style="border-radius: 5px; margin: 15px;">you cant make these changes becuase of key error</div>';
    }
}

if(is_user_logged_in()){
get_header(); 
?>
<main class="main_for_user_profile_page">
    <?php include "userSettingList.php"; ?>
    <div class="container_of_the_content">
        <div class="user_control_page_title"><?php echo $lang[77]; ?></div>
        <div class="ads_form_container">
        <?php echo $error_div; ?>
            <div class="form" style="border: none; margin-left: auto; margin-right: auto;">
                <form method="POST">
                    <div>
                        <label for="display_name"><?php echo $lang[78]; ?></label><br>
                        <input class="text_input" type="text" name="display_name" value="<?php echo wp_get_current_user()->data->display_name; ?>"><br>
                    </div>
                    <div style="margin-bottom: -8.5px; font-size: 14px;"><?php echo $lang[79]; ?></div>
                    <div style="padding: 5px; border: 1.6px solid grey; border-radius: 5px;">
                        <div>
                            <input class="text_input" type="password" name="old_password" placeholder="<?php echo $lang[80]; ?>"><br>
                        </div>
                        <div>
                            <input class="text_input" type="password" name="new_password" placeholder="<?php echo $lang[81]; ?>"><br>
                        </div>
                    </div>
                    <input class="text_input" type="hidden" name="id_number" value="<?php echo get_current_user_id() ?>">
                    <input class="text_input" type="hidden" name="id_key" value="<?php echo $newcode ?>">
                    <div class="form_button_checkbox" style="display: block;">
                        <div style="margin: 0;">
                            <button><?php echo $lang[82]; ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php }else{
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.location.href='https://typout.com/login';
    </SCRIPT>");
    } ?>

<?php get_footer(); ?>