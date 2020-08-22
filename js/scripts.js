//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//         (((<<<===   text_editor.php   ===>>>)))

//      <<<=== the subject  ===>>>

//<<==  VARIABLES  ==>>

//<<==  EVENTS  ==>>

//<<==  FUNCTIONS  ==>>

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

// GLOBAL VARIABLES
let is_alert_showing = false

//         (((<<<===   author.php   ===>>>)))

//     <<<=== subscribe logic ===>>>
if(document.querySelector(".profile_cover")){

    //<<==  VARIABLES  ==>>
    let subscriber_button = document.querySelector(".subscriber_button")
    let id = document.querySelector("header").dataset.userid
    let id_key = document.querySelector("header").dataset.usercodeid
    let user_post_id = document.querySelector(".subscriber_button").dataset.userpageid
    let sended_element = `&id=${id}&id_key=${id_key}&mission=subscribe&post_user_id=${user_post_id}`

    //<<==  EVENTS  ==>>
    subscriber_button.addEventListener("click", function(){
        if (id != 0){
            if(subscriber_button.style.backgroundColor == "rgb(227, 227, 227)"){
                subscriber_button.style.backgroundColor = "#ffbaba"
                subscriber_button.innerHTML = subscriber_button.dataset.subscribe
                console.log(subscriber_button.style.backgroundColor)
            }else{
                subscriber_button.style.backgroundColor = "#e3e3e3"
                subscriber_button.innerHTML = subscriber_button.dataset.subscribed
                console.log(subscriber_button.style.backgroundColor)
            }
            
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'https://typout.com/wp-content/themes/typout/requests.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function(){console.log(xhr.response)}
            xhr.onerror = function(){notification("there is an error", "white")}
            xhr.send(sended_element);
        }else{
            notification('you are not logged in', 'white')
        }
    })
    //<<==  functions  ==>>
    
}

//      <<<=== fetching posts from the server  ===>>>
if(document.querySelector(".profile_cover")){
    //<<==  VARIABLES  ==>>
    let nav_and_posts = document.querySelector('.nav_and_posts')
    let hidden_box = document.querySelector('#hidden_box')
    let isVisible = false
    var there_is_posts = true
    let author_id = nav_and_posts.dataset.pageuserid
    let pageNum = 1
    let params = `&page=${pageNum}&author_id=${author_id}`

    //<<==  EVENTS  ==>>

    // fetch posts when the page loades without addEventListener
    fetch_posts(nav_and_posts, params)
    pageNum = pageNum + 1

    window.addEventListener("scroll", () => {
        if(there_is_posts){
            if(elementInViewport(hidden_box) && isVisible == false) {
                params = `&page=${pageNum}&author_id=${author_id}`
                fetch_posts(nav_and_posts, params)
                pageNum = pageNum + 1
                isVisible = true
            }
            if(!elementInViewport(hidden_box) && isVisible == true){
                isVisible = false
            }
        }
    })
}

//      <<<=== uploading cover and profile picture  ===>>>
if(document.querySelector(".profile_cover")){

    //<<==  VARIABLES  ==>>
    let profile_image = document.querySelector('#profile_image')
    let cover_image = document.querySelector('#cover_image')
    let user_id = document.querySelector('.site_header').dataset.userid
    let user_id_key = document.querySelector('.site_header').dataset.usercodeid

    //<<==  EVENTS  ==>>
    cover_image.addEventListener("change", function(){
        uploading_cover_image()
    })

    profile_image.addEventListener("change", function(){
        uploading_profile_image()
    })

    //<<==  FUNCTIONS  ==>>
    function uploading_cover_image(){
        let image = document.querySelector('#cover_image').files[0]
        let form_data = new FormData()

        // making form data
        form_data.append("file", image)
        form_data.append("user_id", user_id)
        form_data.append("user_id_key", user_id_key)
        form_data.append("mission", 'uploading_cover_image')

        // sending the file
        let xhr = new XMLHttpRequest(); 
        xhr.open('POST', 'https://typout.com/wp-content/themes/typout/requests.php', true);
        xhr.onload = function() {
            if(xhr.response == 'success'){
                location.reload();
            }else{
                console.log('there is an error')
            }
        }
        xhr.onerror = function(){notification("ther is an error", "white")}
        xhr.send(form_data);
        
    }
    function uploading_profile_image(){
        let image = document.querySelector('#profile_image').files[0]
        let form_data = new FormData()

        // making form data
        form_data.append("file", image)
        form_data.append("user_id", user_id)
        form_data.append("user_id_key", user_id_key)
        form_data.append("mission", 'uploading_profile_image')

        // sending the file
        let xhr = new XMLHttpRequest(); 
        xhr.open('POST', 'https://typout.com/wp-content/themes/typout/requests.php', true);
        xhr.onload = function() {
            if(xhr.response == 'success'){
                location.reload();
            }else{
                console.log('there is an error')
            }
        }
        xhr.onerror = function(){notification("ther is an error", "white")}
        xhr.send(form_data);
        
    }
}

//         (((<<<===   page-advertisement.php   ===>>>)))

//      <<<=== Paste Without Formatting  ===>>>
if(document.querySelector(".PaymentMethods")){

    //<<==  VARIABLES  ==>>
    let main_for_user_ads_page = document.querySelector(".main_for_user_ads_page")
    let add_button = document.querySelector(".payment_button")
    let balance_content = document.querySelector(".balance_content")
    let user_id = document.querySelector("header").dataset.userid
    let user_key = document.querySelector("header").dataset.usercodeid
    
    //<<==  EVENTS  ==>>
    add_button.addEventListener("click", function(){
        balance_content.innerHTML = 
        `
        <div style="display: flex; justify-content: center; margin-bottom: 20px">
            <div>${main_for_user_ads_page.dataset.sentence}</div>
        </div>
        <div style="display: flex; justify-content: center;">
            <div class="payment_button paypal" style="margin-right: 10px">${main_for_user_ads_page.dataset.paypal}</div>
            <div class="payment_button bank" style="margin-right: 10px">${main_for_user_ads_page.dataset.bank}</div>
            <div class="payment_button western">${main_for_user_ads_page.dataset.western}</div>
        </div>
        `
        let paypal = document.querySelector(".paypal")
        let bank = document.querySelector(".bank")
        let western = document.querySelector(".western")
        paypal.addEventListener("click", function(){
            balance_content.innerHTML = 
            `
            <div class="balance_content" style="display: flex; justify-content: center;">
                <div class="form">
                    <form method="POST">
                        <div dir="auto">
                            <label for="paypal_email">${main_for_user_ads_page.dataset.paypalemail}</label><br>
                            <input class="text_input" type="text" name="paypal_email" required>
                        </div>
                        <div dir="auto" style="display: none;">
                            <input class="text_input" type="text" name="user_id" value="${user_id}">
                        </div>
                        <div dir="auto" style="display: none;">
                            <input class="text_input" type="text" name="user_key" value="${user_key}">
                        </div>
                        <div class="form_button_checkbox">
                            <div style="margin: 0;"></div>
                            <div style="margin: 0;">
                                <button>${main_for_user_ads_page.dataset.save}</button> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            `
        })
        bank.addEventListener("click", function(){
            balance_content.innerHTML = 
            `
            <div class="balance_content" style="display: flex; justify-content: center;">
                <div class="form">
                    <form method="POST">
                        <div>
                            <label for="nameonbank">${main_for_user_ads_page.dataset.nameonbank}</label><br>
                            <input class="text_input" type="text" name="nameonbank" required>
                        </div>
                        <div>
                            <label for="bankname">${main_for_user_ads_page.dataset.bankname}</label><br>
                            <input class="text_input" type="text" name="bankname" required>
                        </div>
                        <div dir="auto">
                            <label for="swift">${main_for_user_ads_page.dataset.swift}</label><br>
                            <input class="text_input" type="text" name="swift" required>
                        </div>
                        <div dir="auto">
                            <label for="iban">${main_for_user_ads_page.dataset.iban}</label><br>
                            <input class="text_input" type="text" name="iban" required>
                        </div>
                        <div dir="auto" style="display: none;">
                            <input class="text_input" type="text" name="user_id" value="${user_id}">
                        </div>
                        <div dir="auto" style="display: none;">
                            <input class="text_input" type="text" name="user_key" value="${user_key}">
                        </div>
                        <div class="form_button_checkbox">
                            <div style="margin: 0;"></div>
                            <div style="margin: 0;">
                                <button>${main_for_user_ads_page.dataset.save}</button> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            `
        })
        western.addEventListener("click", function(){
            balance_content.innerHTML = 
            `
            <div class="balance_content" style="display: flex; justify-content: center;">
                <div class="form">
                    <form method="POST">
                        <div dir="auto">
                            <label for="first">${main_for_user_ads_page.dataset.first}</label><br>
                            <input class="text_input" type="text" name="first_name" required>
                        </div>
                        <div dir="auto">
                            <label for="last">${main_for_user_ads_page.dataset.last}</label><br>
                            <input class="text_input" type="text" name="last_name" required>
                        </div>
                        <div dir="auto" style="display: none;">
                            <input class="text_input" type="text" name="user_id" value="${user_id}">
                        </div>
                        <div dir="auto" style="display: none;">
                            <input class="text_input" type="text" name="user_key" value="${user_key}">
                        </div>
                        <div class="form_button_checkbox"> 
                            <div style="margin: 0;"></div>
                            <div style="margin: 0;">
                                <button>${main_for_user_ads_page.dataset.save}</button> 
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            `
        })
    })

}
//         (((<<<===   page-articles.php   ===>>>)))

