<?php
global $current_user;



if (isset($_POST['post_id'])){
    if (isset($_POST['thumbnail_url'])){
        $post_author_id = get_post_field( 'post_author', $_POST['post_id'] );
        if(get_current_user_id() == $post_author_id){
            
            // this is the function that sets post's thumbnail picture
            function Generate_Featured_Image( $image_url, $post_id  ){
                $upload_dir = wp_upload_dir();
                $image_data = file_get_contents($image_url);
                $filename = basename($image_url);
                if(wp_mkdir_p($upload_dir['path']))
                    $file = $upload_dir['path'] . '/' . $filename;
                else
                    $file = $upload_dir['basedir'] . '/' . $filename;
                    file_put_contents($file, $image_data);
                
                    $wp_filetype = wp_check_filetype($filename, null );
                    $attachment = array(
                        'post_mime_type' => $wp_filetype['type'],
                        'post_title' => sanitize_file_name($filename),
                        'post_content' => '',
                        'post_status' => 'inherit'
                    );
                    $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
                    require_once(ABSPATH . 'wp-admin/includes/image.php');
                    $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
                    $res1= wp_update_attachment_metadata( $attach_id, $attach_data );
                    $res2= set_post_thumbnail( $post_id, $attach_id );
            }
            Generate_Featured_Image($_POST['thumbnail_url'], $_POST['post_id']);
            echo "thumbnail has been changed";
        }else{echo "you dont have the permision to change other people's post's thumbnail picture";}
    }else{echo "there is no post thumbnail url";}
}else{echo "there is no post id";}

?>
