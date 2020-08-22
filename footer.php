    <?php
    if (is_user_logged_in()){
        $the_current_user = wp_get_current_user();
        $roles = ( array ) $the_current_user->roles;
        if(!$roles[0]){
        ?> 
        <div class="notification_bar_container" style="display: flex; animation-name: none; animation-duration: unset;">
            <div class="notification_bar" style="color: white; background-color: red; margin: 10px; text-align: center;">
                <div class="notification_bar_message">
                    تم حظر حسابك لانك قمت بالاخلال بشروط و قوانين الموقع ...
                    <a href="https://www.facebook.com/typout.ar" style="color: #fff07a;"> راسلنا على صفحتنا</a>
                     على الفيسبوك اذا كان هنالك سوء تفاهم
                </div>
            </div>
        </div>
        <?php
        }
    }
    ?>

    <div class="notification_bar_container" style="display: none;">
        <div class="notification_bar">
            <div class="notification_bar_message"></div>
        </div>
    </div>
    

    <?php wp_footer(); ?>

</body>
</html>