if(document.querySelector(".main_for_user_control_page")){
    //      <<<=== change post status  ===>>>

    //<<==  VARIABLES  ==>>
    let third_one = document.querySelectorAll(".third_one")
    let public_notification = document.querySelector(".user_control_page_container").dataset.public
    let draft_notification = document.querySelector(".user_control_page_container").dataset.draft
    let current_one = document.querySelector(".current_one")
    let post_id

    //<<==  EVENTS  ==>>
    third_one.forEach(function(item){
        item.addEventListener("click", function(e){
            post_id = e.currentTarget.parentNode.parentNode.parentNode.parentNode.dataset.id
            list = e.currentTarget.parentNode
            if(e.currentTarget.dataset.status == "publish"){
                console.log("its public")
                post_request(post_id)
                let first = list.querySelector(".first_one")
                let third = list.querySelector(".third_one")
                first.innerHTML = `${current_one.dataset.publish}<img src="https://typout.com/wp-content/themes/typout/img/language_icon2.svg" alt="">`
                third.innerHTML = `${current_one.dataset.draft}`
            }else{
                console.log("its draft")
                draft_request(post_id)
                let first = list.querySelector(".first_one")
                let third = list.querySelector(".third_one")
                first.innerHTML = `${current_one.dataset.draft}<img src="https://typout.com/wp-content/themes/typout/img/language_icon2.svg" alt="">`
                third.innerHTML = `${current_one.dataset.publish}`
            }
        })
    })

    //<<==  FUNCTION  ==>>
    function draft_request(post_id_code){

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'https://typout.com/wp-json/wp/v2/posts/' + post_id_code, true);
        xhr.setRequestHeader("X-WP-Nonce", typout_data.nonce);
        xhr.setRequestHeader("Content-type", "application/json");
        xhr.onload = function() {
            var data = JSON.parse(xhr.responseText);
            if (xhr.status >= 200 && xhr.status < 400) {
                notification(draft_notification, "#e6ffec")
            } else {
                console.log(data)
            }
        }
        xhr.onerror = function(){notification("ther is an error", "white")}
        var data_to_post = JSON.stringify({'status' : 'draft'}); 
        xhr.send(data_to_post);
    }

    function post_request(post_id_code){
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'https://typout.com/wp-json/wp/v2/posts/' + post_id_code, true);
        xhr.setRequestHeader("X-WP-Nonce", typout_data.nonce);
        xhr.setRequestHeader("Content-type", "application/json");
        xhr.onload = function() {
            var data = JSON.parse(xhr.responseText);
            if (xhr.status >= 200 && xhr.status < 400) {
                notification(public_notification, "#e6ffec")
            } else {
                console.log(data)
            }
        }
        xhr.onerror = function(){notification("ther is an error", "white")}
        var data_to_post = JSON.stringify({'status' : 'publish'}); 
        xhr.send(data_to_post);
    }
}

if(document.querySelector(".main_for_user_control_page")){

    //      <<<=== delete posts  ===>>>

    //<<==  VARIABLES  ==>>
    let post_container = document.querySelector(".user_control_page_container_body")
    let post_id
    let delete_button = document.querySelectorAll(".delete_button_place") 
    let site_prompt_container = document.querySelector(".site_prompt_container")
    let no_button = document.querySelector("#no")
    let yes_button = document.querySelector("#yes")

    //<<==  EVENTS  ==>>

    // what happens when you click the delete button

    delete_button.forEach(function(item) {
        item.addEventListener('click', function(e) {
          post_id = e.currentTarget.parentNode.parentNode.parentNode.parentNode.dataset.id
          console.log(post_id)
          show_pop_up()
        });
    });

    // what happens when you click the no button
    no_button.addEventListener("click", function(){
        close_pop_up()
    })

    // what happens when you click the yes button
    yes_button.addEventListener("click", function(){
        send_delete_request(post_id)
    })

    //<<==  FUNCTION  ==>>
    function show_pop_up(){
        site_prompt_container.setAttribute("style", "display: flex;")
    }

    function close_pop_up(){
        site_prompt_container.setAttribute("style", "display: none;")
    }
    
    function send_delete_request(id){
        var xhr = new XMLHttpRequest(); 
        xhr.open('DELETE', 'https://typout.com/wp-json/wp/v2/posts/' + id, true);
        xhr.setRequestHeader("X-WP-Nonce", typout_data.nonce);
        xhr.onload = function() {console.log(location.reload())}
        xhr.onerror = function(){notification("ther is an error", "white")}
        xhr.send();
    }
}

//         (((<<<===   header.php   ===>>>)))

//      <<<=== removing the turned on bell and resetting seen in sql database ===>>>
if(document.querySelector(".header_image_container")){

    //<<==  VARIABLES  ==>>
    let search_button = document.querySelector(".search_img_mobile")
    let header = document.querySelector(".header-container")
    let header_inner_html = document.querySelector(".header-container").innerHTML

    //<<==  EVENTS  ==>>
    search_button.addEventListener("click", function(e){
        header.innerHTML = 
        `<div class="search_for_mobile">
            <form autocomplete="off" role="search" method="get" action="https://typout.com/">
                <input type="text" value="" name="s" placeholder="البحث" id="search_input">
                <button type="submit" value="Search">
                    <img style="display: block" class="search_img" src="https://typout.com/wp-content/themes/typout/img/search_icon.svg" alt="">
                </button>
            </form>
        </div>`
    })
}

//      <<<=== removing the turned on bell and resetting seen in sql database ===>>>
if(document.querySelector(".header_image_container")){

    //<<==  VARIABLES  ==>>
    let bell = document.querySelector(".notification_bell")
    let site_header = document.querySelector("header")
    let id = site_header.dataset.userid
    let id_key = site_header.dataset.usercodeid
    let seen = 0

    //<<==  EVENTS  ==>>
    bell.addEventListener("click", function(){
        if(seen == 0){
            bell.setAttribute("style", 'background-image: url("https://typout.com/wp-content/themes/typout/img/bell.svg")')
            // post request
            var xhr = new XMLHttpRequest(); 
            xhr.open('POST', 'https://typout.com/wp-content/themes/typout/requests.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                console.log(xhr.response)
            }
            xhr.onerror = function(){notification("ther is an error", "white")}
            xhr.send('mission=reset_seen' + '&id=' + id + '&id_key=' + id_key);

            seen = 1
        }
    })
}

