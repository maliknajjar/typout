<?php include "lang_config.php"; ?>

<?php get_header();
global $wp_query; ?>

<! –– CARDS CONTAINER ––>
<main class="main_for_search">
    <div dir="auto" style="padding: 15px; font-size: 30px; padding-bottom: 0; text-align: center;"><?php echo $lang[17] ?></div>
    <div class="nav_and_posts"></div>
    <div id="hidden_box"></div>
</main>

<! –– END CARDS CONTAINER ––>
<?php get_footer(); ?>