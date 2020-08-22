<?php include "lang_config.php"; 

$arr = [
    "Culture" => $lang[59],
    "Economy" => $lang[60],
    "Sport" => $lang[61],
    "Fashion" => $lang[62],
    "Health" => $lang[63],
    "News" => $lang[64],
    "Politics" => $lang[65],
    "Sience" => $lang[66],
    "Technology" => $lang[67],
];

if(is_user_logged_in()){
get_header(); 
?>

<div class="writing_tool_bar" data-draft="<?php echo $lang[49]; ?>" data-publish="<?php echo $lang[5]; ?>" data-save="<?php echo $lang[1]; ?>">
    <select id="formatBlock" onclick="icon_command_with_arg('formatBlock', this.value)">
        <option value="p">Paragraph</option>
        <option value="H1">Heading 1</option>
        <option value="H2">Heading 2</option>
        <option value="H3">Heading 3</option>
        <option value="H4">Heading 4</option>
        <option value="H5">Heading 5</option>
        <option value="H6">Heading 6</option>
    </select>
    <label class="not_active_toolbar_icons" for="file">
        <img src="<?php echo get_theme_file_uri('/img/editor icons/image_icon.svg') ?>" alt="">
        <input style="display: none;" id="file" name="file" type="file" />
    </label>
    <button id="bold" class="not_active_toolbar_icons" onclick="icon_command('bold')" ><img src="<?php echo get_theme_file_uri('/img/editor icons/004-bold.svg') ?>" alt=""></button>
    <button id="italic" class="not_active_toolbar_icons" onclick="icon_command('italic')" ><img src="<?php echo get_theme_file_uri('/img/editor icons/024-italic.svg') ?>" alt=""></button>
    <button id="insertUnorderedList" class="not_active_toolbar_icons" onclick="icon_command('insertUnorderedList')" ><img src="<?php echo get_theme_file_uri('/img/editor icons/006-bullet list.svg') ?>" alt=""></button>
    <button id="insertorderedList" class="not_active_toolbar_icons" onclick="icon_command('insertorderedList')" ><img src="<?php echo get_theme_file_uri('/img/editor icons/006-normal list.svg') ?>" alt=""></button>
    <button id="justifyLeft" class="not_active_toolbar_icons" onclick="icon_command('justifyLeft')" ><img src="<?php echo get_theme_file_uri('/img/editor icons/002-align left.svg') ?>" alt=""></button>
    <button id="justifyCenter" class="not_active_toolbar_icons" onclick="icon_command('justifyCenter')" ><img src="<?php echo get_theme_file_uri('/img/editor icons/001-align center.svg') ?>" alt=""></button>
    <button id="justifyRight" class="not_active_toolbar_icons" onclick="icon_command('justifyRight')" ><img src="<?php echo get_theme_file_uri('/img/editor icons/003-align right.svg') ?>" alt=""></button>
    <button id="strikethrough" class="not_active_toolbar_icons" onclick="icon_command('strikethrough')" ><img src="<?php echo get_theme_file_uri('/img/editor icons/048-strikethrough.svg') ?>" alt=""></button>
    <button id="underline" class="not_active_toolbar_icons" onclick="icon_command('underline')" ><img src="<?php echo get_theme_file_uri('/img/editor icons/059-underline.svg') ?>" alt=""></button>
    <button id="image_link" class="not_active_toolbar_icons" onclick="icon_command_with_arg2('insertHTML',prompt('Enter image URL:'))" ><img src="<?php echo get_theme_file_uri('/img/editor icons/image_link.svg') ?>" alt=""></button>
    <button id="CreateLink" class="not_active_toolbar_icons" onclick="icon_command_with_arg('CreateLink',prompt('Enter a URL:', 'http:/'+'/'))" ><img src="<?php echo get_theme_file_uri('/img/editor icons/create_link.svg') ?>" alt=""></button>
    <button id="insert_html" class="not_active_toolbar_icons" onclick="icon_command_with_arg3('insertHTML',prompt('Enter HTML here:'))" ><img src="<?php echo get_theme_file_uri('/img/editor icons/html_icon.svg') ?>" alt=""></button>
</div>
<?php

    if(isset($_GET['post_id'])){
        $post_id = $_GET['post_id'];


        global $current_user;
        $query = new wp_query(array(
            'p' => $post_id,
            'posts_per_page' => 1,
            'post_type' => 'post',
            'author' => $current_user->ID
        ));

        while($query->have_posts()){
                $query->the_post(); ?>
            <main data-id="<?php echo get_the_ID() ?>" class="main_for_text_editor_page" data-message='<?php echo $lang[76] ?>'>
                <div style="max-width: 800px; margin-left: auto; margin-right: auto; line-height: 140%; border: 1.6px solid black; background-color: black; padding: 15px; border-radius: 5px; color: white; margin-bottom: 15px; text-align: center; font-size: larger"><?php echo $lang[138]; ?></div>
                <div class="text_title_place" contenteditable="true" dir="auto" data-titledefault="<?php echo $lang[52]; ?>"><?php the_title() ?></div>
                <div class="text_thumbnail_place_container">
                    <label for="file2">
                        <div class="text_thumbnail_place" data-imageurl="<?php echo get_the_post_thumbnail_url() ?>" style="background-image: url('<?php echo get_theme_file_uri('img/upload_image_icon.svg') ?>'), url(<?php echo get_the_post_thumbnail_url() ?>);"></div>
                    </label>
                    <input style="display: none;" id="file2" name="file2" type="file" />
                </div>            
                <div class="text_writing_place" data-notification="<?php echo $lang[69]; ?>" contenteditable="true" dir="auto"><?php the_content() ?></div>
                <div class="article_language_place">
                    <div style="color: #065FD4;"><?php echo $lang[57]; ?>&nbsp;</div>
                    <div class="selected_language" data-id="<?php echo get_the_category()[1]->term_id; ?>" data-languagedefault="<?php echo $lang[68]; ?>"><?php if(get_the_category()[1]->name == ""){echo $lang[68];}else{echo get_the_category()[1]->name;} ?></div><img src="https://typout.com/wp-content/themes/typout/img/language_icon2.svg" alt="">
                    <div class="languages_list" style="display: none;">
                        <ul>
                            <li data-id="361">English</li>
                            <li data-id="362">العربية</li>
                            <li data-id="364">Français</li>
                            <!-- <li data-id="363">中文</li>
                            <li data-id="365">Pусский</li>
                            <li data-id="366">Español</li> -->
                        </ul>
                    </div>
                </div>
                <div class="article_categories_place">
                    <div style="color: #065FD4;"><?php echo $lang[58]; ?>&nbsp;</div>
                    <div class="selected_category" data-id="<?php echo get_the_category()[0]->term_id; ?>"><?php if(get_the_category()[0]->name == "Uncategorized"){echo $lang[68];}
                    else{
                        $name = get_the_category()[0]->name;
                        $the_name = $arr[$name];
                        echo $the_name;
                        

                    } ?></div><img src="https://typout.com/wp-content/themes/typout/img/language_icon2.svg" alt="">
                    <div class="categories_list" style="display: none;"> 
                        <ul>
                            <li data-id="367"><?php echo $lang[59]; ?></li>
                            <li data-id="352"><?php echo $lang[60]; ?></li>
                            <li data-id="355"><?php echo $lang[61]; ?></li>
                            <li data-id="358"><?php echo $lang[62]; ?></li>
                            <li data-id="353"><?php echo $lang[63]; ?></li>
                            <li data-id="360"><?php echo $lang[64]; ?></li>
                            <li data-id="359"><?php echo $lang[65]; ?></li>
                            <li data-id="354"><?php echo $lang[66]; ?></li>
                            <li data-id="357"><?php echo $lang[67]; ?></li>
                        </ul>
                    </div>
                </div> 
                <div class="text_keyword_place"><?php $arr = get_the_tags( get_the_ID() ); foreach($arr as $item){$output = '<span class="span_child">' . $item->name . '</span>'; echo $output;} ?><div class="text_keyword_typing_place" contenteditable="true" data-keyworddefault="<?php echo $lang[51]; ?>"><?php if($arr){echo "";}else{echo $lang[51];} ?></div></div>
            </main>
        <?php }
    }else{?>
        <main class="main_for_text_editor_page" data-message='<?php echo $lang[76] ?>'>
            <div style="max-width: 800px; margin-left: auto; margin-right: auto; line-height: 140%; border: 1.6px solid black; background-color: black; padding: 15px; border-radius: 5px; color: white; margin-bottom: 15px; text-align: center; font-size: larger"><?php echo $lang[138]; ?></div>
            <div class="text_title_place" contenteditable="true" dir="auto" data-titledefault="<?php echo $lang[52]; ?>"><?php echo $lang[52]; ?></div>
            <div class="text_thumbnail_place_container">
                <label for="file2">
                    <div class="text_thumbnail_place" style="background-size: 15%, 15%; background-image: url('<?php echo get_theme_file_uri('img/upload_image_icon.svg') ?>'), url('<?php echo get_theme_file_uri('img/upload_image_icon.svg') ?>');"></div>
                </label>
                <input style="display: none;" id="file2" name="file2" type="file" />
            </div>
            <div class="text_writing_place" data-notification="<?php echo $lang[69]; ?>" contenteditable="true" dir="auto"><div><br></div></div>
            <div class="article_language_place">
            <div style="color: #065FD4;"><?php echo $lang[57]; ?>&nbsp;</div>
                <div class="selected_language" data-languagedefault="<?php echo $lang[68]; ?>"><?php echo $lang[68]; ?></div><img src="https://typout.com/wp-content/themes/typout/img/language_icon2.svg" alt="">
                <div class="languages_list" style="display: none;">
                    <ul>
                        <li data-id="361">English</li>
                        <li data-id="362">العربية</li>
                        <li data-id="364">Français</li>
                        <!-- <li data-id="363">中文</li>
                        <li data-id="365">Pусский</li>
                        <li data-id="366">Español</li> -->
                    </ul>
                </div>
            </div>
            <div class="article_categories_place">
                <div style="color: #065FD4;"><?php echo $lang[58]; ?>&nbsp;</div>
                <div class="selected_category"><?php echo $lang[68]; ?></div><img src="https://typout.com/wp-content/themes/typout/img/language_icon2.svg" alt="">
                <div class="categories_list " style="display: none;"> 
                    <ul>
                        <li data-id="367"><?php echo $lang[59]; ?></li>
                        <li data-id="352"><?php echo $lang[60]; ?></li>
                        <li data-id="355"><?php echo $lang[61]; ?></li>
                        <li data-id="358"><?php echo $lang[62]; ?></li>
                        <li data-id="353"><?php echo $lang[63]; ?></li>
                        <li data-id="360"><?php echo $lang[64]; ?></li>
                        <li data-id="359"><?php echo $lang[65]; ?></li>
                        <li data-id="354"><?php echo $lang[66]; ?></li>
                        <li data-id="357"><?php echo $lang[67]; ?></li>
                    </ul>
                </div>
            </div> 
            <div class="text_keyword_place"><div class="text_keyword_typing_place" contenteditable="true" data-keyworddefault="<?php echo $lang[51]; ?>"><?php echo $lang[51]; ?></div></div>
        </main>
    <?php }

get_footer(); ?>

<?php }else{
    echo ("<SCRIPT LANGUAGE='JavaScript'>
    window.location.href='https://typout.com/login';
    </SCRIPT>");
    } ?>