//      <<<=== show and hide logic for website language list ===>>>
if(document.querySelector(".header_image_container")){

    //<<==  VARIABLES  ==>>
    let site_header = document.querySelector(".site_header")
    let website_language_list = document.querySelectorAll(".website_language_list p")
    let id = site_header.dataset.userid
    let id_key = site_header.dataset.usercodeid

    //<<==  EVENTS  ==>>
    website_language_list.forEach(function(item){
        item.addEventListener("click", function(){
            // variables
            let lang = item.dataset.lang
            
            // post request
            var xhr = new XMLHttpRequest(); 
            xhr.open('POST', 'https://typout.com/wp-content/themes/typout/requests.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                location.reload();
            }
            xhr.onerror = function(){notification("ther is an error", "white")}
            xhr.send('lang=' + lang + '&id=' + id + '&id_key=' + id_key);
        })
    })

}
//      <<<=== showing list when clicking in  website language list ===>>>
if(document.querySelector(".header-container")){

    //<<==  VARIABLES  ==>>
    let website_language_list = document.querySelector(".website_language_list")

    //<<==  EVENTS  ==>>
    document.addEventListener("click", function(e){
        if(e.target.className == "chosen_language" || e.target.className == "language"){
            if(website_language_list.style.display == "none"){
                show_language_list()
            }else{
                hide_language_list()
            }
        }else{
            hide_language_list()
        }
    })

    //<<==  FUNCTION  ==>>
    function show_language_list(){
        website_language_list.style.display = "block"
    }
    function hide_language_list(){
        website_language_list.style.display = "none"
    }
}

//      <<<=== showing menu when clicking in the bell icon ===>>>
if(document.querySelector(".header_image_container")){

    //<<==  VARIABLES  ==>>
    let profile_picture_menu = document.querySelector(".menu_for_bell_icon")

    //<<==  EVENTS  ==>>
    document.addEventListener("click", function(e){
        if(e.target.className == "notification_bell"){
            if(profile_picture_menu.style.display == "none"){
                make_menu_show()
            }else{
                make_menu_hide()
            }
        }else{
            make_menu_hide()
        }
    })
    //<<==  FUNCTION  ==>>
    function make_menu_show(){
        profile_picture_menu.style.display = "block";
    }
    function make_menu_hide(){
        profile_picture_menu.style.display = "none";
    }

}

//      <<<=== showing menu when clicking in the profile picture ===>>>
if(document.querySelector(".header_image_container")){

    //<<==  VARIABLES  ==>>
    let profile_picture_menu = document.querySelector(".menu_for_image_container")

    //<<==  EVENTS  ==>>
    document.addEventListener("click", function(e){
        if(e.target.parentNode == null){

        }else{
            if(e.target.parentNode.className == "header_image_container"){
                if(profile_picture_menu.style.display == "none"){
                    make_menu_show()
                }else{
                    make_menu_hide()
                }
            }else{
                make_menu_hide()
            }
        }
    })
    //<<==  FUNCTION  ==>>
    function make_menu_show(){
        profile_picture_menu.style.display = "block";
    }
    function make_menu_hide(){
        profile_picture_menu.style.display = "none";
    }

}
//         (((<<<===   page-editor.php   ===>>>)))

    //      <<<=== save_alert  ===>>>
    if(document.querySelector(".main_for_text_editor_page")){

    //<<==  VARIABLES  ==>>
    let save_alert = document.querySelector(".save_notification")
    let languages_list = document.querySelectorAll(".languages_list ul li")
    let categories_list = document.querySelectorAll(".categories_list ul li")
    let title = document.querySelector(".text_title_place")
    let text = document.querySelector(".text_writing_place")
    let keyword = document.querySelector(".text_keyword_typing_place")

    //<<==  EVENTS  ==>>
    languages_list.forEach(function(item){
        item.addEventListener("click", function(){
            if(!is_alert_showing){
                show_alert()
            }
        })
    })
    categories_list.forEach(function(item){
        item.addEventListener("click", function(){
            if(!is_alert_showing){
                show_alert()
            }
        })
    })
    title.addEventListener("keydown", function(){
        if(!is_alert_showing){
            show_alert()
        }
    })
    text.addEventListener("keydown", function(){
        if(!is_alert_showing){
            show_alert()
        }
    })
    keyword.addEventListener("keydown", function(e){
        if(e.keyCode == 13){
            if(!is_alert_showing){
                show_alert()
            }
        }
    })

    //<<==  FUNCTIONS  ==>>
    function show_alert(){
        save_alert.style.display = "block"
        save_alert.style.animationName = "show";
        is_alert_showing = true
    }

}
//      <<<=== category select bar  ===>>>
if(document.querySelector(".main_for_text_editor_page")){

    //<<==  VARIABLES  ==>>
    let real_article_language_place = document.querySelector(".article_language_place")
    let article_language_place = document.querySelector(".article_categories_place")
    let languages_list = document.querySelector(".categories_list")
    let selected_language = document.querySelector(".selected_category")
    let language_list_elements = document.querySelectorAll(".categories_list ul li")
    let is_list_open = false
    //<<==  EVENTS  ==>>
    real_article_language_place.addEventListener("click", function(){
        close_categories_list()
    })
    language_list_elements.forEach(function(element){
        element.addEventListener("click", function(){
            selected_language.innerHTML = element.innerHTML
            selected_language.dataset.id = element.dataset.id
            close_categories_list()
        })
    })
    article_language_place.addEventListener("click", function(){
        if(is_list_open == false){
            open_categories_list()
        }else{
            close_categories_list()
        }
    })

    //<<==  FUNCTION  ==>>
    function open_categories_list(){
        languages_list.style.display = "flex"
        setTimeout(function(){
            is_list_open = true
        }, 0)
    }
    function close_categories_list(){
        languages_list.style.display = "none"
        setTimeout(function(){
            is_list_open = false
        }, 0)
    }
}

//      <<<=== language select bar  ===>>>
if(document.querySelector(".main_for_text_editor_page")){

    //<<==  VARIABLES  ==>>
    let article_language_place = document.querySelector(".article_language_place")
    let languages_list = document.querySelector(".languages_list")
    let selected_language = document.querySelector(".selected_language")
    let language_list_elements = document.querySelectorAll(".languages_list ul li")
    let is_list_open = false
    //<<==  EVENTS  ==>>
    language_list_elements.forEach(function(element){
        element.addEventListener("click", function(){
            selected_language.innerHTML = element.innerHTML
            selected_language.dataset.id = element.dataset.id
            close_languages_list()
        })
    })

    article_language_place.addEventListener("click", function(){
        if(is_list_open == false){
            open_languages_list()
        }else{
            close_languages_list()
        }
    })

    //<<==  FUNCTION  ==>>
    function open_languages_list(){
        languages_list.style.display = "flex"
        setTimeout(function(){
            is_list_open = true
        }, 0)
    }
    function close_languages_list(){
        languages_list.style.display = "none"
        setTimeout(function(){
            is_list_open = false
        }, 0)
    }
}

//      <<<=== Paste Without Formatting  ===>>>
if(document.querySelector(".main_for_text_editor_page")){

    //<<==  VARIABLES  ==>>
    let text_place = document.querySelector(".text_writing_place")
    let text_title_place = document.querySelector('.text_title_place')

    //<<==  EVENTS  ==>>
    text_place.addEventListener("paste", function(e) {
        e.preventDefault();
        var text = e.clipboardData.getData("text/plain");
        document.execCommand("insertText", false, text);
    });
    text_title_place.addEventListener("paste", function(e) {
        e.preventDefault();
        var text = e.clipboardData.getData("text/plain");
        document.execCommand("insertText", false, text.replace(/\s\s+/g, ' ').replace(/\\n/g, ' '));
    });

}

//      <<<=== deleting tags  ===>>>
if(document.querySelector(".main_for_text_editor_page")){
    //<<==  VARIABLES  ==>>
    let tags = document.querySelectorAll(".span_child")

    //<<==  EVENTS  ==>>
    tags.forEach(function(tag){
        tag.addEventListener("click", function(e){
            tag.remove()
        })
    })
}

//<<==  FUNCTION  ==>>

