<?php

if(isset($_POST['ad_content'])){
    if(isset($_POST['id'])){
        if(isset($_POST['id_key'])){

            global $wpdb;

            $table_name = '_typ_users';
            $user_id = $_POST['id'];
            $user_key = $_POST['id_key'];
            $ad_content = $_POST['ad_content'];

            // sql command to fetch id_key
            $result = $wpdb->get_results ( "SELECT * FROM $table_name WHERE ID = $user_id" );
            $user_id_key = $result[0]->id_key;
            if($user_id_key == $user_key){

                // sql command
                $data_update = array('user_ad' => $ad_content);
                $data_where = array('ID' => $user_id);
                $wpdb->update($table_name , $data_update, $data_where);

                // response
                echo "your code in saved";

            }else{echo "this is not your real id, asshole";}
        }else{echo "you dont have id key";}
    }else{echo "you dont have id";}
}else{echo "you dont have ad content";}
?>