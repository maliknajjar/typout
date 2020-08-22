<?php include "lang_config.php"; ?>

<?php get_header(); 

global $current_user;
global $wp_query;

if(is_user_logged_in()){
?>
    <main class="main_for_user_control_page">
        <?php include "userSettingList.php"; ?>
        <div class="container_of_the_content">
            <div class="user_control_page_title"><?php echo $lang[42]; ?></div>
            <div class="user_control_page_container" data-public="<?php echo $lang[71]; ?>" data-draft="<?php echo $lang[71]; ?>">
                <div class="user_control_page_container_header">
                    <div class="posts_list_title"><?php echo $lang[43]; ?></div>
                    <div class="posts_list_views"><?php echo $lang[44]; ?></div>
                    <div class="posts_list_comments"><?php echo $lang[45]; ?></div>
                    <div class="posts_list_date"><?php echo $lang[46]; ?></div>
                    <div class="posts_list_statue"><?php echo $lang[47]; ?></div>
                </div>
                <?php 

                if(isset($_GET["page_number"])){
                    $current_page = $_GET["page_number"];
                }else{
                    $current_page = 1;
                }

                $query = new wp_query(array(
                'posts_per_page' => '10',
                'post_type' => 'post',
                'post_status' => array('publish', 'draft'),  
                'author' => $current_user->ID,
                'paged' => $current_page
                ));

                while($query->have_posts()) {

                    $query->the_post();
                    // views sql query
                    $current_post_id = get_the_ID();
                    $views = $wpdb->get_results("SELECT * FROM `_typ_posts` WHERE ID = $current_post_id")[0]->views;
                    ?>
                <div class="user_control_page_container_body" data-id="<?php echo get_the_ID() ?>">
                    <div class="posts_list_title the_title_place"><div class="thumbnail_container"><a href="https://typout.com/editor/?post_id=<?php echo get_the_ID() ?>" target="_blank"><div class="post_thumbnail_control_panel" style="background-image: url(<?php the_post_thumbnail_url('small_thumbnail') ?>);"></div></a></div><div class="title_flex_place"><a class="title_for_underline" href="https://typout.com/editor/?post_id=<?php echo get_the_ID() ?>" target="_blank"><?php the_title() ?></a><img src="<?php echo get_theme_file_uri('/img/edit_icon.svg') ?>" alt=""><br><div class="delete_button_div" style="display: flex; margin-top: 5px; "><div class="delete_button_place" style="cursor: pointer;"><p style="color: red;font-weight:bold;text-decoration: none;"><?php echo $lang[48]; ?></p><img src="<?php echo get_theme_file_uri('/img/delete_icon.jpg') ?>" alt=""></div><a style="cursor: pointer;" href="<?php echo get_the_permalink(); ?>" target="_blank"><div><p style="margin-left: 5px; color: black; font-weight:bold;text-decoration: none;"><?php echo $lang[70]; ?></p><img src="<?php echo get_theme_file_uri('/img/views_black.svg') ?>" alt=""></div></a></div></div></div>
                    <div class="posts_list_views"><?php echo $views; ?></div>
                    <div class="posts_list_comments">...</div>
                    <div class="posts_list_date"><?php the_time('d.m.Y') ?></div>
                    <div class="posts_list_statue statue_remove_padding">
                        <div class="current_one">
                            <ul>
                            <?php if(get_post_status() == "draft"){ ?>
                                <p><?php echo $lang[49]; ?></p>
                            <?php }else{?>
                                <p><?php echo $lang[50]; ?></p>
                            <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php 
                } ?>
            </div>
            <div class="pagination_container">
                <?php
                // pagination place
                $total_posts_count = $query->found_posts;
                $max_page_count = round($total_posts_count / 10);
                ?>
                <?php if($current_page > 1){ ?>
                    <a href="https://typout.com/articles/?page_number=<?php echo $current_page - 1; ?>"><div class="pagination_bar">Previuos page</div></a>
                <?php } ?>
                <?php if($current_page < $max_page_count){ ?>
                    <a href="https://typout.com/articles/?page_number=<?php echo $current_page + 1; ?>"><div class="pagination_bar">Next page</div></a>
                <?php } ?>
            </div>
        </div>
    </main>

<?php }else{
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.location.href='https://typout.com/login';
    </SCRIPT>");
    } ?>

<?php get_footer(); ?>