//      <<<=== uploading posts thumbnail piture ===>>>
if(document.querySelector(".main_for_text_editor_page")){

    //<<==  VARIABLES  ==>>
    let upload_image_button = document.querySelector("#file2")
    let thumbnail_place = document.querySelector(".text_thumbnail_place")
    let main_for_text = document.querySelector(".main_for_text_editor_page")
    
    //<<==  EVENTS  ==>>
    upload_image_button.addEventListener("change", function(){ 

        // adding loading icon
        thumbnail_place.setAttribute("style", "background-image: url(''), url('https://typout.com/wp-content/themes/typout/img/loading_icon.svg');")
        uploading_thumbnail_image() 
    })

    //<<==  FUNCTION  ==>>
    function uploading_thumbnail_image(){
        let element = document.querySelector('#file2')
        let image = document.querySelector('#file2').files[0]
        let form_data = new FormData()

        // adding file information to form data
        form_data.append("file", image)

        // sending the file
        let xhr = new XMLHttpRequest(); 
        xhr.open('POST', 'https://typout.com/wp-content/themes/typout/upload.php', true);
        xhr.onload = function() {
            if(xhr.response == 'your file shuould be one of these formats: jpg, png, jpeg or gif'){
                notification(xhr.response, '#ffaca6', 'black')
                thumbnail_place.setAttribute("style", "background-size: 15%, 15%; background-image: url('https://typout.com/wp-content/themes/typout/img/upload_image_icon.svg'), url('https://typout.com/wp-content/themes/typout/img/upload_image_icon.svg');")
                element.value = '';
            }else if(xhr.response == 'the file has no name'){
                notification(xhr.response, '#ffaca6', 'black')
                thumbnail_place.setAttribute("style", "background-size: 15%, 15%; background-image: url('https://typout.com/wp-content/themes/typout/img/upload_image_icon.svg'), url('https://typout.com/wp-content/themes/typout/img/upload_image_icon.svg');")
                element.value = '';
            }else{
                thumbnail_place.dataset.imageurl = xhr.response
                thumbnail_place.setAttribute("style", "background-image: url('https://typout.com/wp-content/themes/typout/img/upload_image_icon.svg'), url('" + xhr.response + "');")
            }
        }
        xhr.onerror = function(){notification("ther is an error", "white")}
        xhr.send(form_data);
        
    }
    function saving_thumbnail(){
        let xhr = new XMLHttpRequest
        xhr.open('POST', 'https://typout.com/thumbnail/', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function(){}
        xhr.onerror = function(){notification("ther is an error", "white")}
        xhr.send('post_id=' + main_for_text.dataset.id + '&thumbnail_url=' + thumbnail_place.dataset.imageurl);
    }

}

//      <<<=== uploading pictures in the article area ===>>>
if(document.querySelector(".main_for_text_editor_page")){

    //<<==  VARIABLES  ==>>
    let upload_image_input = document.querySelector("#file")
    let loading_icon
    
    //<<==  EVENTS  ==>>
    upload_image_input.addEventListener("change", function(){ 
        document.execCommand('insertHTML', false, `<img id='loading_icon' src='` + `http:/typout.com/wp-content/themes/typout/img/loading_icon.svg` + `'>`)
        loading_icon = document.querySelector("#loading_icon")
        uploading_image_article() 
    })

    //<<==  FUNCTION  ==>>
    function uploading_image_article(){
        let image = document.querySelector('#file').files[0]
        let image_name = document.querySelector('#file').files[0].name
        let form_data = new FormData()

        // adding file information to form data
        form_data.append("file", image)

        // sending the file
        var xhr = new XMLHttpRequest(); 
        xhr.open('POST', 'https://typout.com/wp-content/themes/typout/upload.php', true);
        xhr.onload = function() {
            console.log("image is uploaded")
            loading_icon.setAttribute("src", xhr.response)
            loading_icon.removeAttribute("id")
        }
        xhr.onerror = function(){notification("ther is an error", "white")}
        xhr.send(form_data);
        
    }

}
//      <<<=== post an Article function ===>>>
if(document.querySelector(".main_for_text_editor_page")){

    //<<==  VARIABLES  ==>>
    let thumbnail_place_data = document.querySelector('.text_thumbnail_place_container div')
    let text_title_place_innerhtml = document.querySelector('.text_title_place').dataset.titledefault
    let selected_language_innerhtml = document.querySelector('.selected_language').dataset.languagedefault
    let selected_category_innerhtml = document.querySelector('.selected_language').dataset.languagedefault

    let post_button = document.querySelector("#create_post_button")
    let main_text_editor = document.querySelector(".main_for_text_editor_page")
    let draft_button = document.querySelector("#draft_button")
    let post_id = main_text_editor.dataset.id
    let thumbnail_place = document.querySelector(".text_thumbnail_place")
    let header_right = document.querySelector(".header-right")
    let tags_ids = []
    
    
    //<<==  EVENTS  ==>>
    post_button.addEventListener("click", function(){
        if(is_able_to_post()){
            posting_tags_publish();
        }else{
            notification(main_text_editor.dataset.message, 'red', 'white')
        }
    })
    draft_button.addEventListener("click", function(){
            posting_tags_draft();
    })

    //<<==  FUNCTION  ==>>

    // a function to know if the person in able to post or not
    function is_able_to_post(){
        let title = document.querySelector('.text_title_place').innerHTML != text_title_place_innerhtml
        let content = document.querySelector('.text_writing_place').textContent != ""
        let thumbnail = thumbnail_place_data.style.backgroundImage == 'url("https://typout.com/wp-content/themes/typout/img/upload_image_icon.svg"), url("https://typout.com/wp-content/uploads/2020/01/no_image_available.jpeg")' || thumbnail_place_data.style.backgroundImage == 'url("https://typout.com/wp-content/themes/typout/img/upload_image_icon.svg"), url("https://typout.com/wp-content/themes/typout/img/upload_image_icon.svg")'
        let language = document.querySelector('.selected_language').innerHTML != selected_language_innerhtml
        let category = document.querySelector('.selected_category').innerHTML != selected_category_innerhtml

        if(title && !thumbnail && language && category && content){
            return true
        }else{
            return false
        }
    }

    // loop for posting tags

    function posting_tags_draft(){
        
        draft_button.innerHTML = header_right.dataset.saving

        let tags = document.querySelectorAll(".span_child")
        let promises = []

        tags.forEach(function(item){
            promises.push(post_tags(item.innerText))
        })

        Promise.all(promises).then(function(){create_draft_article()})
    }

    function posting_tags_publish(){
        
        post_button.innerHTML = header_right.dataset.publishing 

        let tags = document.querySelectorAll(".span_child")
        let promises = []

        tags.forEach(function(item){
            promises.push(post_tags(item.innerText))
        })

        Promise.all(promises).then(function(){create_the_article()})
    }

    // post tags
    function post_tags(tag_name){
        return new Promise(function(resolve, reject){
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'https://typout.com/wp-json/wp/v2/tags/', true);
            xhr.setRequestHeader("X-WP-Nonce", typout_data.nonce);
            xhr.setRequestHeader("Content-type", "application/json");
            xhr.onload = function() {
                let data = JSON.parse(xhr.responseText)
                if(xhr.status == 400){
                    tags_ids.push(data.data.term_id)
                }else{
                    tags_ids.push(data.id)
                }
                resolve()
            }
            xhr.onerror = function(){notification("ther is an error", "white")}
            var data_to_post = JSON.stringify({"name": tag_name}); 
            xhr.send(data_to_post);

        })
    }
    // global variable
    let writing_tool_bar = document.querySelector(".writing_tool_bar")
    // this is for submiting an article to be draft
    function create_draft_article(){

        let text_title_place = document.querySelector(".text_title_place")
        let text_writing_place = document.querySelector(".text_writing_place")
        let post_id_code = document.querySelector(".main_for_text_editor_page").dataset.id
        let language_tag_id = document.querySelector(".selected_language").dataset.id
        let category_tag_id = document.querySelector(".selected_category").dataset.id
        let arr = []
        let save_alert = document.querySelector(".save_notification")

        if(category_tag_id){
            arr.push(category_tag_id)
        }
        if(language_tag_id){
            arr.push(language_tag_id)
        }
        if(arr.length == 0){
            arr.push(1)
        }
        // making the post request
        var xhr = new XMLHttpRequest();
        if(post_id_code){
            xhr.open('POST', 'https://typout.com/wp-json/wp/v2/posts/' + post_id_code, true);
        }else{
            xhr.open('POST', 'https://typout.com/wp-json/wp/v2/posts/', true);
        }
        xhr.setRequestHeader("X-WP-Nonce", typout_data.nonce);
        xhr.setRequestHeader("Content-type", "application/json");
        xhr.onload = function() {
            var data = JSON.parse(xhr.responseText);
            if (xhr.status >= 200 && xhr.status < 400) {
                window.history.pushState('page2', 'Title', 'https://typout.com/editor/?post_id=' + data.id);
                document.querySelector(".main_for_text_editor_page").dataset.id = data.id
                saving_thumbnail()
                draft_button.setAttribute("style", "background-image: url(https://typout.com/wp-content/themes/typout/img/save_icon.svg); background-color: #670700;")
                draft_button.innerHTML = writing_tool_bar.dataset.save
                post_button.setAttribute("style", "background-image: url(https://typout.com/wp-content/themes/typout/img/save_post.svg); background-color: white; border: 1.6px solid black; color: black; line-height: 24px; margin-left: 10px;")
                post_button.innerHTML = writing_tool_bar.dataset.publish
                save_alert.style.animationName = "hide";
                setTimeout(function(){save_alert.style.display = "none"}, 4000)
                is_alert_showing = false
            } else {
                console.log(data)
                notification("ther is an error", "white")
            }
        }
        xhr.onerror = function(){notification("ther is an error", "white")}
        var data_to_post = JSON.stringify({'title' : text_title_place.innerText, 'content' : text_writing_place.innerHTML, 'status' : 'draft', 'tags': tags_ids, 'categories': arr }); 
        xhr.send(data_to_post);

    }

    // this is for submiting an article to be public
    function create_the_article(){

        let text_title_place = document.querySelector(".text_title_place")
        let text_writing_place = document.querySelector(".text_writing_place")   
        let post_id_num = document.querySelector(".main_for_text_editor_page").dataset.id
        let language_tag_id = document.querySelector(".selected_language").dataset.id
        let category_tag_id = document.querySelector(".selected_category").dataset.id
        let arr = []
        let save_alert = document.querySelector(".save_notification")

        if(language_tag_id){
            arr.push(language_tag_id)
        }
        if(category_tag_id){
            arr.push(category_tag_id)
        }
        if(arr.length == 0){
            arr.push(1)
        }

        // making the post request
        var xhr = new XMLHttpRequest();
        if(post_id_num){
            xhr.open('POST', 'https://typout.com/wp-json/wp/v2/posts/' + post_id_num, true);
        }else{
            xhr.open('POST', 'https://typout.com/wp-json/wp/v2/posts/', true);
        }
        xhr.setRequestHeader("X-WP-Nonce", typout_data.nonce);
        xhr.setRequestHeader("Content-type", "application/json");
        xhr.onload = function() {
        var data = JSON.parse(xhr.responseText);
            if (xhr.status >= 200 && xhr.status < 400) {
                window.history.pushState('page2', 'Title', 'https://typout.com/editor/?post_id=' + data.id);
                document.querySelector(".main_for_text_editor_page").dataset.id = data.id
                saving_thumbnail()
                post_button.setAttribute("style", "background-image: url(https://typout.com/wp-content/themes/typout/img/save_post.svg); background-color: #DDFFCB; border: 1.6px solid black; color: black; line-height: 24px; margin-left: 10px;")
                post_button.innerHTML = writing_tool_bar.dataset.save
                draft_button.innerHTML = writing_tool_bar.dataset.draft
                draft_button.style.backgroundColor = "black";
                save_alert.style.animationName = "hide";
                setTimeout(function(){save_alert.style.display = "none"}, 4000)
                is_alert_showing = false
                inser_notification(data.id)
                window.location.href = data.slug + "?share_notification=true";
                
            } else {
                console.log(data)
                notification("ther is an error", "white")
            }
        }
        xhr.onerror = function(){notification("there is an error", "white")}
        var data_to_post = JSON.stringify({'title': text_title_place.innerText, 'content': text_writing_place.innerHTML, 'status': 'publish', 'tags': tags_ids, 'categories': arr });
        xhr.send(data_to_post);
    }
}

