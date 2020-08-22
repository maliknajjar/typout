<?php

function html_insert($html_text, $selected_element, $inserted_code, $every_how_many){

  // elements variables
  $ad = $selected_element;
  $code = $inserted_code;

  // loop's variables
  $element_count = substr_count($html_text, $ad);
  $new_start_point = 0;
  $ad_index = strpos($html_text, $ad, $new_start_point);
  $index = 0;
  
  if($every_how_many){
    $chosen_element = $every_how_many;
  }

  // functions
  while($index < $element_count){
    $ad_index = strpos($html_text, $ad, $new_start_point);// finding the ad code position inside the $html_text string
    $ad_end_index = $ad_index + strlen($ad);// adding the add code lenght to the position to give ad's end position

    // inserting code inside the ad code
    if($every_how_many){
      if($index == $chosen_element){
        $html_text = substr_replace($html_text,$code, $ad_end_index, 0);
        $chosen_element = $chosen_element + $every_how_many;
      }
    }else{
      $html_text = substr_replace($html_text, $code, $ad_end_index, 0);
    }

    $new_start_point = $ad_end_index;// changing the new start point to be after the current ad code
    $index = $index + 1;

    // if you want to limit the amount of ads in the article
    if($index == $every_how_many * 2){
      break;
    }

  }
  return $html_text;//return the result
}



?>