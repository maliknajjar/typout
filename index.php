<?php
get_header();
include "lang_config.php";  
?>

<! –– CARDS CONTAINER ––>
<main>
    <?php
    if(!is_user_logged_in()){?> 
        <div 
        style="
        background-color: black; 
        border-radius: 15px; 
        margin-bottom: 13.5px; 
        color: white; 
        padding: 30px; 
        font-size: 40px;
        text-align: center;
        line-height: 140%;
        "><?php echo $lang[137]; ?></div>
    <?php
    }?>
    <div class="index_category_bar">
        <div data-id="0" style="background-color: black; color: white;"><?php echo $lang[75]; ?></div>
        <div data-id="367"><?php echo $lang[59]; ?></div>
        <div data-id="352"><?php echo $lang[60]; ?></div>
        <div data-id="355"><?php echo $lang[61]; ?></div>
        <div data-id="358"><?php echo $lang[62]; ?></div>
        <div data-id="353"><?php echo $lang[63]; ?></div>
        <div data-id="360"><?php echo $lang[64]; ?></div>
        <div data-id="359"><?php echo $lang[65]; ?></div>
        <div data-id="354"><?php echo $lang[66]; ?></div>
        <div data-id="357"><?php echo $lang[67]; ?></div>
    </div>
    <div class="cards-container" id="home_page"></div>
    <div id="hidden_box"></div>
</main>

<! –– END CARDS CONTAINER ––>
<?php get_footer(); ?>