//      <<<=== focusing on the content div ===>>>

if(document.querySelector(".main_for_text_editor_page")){

    //<<==  VARIABLES  ==>>

    let content_field = document.querySelector(".text_writing_place")

    //<<==  EVENTS  ==>>

    content_field.focus()

}
//      <<<=== adding placeholder effect to the fields ===>>>

if(document.querySelector(".main_for_text_editor_page")){
    //<<==  VARIABLES  ==>>

    let title_field = document.querySelector(".text_title_place")
    let title_field_data = document.querySelector(".text_title_place").dataset.titledefault
    let keywords_field = document.querySelector(".text_keyword_place")
    let keywords_typing_field = document.querySelector(".text_keyword_typing_place")
    let keywords_typing_field_data = document.querySelector(".text_keyword_typing_place").dataset.keyworddefault

    //<<==  EVENTS  ==>>

    // placeholder effect for title
    title_field.addEventListener("focus", function(){
        if(title_field.innerText == title_field_data){
            title_field.innerHTML = ""
        }
    })
    title_field.addEventListener("focusout", function(){
        if(title_field.innerText == ""){
            title_field.innerHTML = title_field_data
        }
    })
    // placeholder effect for keywords
    keywords_field.addEventListener("click", function(){
        if(keywords_typing_field.innerHTML == keywords_typing_field_data){
            keywords_typing_field.innerHTML = ""
            keywords_typing_field.focus()
        }else{
            keywords_typing_field.focus()
        }
    })
    keywords_typing_field.addEventListener("focusout", function(){
        if(keywords_typing_field.innerHTML == "" && keywords_field.innerHTML == keywords_typing_field.outerHTML){
            keywords_typing_field.innerHTML = keywords_typing_field_data
        }
    })
}

//      <<<=== adding keyword logic ===>>>

if(document.querySelector(".main_for_text_editor_page")){

    //<<==  VARIABLES  ==>>
    let keywords_field = document.querySelector(".text_keyword_place")
    let keywords_typing_field = document.querySelector(".text_keyword_typing_place")

    // default placeholder
    const keyword_placholder_typing = keywords_typing_field.innerText

    //<<==  EVENTS  ==>>
    keywords_typing_field.addEventListener("keydown", function(e){
            if((e.keyCode === 13 || e.key === ",") && keywords_typing_field.innerText != ""){
                adding_html()
                setTimeout(function(){ 
                    empty_the_typing_field()
                }, 0);
                refresh_remove_tag()
            }else if((e.keyCode === 13 || e.key === ",") && keywords_typing_field.innerText == ""){
                setTimeout(function(){ 
                    empty_the_typing_field()
                }, 0);  
            }else if(e.code === "Backspace" && keywords_typing_field.innerText == "" && keywords_field.innerHTML != `<div class="text_keyword_typing_place" contenteditable="true"></div>`){
                remove_last_child()
                setTimeout(function(){ 
                    document.execCommand('selectAll',false,null)
                }, 0);  
            }
    })

    //<<==  FUNCTION  ==>>
    function refresh_remove_tag(){
        let tags = document.querySelectorAll(".span_child")

        tags.forEach(function(tag){
            tag.addEventListener("click", function(e){
                tag.remove()
            })
        })
    }

    function adding_html(){
        keywords_typing_field.insertAdjacentHTML("beforebegin", `<span class="span_child">` + keywords_typing_field.innerText.replace(/\s\s+/g, ' ').trim() + "</span>")
    }
    function empty_the_typing_field(){
        keywords_typing_field.innerHTML = ""
    }
    function remove_last_child(){
            let ele = document.querySelectorAll(".span_child");
            let lastEle = ele[ ele.length-1 ];
            keywords_typing_field.innerText = lastEle.innerText
            lastEle.parentNode.removeChild(lastEle);
    }
}

//      <<<=== icons commands for writing place ===>>>

