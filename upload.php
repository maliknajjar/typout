<?php
if($_FILES["file"]["name"] != ''){
  $test = explode('.', $_FILES["file"]["name"]);
  $ext = strtolower(end($test));
  $name = uniqid("", true) . '.' . $ext;
  $location = 'upload/' . $name;
  $allowed = array('jpg', 'png', 'jpeg', "gif");
  if(in_array($ext, $allowed)){
    move_uploaded_file($_FILES["file"]["tmp_name"], $location);
    echo 'https://typout.com/wp-content/themes/typout/'.$location;
  }else{echo "your file shuould be one of these formats: jpg, png, jpeg or gif";}
}else{echo "the file has no name";}

?>