if(document.querySelector(".main_for_text_editor_page")){

    ///////////////////////
    //<<==  VARIABLES  ==>>
    ///////////////////////

    // to check if its focusing on content place boolean
    let is_content_place = false
    // page title, content and keywords selectors
    let title_place = document.querySelector(".text_title_place")
    let writing_place = document.querySelector(".text_writing_place")
    let keywords_place = document.querySelector(".text_keyword_typing_place")
    // toolbar buttons selector
    let bold = document.querySelector("#bold")
    let italic = document.querySelector("#italic")
    let insertUnorderedList = document.querySelector("#insertUnorderedList")
    let insertorderedList = document.querySelector("#insertorderedList")
    let justifyLeft = document.querySelector("#justifyLeft")
    let justifyCenter = document.querySelector("#justifyCenter")
    let justifyRight = document.querySelector("#justifyRight")
    let strikethrough = document.querySelector("#strikethrough")
    let underline = document.querySelector("#underline")
    let formatBlock = document.querySelector("#formatBlock")
    let post_button = document.querySelector("#create_post_button")
    ////////////////////
    //<<==  EVENTS  ==>>
    ////////////////////
        
    // giving icon active informantion when the page loads without the need of an action (like click action) to show icon's active statue
    check_active_icons()

    // to make sure that the user is focusing on the content area in the page
    title_place.addEventListener("click", function(){is_content_place = false})
    writing_place.addEventListener("click", function(){is_content_place = true})
    keywords_place.addEventListener("click", function(){is_content_place = false})

    // changing buttons active statue when it is clicked
    bold.addEventListener("click", function(){
        if(document.queryCommandState("bold")){
            bold.className = "active_toolbar_icons"
        }else{
            bold.className = "not_active_toolbar_icons"
        }
    })
    italic.addEventListener("click", function(){
        if(document.queryCommandState("italic")){
            italic.className = "active_toolbar_icons"
        }else{
            italic.className = "not_active_toolbar_icons"
        }
    })
    insertUnorderedList.addEventListener("click", function(){
        if(document.queryCommandState("insertUnorderedList")){
            insertUnorderedList.className = "active_toolbar_icons"
        }else{
            insertUnorderedList.className = "not_active_toolbar_icons"
        }
    })
    insertorderedList.addEventListener("click", function(){
        if(document.queryCommandState("insertorderedList")){
            insertorderedList.className = "active_toolbar_icons"
        }else{
            insertorderedList.className = "not_active_toolbar_icons"
        }
    })
    justifyLeft.addEventListener("click", function(){
        if(document.queryCommandState("justifyLeft")){
            justifyLeft.className = "active_toolbar_icons"
        }else{
            justifyLeft.className = "not_active_toolbar_icons"
        }
    })
    justifyCenter.addEventListener("click", function(){
        if(document.queryCommandState("justifyCenter")){
            justifyCenter.className = "active_toolbar_icons"
        }else{
            justifyCenter.className = "not_active_toolbar_icons"
        }
    })
    justifyRight.addEventListener("click", function(){
        if(document.queryCommandState("justifyRight")){
            justifyRight.className = "active_toolbar_icons"
        }else{
            justifyRight.className = "not_active_toolbar_icons"
        }
    })
    strikethrough.addEventListener("click", function(){
        if(document.queryCommandState("strikethrough")){
            strikethrough.className = "active_toolbar_icons"
        }else{
            strikethrough.className = "not_active_toolbar_icons"
        }
    })
    underline.addEventListener("click", function(){
        if(document.queryCommandState("underline")){
            underline.className = "active_toolbar_icons"
        }else{
            underline.className = "not_active_toolbar_icons"
        }
    })
    // making toolbar icons active when it is active and not active when it is not active
    writing_place.addEventListener("click", function(){check_active_icons()})

    //////////////////////
    //<<==  FUNCTION  ==>>
    //////////////////////

    function icon_command(command){
        if(is_content_place){
            document.execCommand(command, false, null)
        }
    }
    function icon_command_with_arg(command, arg){
        if(is_content_place){
            document.execCommand(command, false, arg)
        }
    }
    function icon_command_with_arg2(command, arg){
        if(is_content_place){
            document.execCommand(command, false, "<img src='" + arg + "'>")
        }
    }
    function icon_command_with_arg3(command, arg){
        if(is_content_place){
            document.execCommand(command, false, arg)
        }
    } 


    //checking if buttons icons are active fucntion 
    function check_active_icons(){
        if(document.queryCommandState("bold")){
            bold.className = "active_toolbar_icons"
        }else{
            bold.className = "not_active_toolbar_icons"
        }
        if(document.queryCommandState("italic")){
            italic.className = "active_toolbar_icons"
        }else{
            italic.className = "not_active_toolbar_icons"
        }
        if(document.queryCommandState("insertUnorderedList")){
            insertUnorderedList.className = "active_toolbar_icons"
        }else{
            insertUnorderedList.className = "not_active_toolbar_icons"
        }
        if(document.queryCommandState("insertorderedList")){
            insertorderedList.className = "active_toolbar_icons"
        }else{
            insertorderedList.className = "not_active_toolbar_icons"
        }
        if(document.queryCommandState("justifyLeft")){
            justifyLeft.className = "active_toolbar_icons"
        }else{
            justifyLeft.className = "not_active_toolbar_icons"
        }
        if(document.queryCommandState("justifyCenter")){
            justifyCenter.className = "active_toolbar_icons"
        }else{
            justifyCenter.className = "not_active_toolbar_icons"
        }
        if(document.queryCommandState("justifyRight")){
            justifyRight.className = "active_toolbar_icons"
        }else{
            justifyRight.className = "not_active_toolbar_icons"
        }
        if(document.queryCommandState("strikethrough")){
            strikethrough.className = "active_toolbar_icons"
        }else{
            strikethrough.className = "not_active_toolbar_icons"
        }
        if(document.queryCommandState("underline")){
            underline.className = "active_toolbar_icons"
        }else{
            underline.className = "not_active_toolbar_icons"
        }
    }
}

//         (((<<<===   SEARCH.php   ===>>>)))

//      <<<=== fetching posts from the server  ===>>>
if(document.querySelector(".main_for_search")){

    //<<==  VARIABLES  ==>>
    let nav_and_posts = document.querySelector('.nav_and_posts')
    let hidden_box = document.querySelector('#hidden_box')
    let isVisible = false
    var there_is_posts = true
    let search_term = document.URL.replace("https://typout.com/?s=", "")
    let pageNum = 1
    let params = `&page=${pageNum}&search_term=${search_term}`

    //<<==  EVENTS  ==>>

    // fetch posts when the page loades without addEventListener
    fetch_posts(nav_and_posts, params)
    pageNum = pageNum + 1

    window.addEventListener("scroll", () => {
        if(there_is_posts){
            if(elementInViewport(hidden_box) && isVisible == false) {
                params = `&page=${pageNum}&search_term=${search_term}`
                fetch_posts(nav_and_posts, params)
                pageNum = pageNum + 1
                isVisible = true
            }
            if(!elementInViewport(hidden_box) && isVisible == true){
                isVisible = false
            }
        }
    })
}

//         (((<<<===   SINGLE.php   ===>>>)))

//     <<<=== comment section ===>>>
if(document.querySelector("#aticle_page")){

    //<<==  VARIABLES  ==>>
    let comment_button = document.querySelector(".comment_button")
    let current_user_display_name = document.querySelector(".comment_button").dataset.currentuserdisplayname
    let currentimageurl = document.querySelector(".comment_button").dataset.currentimageurl
    let commet_loop_place = document.querySelector(".comment_loop_place")
    let the_input = document.querySelector(".the_input")
    let id = document.querySelector("header").dataset.userid
    let id_key = document.querySelector("header").dataset.usercodeid
    let post_id = document.querySelector(".first_column").dataset.currentpostid
    let sended_params = ""

    //<<==  EVENTS  ==>>
    comment_button.addEventListener("click", function(){
        if (id != 0){
            if(the_input.value){
                
                // adding the comment to the comment section
                commet_loop_place.insertAdjacentHTML("afterbegin", `
                <div class="comment_loop_header">
                    <div class="comment_header_left_side">
                        <div class="profile_image_in_comments" style='background-image: url("${currentimageurl}")'></div>
                        <p style="margin: 0 7.5px 0 0;">${current_user_display_name}</p> 
                    </div>
                    <div class="comment_header_right_side" style="display: none;"><img src="" alt=""></div>
                </div>
                <div class="comment_loop_body" style="margin-bottom: 15px;"> 
                    <div class="comment_body_text">${the_input.value}</div>
                </div>`)
                // making the params for the request 
                sended_params = `&id=${id}&id_key=${id_key}&mission=comment&the_post_id=${post_id}&body=${the_input.value}`
                // clearing the input
                the_input.value = ""
                // sending the comment to the server to save it
                let xhr = new XMLHttpRequest();
                xhr.open('POST', 'https://typout.com/wp-content/themes/typout/requests.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function(){console.log(xhr.response)}
                xhr.onerror = function(){notification("there is an error", "white")}
                xhr.send(sended_params);
            }
        }else{
            notification('you are not logged in', 'white')
        }
    })

    //<<==  functions  ==>>

}

//     <<<=== subscribe logic ===>>>
if(document.querySelector("#aticle_page")){

    //<<==  VARIABLES  ==>>
    let subscriber_button = document.querySelector(".subscriber_button")
    let id = document.querySelector("header").dataset.userid
    let id_key = document.querySelector("header").dataset.usercodeid
    let user_post_id = document.querySelector(".first_column").dataset.userpostid
    let post_elements = `&id=${id}&id_key=${id_key}&mission=subscribe&post_user_id=${user_post_id}`

    //<<==  EVENTS  ==>>
    subscriber_button.addEventListener("click", function(){

        if (id != 0){
            if(subscriber_button.style.backgroundColor == "rgb(227, 227, 227)"){
                subscriber_button.style.backgroundColor = "#ffbaba"
                subscriber_button.innerHTML = subscriber_button.dataset.subscribe
            }else{
                subscriber_button.style.backgroundColor = "#e3e3e3"
                subscriber_button.innerHTML = subscriber_button.dataset.subscribed
            }
            
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'https://typout.com/wp-content/themes/typout/requests.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function(){console.log(xhr.response)}
            xhr.onerror = function(){notification("there is an error", "white")}
            xhr.send(post_elements);
        }else{
            notification('you are not logged in', 'white')
        }

    })
    //<<==  functions  ==>>
    
}

//     <<<=== fetching posts for side bar ===>>>
if(document.querySelector("#aticle_page")){

    //<<==  VARIABLES  ==>>
    let nav_and_posts = document.querySelector('.side_bar_posts_container')
    let hidden_box = document.querySelector('#hidden_box')
    let isVisible = false
    var there_is_posts = true
    let language = document.querySelector('main').dataset.language
    let pageNum = 1
    let params = `&page=${pageNum}&language=${language}`

    //<<==  EVENTS  ==>>
    // fetch posts when the page loades without addEventListener
    fetch_posts_sidebar(nav_and_posts, params)
    pageNum = pageNum + 1

    window.addEventListener("scroll", () => {
        if(there_is_posts){
            if(elementInViewport(hidden_box) && isVisible == false) {
                params = `&page=${pageNum}&language=${language}`
                fetch_posts_sidebar(nav_and_posts, params)
                pageNum = pageNum + 1
                isVisible = true
            }
            if(!elementInViewport(hidden_box) && isVisible == true){
                isVisible = false
            }
        }
    })

    //<<==  functions  ==>>
    // a function to fetch posts from the server
function fetch_posts_sidebar(container_element, params){

    for(i = 0; i < 10; i++){
        container_element.insertAdjacentHTML("beforeend", `
        <a href="" class="must_delete">
            <div class="profile_posts_sidebar" style="opacity: 25%;">
                <img class="the_image">
                <div class="post_information_for_article">
                    <div class="post_header_sidebar">
                        <div class="post_title_in_card"></div>
                        <div class="post_timeandviews_sidebar"></div>
                        <div class="profile_picture_in_card">
                            <p>
                                <div class="author"></div>
                            </p>
                        </div>
                    </div>    
                </div>
            </div>
        </a>
        `);
    }

    // making the request to the server
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'https://typout.com/wp-content/themes/typout/requests.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function(){
        if(xhr.response == "[]"){
            there_is_posts = false
            let must_remove = document.querySelectorAll('.must_delete')
            must_remove.forEach(function(item){
                item.remove()
            })
        }else{
            let output = ''
            let must_remove = document.querySelectorAll('.must_delete')
            must_remove.forEach(function(item){
                item.remove()
            })
            posts_array = JSON.parse(xhr.response)
            posts_array.forEach(function(item){
                output += `
                <a href="${item.the_permalink}">
                    <div class="profile_posts_sidebar">
                        ${item.the_post_thumbnail}
                        <div class="post_information_for_article">
                            <div class="post_header_sidebar">
                                <div class="post_title_in_card">${item.the_title}</div>
                                <div class="profile_picture_in_card">
                                    <p>
                                        <div class="author">${item.the_author_posts_link}</div>
                                    </p>
                                </div>
                                <div class="post_timeandviews_sidebar">${item.views}&nbsp;<img src="https://typout.com/wp-content/themes/typout/img/views_black.svg" style="object-fit: contain; height: 15px; width: 15px; margin-bottom: -2.5px;">&nbsp;</div>
                            </div>    
                        </div>
                    </div>
                </a>
                `
            })
            container_element.insertAdjacentHTML("beforeend", output);
        }
    }
    xhr.onerror = function(){notification("there is an error", "white")}
    xhr.send(params);
}

}

//     <<<=== like and dislike logic ===>>>

if(document.querySelector("#aticle_page")){

    //<<==  VARIABLES  ==>>
    const like = document.querySelector(".article_header_container .article_like")
    const dislike = document.querySelector(".article_header_container .article_dislike")
    const current_post_id = document.querySelector(".first_column").dataset.currentpostid
    const user_id = document.querySelector("header").dataset.userid
    const user_id_key = document.querySelector("header").dataset.usercodeid
    let params = ""

    //<<==  EVENTS  ==>>

    like.addEventListener("click", function(){
        if (user_id != 0){
            if(like.classList.contains("clicked")){
                like.classList.remove("clicked");
                like.innerHTML = parseInt(like.innerHTML) - 1
                // remove like
                params = `post_id=${current_post_id}&id=${user_id}&id_key=${user_id_key}&like_type=delete`
                send_request(params)
            }else{
                if(dislike.classList.contains("clicked")){
                    dislike.classList.remove("clicked");
                    dislike.innerHTML = parseInt(dislike.innerHTML) - 1
                    like.classList.add("clicked");
                    like.innerHTML = parseInt(like.innerHTML) + 1
                    // change from dislike to like
                    params = `post_id=${current_post_id}&id=${user_id}&id_key=${user_id_key}&like_type=like`
                    send_request(params)
                }else{
                    like.classList.add("clicked");
                    like.innerHTML = parseInt(like.innerHTML) + 1
                    // adding like
                    params = `post_id=${current_post_id}&id=${user_id}&id_key=${user_id_key}&like_type=like`
                    send_request(params)
                }
            }
        }else{
            notification('you are not logged in', 'white')
        }
    })
    dislike.addEventListener("click", function(){
        if(user_id != 0){
            if(dislike.classList.contains("clicked")){
                dislike.classList.remove("clicked");
                dislike.innerHTML = parseInt(dislike.innerHTML) - 1
                // remove dislike
                params = `post_id=${current_post_id}&id=${user_id}&id_key=${user_id_key}&like_type=delete`
                send_request(params)
            }else{
                if(like.classList.contains("clicked")){
                    like.classList.remove("clicked");
                    like.innerHTML = parseInt(like.innerHTML) - 1
                    dislike.classList.add("clicked");
                    dislike.innerHTML = parseInt(dislike.innerHTML) + 1
                    // change from like to dislike
                    params = `post_id=${current_post_id}&id=${user_id}&id_key=${user_id_key}&like_type=dislike`
                    send_request(params)
                }else{
                    dislike.classList.add("clicked");
                    dislike.innerHTML = parseInt(dislike.innerHTML) + 1
                    // adding dislike
                    params = `post_id=${current_post_id}&id=${user_id}&id_key=${user_id_key}&like_type=dislike`
                    send_request(params)
                }
            }
        }else{
            notification("you are not logged in", 'white')
        }
    })
    //<<==  FUNCTIONS  ==>>
    function send_request(parameters){
        let xhr = new XMLHttpRequest(); 
        xhr.open('POST', 'https://typout.com/wp-content/themes/typout/requests.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {console.log(xhr.response)}
        xhr.onerror = function(){notification("ther is an error", "white")}
        xhr.send(parameters);
    }

}

//         (((<<<===   INDEX.php   ===>>>)))

//     <<<=== chosing category logic ===>>>

if(document.querySelector("#home_page")){

    //<<==  VARIABLES  ==>>
    let categories = document.querySelectorAll(".index_category_bar div")

    //<<==  EVENTS  ==>>
    categories.forEach(function(item){
        item.addEventListener("click", function(){
            categories.forEach(function(item){
                if(item.hasAttribute("style")){
                    item.removeAttribute("style")
                }
            })
            item.setAttribute("style", "background-color: black; color: white;")
        })
    })

    //<<==  FUNCTIONS  ==>>
}

//     <<<=== loading more posts script ===>>>

if(document.querySelector("#home_page")){

    //<<==  VARIABLES  ==>>
    
    // elements
    let hidden_box = document.querySelector("#hidden_box")
    let posts_container = document.querySelector(".cards-container")
    let categories = document.querySelectorAll(".index_category_bar div")

    // variable needed to limit the ammount of requests 
    let isVisible = false
    let there_is_posts = true

    // post request's params variables
    let pageNum = 1
    let cat = 0

    //<<==  EVENTS  ==>>

    // deciding what category to choose
    categories.forEach(function(item){
        item.addEventListener("click", function(){
            cat = item.dataset.id
            pageNum = 1
            there_is_posts = true
            posts_container.innerHTML = ""
            father_post_request(false)
        })
    })
    
    // call this function in the beggining of page load
    father_post_request(false)
    
    // call this function when the scroll event runs
    window.addEventListener("scroll", () => {
        if(there_is_posts){
            if(elementInViewport(hidden_box) && isVisible == false) {
                father_post_request(true)
            }
            if(!elementInViewport(hidden_box) && isVisible == true){
                isVisible = false
            }
        }
    })



    //<<==  FUNCTIONS  ==>>

    function father_post_request(isvisible){

        // make someting when the hidden box is visible in the screen
        let parameters = '&page=' + pageNum + '&categories=' + cat

        for(i = 0; i < 10; i++){
            posts_container.insertAdjacentHTML("beforeend", `
            <div class="card must_delete" style="opacity: 25%;">
                <div class="card-image" style="background-color: white;">
                    <img src="https://typout.com/wp-content/themes/typout/img/white.png">
                </div>
                <div class="card-content">
                    <div class="card-title">
                    <p dir="auto" style="color: white;">malik</p>
                        <div class="card-info">
                            <div class="card-left">
                                <div class="author" style="color: white;">malik</div>
                            </div>
                            <div></div>
                        </div>
                    </div>
                </div>
            </div>
            `);
        }
        post_request(parameters, isvisible)
    }

    // post request you can put in it your custom send() parameters
    function post_request(params, is_visible){
        let is_there_post = true
        let xhr = new XMLHttpRequest()
        xhr.open("POST", "https://typout.com/wp-content/themes/typout/requests.php", true)
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            // checking if there is response 
            if (xhr.responseText == "[]"){
                there_is_posts = false
            }
            // converting json to javascript array
            let posts = JSON.parse(xhr.response)
            let must_delete = document.querySelectorAll(".must_delete")
            let output = ''

            // deleting loading posts
            must_delete.forEach(function(item){
                item.remove()
            })

            // adding the response posts to the website
            posts.forEach(function(item){
                output += `
                <div class="card">
                    <a href="${item.the_permalink}">
                        <div class="card-image">
                            ${item.the_post_thumbnail}
                        </div>
                    </a>
                    <div class="card-content">
                        <div class="card-title">
                        <a href="${item.the_permalink}"> <p dir="auto">${item.the_title}</p> </a>
                            <div class="card-info">
                                <div class="card-left">
                                    <div class="author">${item.the_author_posts_link}</div>
                                </div>
                                <div>${item.views}&nbsp;<img src="https://typout.com/wp-content/themes/typout/img/views_black.svg" style="height: 15px; width: 15px; margin-bottom: -2.5px;">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                </div>
                `
            })

            posts_container.insertAdjacentHTML("beforeend", output)

            // important for the systeme to work
            pageNum = pageNum + 1
            isVisible = is_visible
        }
        xhr.onerror = function(){notification("there is an error", "white")}
        xhr.send(params);
    }

}

//         (((<<<===   GLOBAL FUNCTIONS   ===>>>)))

//      <<<=== removing the turned on bell and resetting seen in sql database ===>>>

function inser_notification(the_post_id){

    //<<==  VARIABLES  ==>>
    let site_header = document.querySelector("header")
    let id = site_header.dataset.userid
    let id_key = site_header.dataset.usercodeid
    
    // post request
    var xhr = new XMLHttpRequest(); 
    xhr.open('POST', 'https://typout.com/wp-content/themes/typout/requests.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {}
    xhr.onerror = function(){notification("ther is an error", "white")}
    xhr.send('mission=inser_notification' + '&post_id=' + the_post_id + '&id=' + id + '&id_key=' + id_key);
}


// a function to fetch posts from the server
function fetch_posts(container_element, params){

    for(i = 0; i < 10; i++){
        container_element.insertAdjacentHTML("beforeend", `
        <div class="card must_delete" style="opacity: 25%;">
            <div class="card-image" style="background-color: white;">
                <img src="https://typout.com/wp-content/themes/typout/img/white.png">
            </div>
            <div class="card-content">
                <div class="card-title">
                <p dir="auto" style="color: white;">malik</p>
                    <div class="card-info">
                        <div class="card-left">
                            <div class="author" style="color: white;">malik</div>
                        </div>
                        <div></div>
                    </div>
                </div>
            </div>
        </div>
        `);
    }

    // making the request to the server
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'https://typout.com/wp-content/themes/typout/requests.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function(){
        if(xhr.response == "[]"){
            there_is_posts = false
            let must_remove = document.querySelectorAll('.must_delete')
            must_remove.forEach(function(item){
                item.remove()
            })
        }else{
            let output = ''
            let must_remove = document.querySelectorAll('.must_delete')
            must_remove.forEach(function(item){
                item.remove()
            })
            posts_array = JSON.parse(xhr.response)
            posts_array.forEach(function(item){
                output += `
                <div class="card">
                    <a href="${item.the_permalink}">
                        <div class="card-image">
                            ${item.the_post_thumbnail}
                        </div>
                    </a>
                    <div class="card-content">
                        <div class="card-title">
                        <a href="${item.the_permalink}"> <p dir="auto">${item.the_title}</p> </a>
                            <div class="card-info">
                                <div class="card-left">
                                    <div class="author">${item.the_author_posts_link}</div>
                                </div>
                                <div>${item.views}&nbsp;<img src="https://typout.com/wp-content/themes/typout/img/views_black.svg" style="height: 15px; width: 15px; margin-bottom: -2.5px;">&nbsp;</div>
                            </div>
                        </div>
                    </div>
                </div>
                `
            })
            container_element.insertAdjacentHTML("beforeend", output);
        }
    }
    xhr.onerror = function(){notification("there is an error", "white")}
    xhr.send(params);
}

// you call it whenever you want to tell the user something
function notification(notification_message, background_color, color){
    let container = document.querySelector(".notification_bar_container")
    let message_container = document.querySelector(".notification_bar")
    let message = document.querySelector(".notification_bar_message")

    message_container.style.backgroundColor = background_color
    if(color){
        message_container.style.color = color
    }else{
        message_container.style.color = 'black'
    }
    message.innerHTML = notification_message
    container.style.display = "flex"
    setTimeout(function(){
        container.style.display = "none";
    }, 3900)
}

// this is a function that will return a boolean wich will tell us if a certain element is visible in the viewport or not
function elementInViewport(el) {
    var top = el.offsetTop;
    var left = el.offsetLeft;
    var width = el.offsetWidth;
    var height = el.offsetHeight;

    while(el.offsetParent) {
        el = el.offsetParent;
        top += el.offsetTop;
        left += el.offsetLeft;
    }

    return (
        top < (window.pageYOffset + window.innerHeight) &&
        left < (window.pageXOffset + window.innerWidth) &&
        (top + height) > window.pageYOffset &&
        (left + width) > window.pageXOffset
    );
}





