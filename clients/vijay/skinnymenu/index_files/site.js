/*
    tagDiv - 2013
    Our portfolio:  http://themeforest.net/user/tagDiv/portfolio

    Thanks for using our theme! :)
*/




var td_is_js_phone = false; //true if current view port width < 768


var td_is_slide_moving = false; //disable touch when the touch sliders are moving


var td_is_touch_device = !!('ontouchstart' in window);
var td_is_iPad = navigator.userAgent.match(/iPad/i) != null;
var td_is_iOS = ( navigator.userAgent.match(/(iPad|iPhone|iPod)/g) ? true : false );
var td_is_ie10 = false;
var td_is_ie = false;

var td_is_phone_screen = false;
//update is phone screen
if ((jQuery(window).width() < 768 || jQuery(window).height() < 768) && td_is_iPad === false) {
    td_is_phone_screen = true
}



//ie 10 check
if (Function('/*@cc_on return document.documentMode===10@*/')()){
    jQuery("html").addClass("ie10");
    td_is_ie10 = true;
}


if (jQuery('html').is('.ie8, .ie9') || td_is_ie10 === true) {
    td_is_ie = true;
}




/*  ----------------------------------------------------------------------------
    tagDiv magic cache
 */
var td_local_cache = {
    data: {},
    remove: function (resurce_id) {
        delete td_local_cache.data[resurce_id];
    },
    exist: function (resurce_id) {
        return td_local_cache.data.hasOwnProperty(resurce_id) && td_local_cache.data[resurce_id] !== null;
    },
    get: function (resurce_id) {
        //console.log('Getting in cache for resurce_id' + resurce_id);
        return td_local_cache.data[resurce_id];
    },
    set: function (resurce_id, cachedData) {
        td_local_cache.remove(resurce_id);
        td_local_cache.data[resurce_id] = cachedData;
    }
};




/*  ----------------------------------------------------------------------------
 Menu script
 */

jQuery('#td-top-menu .sf-menu').supersubs({
    minWidth:    10, // minimum width of sub-menus in em units
    maxWidth:    40, // maximum width of sub-menus in em units
    extraWidth:  1 // extra width can ensure lines don't sometimes turn over
});

if (td_is_touch_device) {
    //touch
    jQuery('#td-top-menu .sf-menu').superfish({
        delay:300,
        speed:'fast',
        useClick:true
    });
} else {
    //not touch
    jQuery('#td-top-menu .sf-menu').superfish({
        delay:500,
        speed:200,
        useClick:false
    });
}

/*  ----------------------------------------------------------------------------
    On load
 */
jQuery().ready(function() {



    //resize all the videos if we have them
    td_resize_videos();






    /*  ----------------------------------------------------------------------------
        Affix menu
     */

    var td_menu_offset = 150;


    switch(tds_snap_menu) {
        case 'never':
            // do nothing? :)
            jQuery('.td-menu-wrap').css('position', 'relative'); //css fix
            break;
        default:
            jQuery('.td-menu-background').affix({
                offset: {
                    top: td_menu_offset
                }
            });
    }


    //put focus on search box in blog header
    jQuery('#search-button').click(function(){
        jQuery(this).delay(200).queue(function(){
            document.getElementById("td-header-search").focus();
            jQuery(this).dequeue();
        });
    });


    //retina images
    td_retina();

    //colorbox
    jQuery('.td-featured-img').colorbox({
        maxWidth:"95%",
        maxHeight:"95%",
        fixed:true
    });



    //load the ajax functions
    td_ajax_load();

    td_ajax_search();


    //show the mobile menu only on phone screen
    if (td_is_phone_screen) {
        //alert('mobile menu');
        td_mobile_menu2();
    } else {
        if (td_is_touch_device === false) {
            //run the mobile menu script on desktop!
            td_mobile_menu2();
        }
    }


    if (td_is_iPad === false && td_is_touch_device === true && tds_mobile_swipe == 'swipe') {
        //load fast click only on touch devices, except ipad
        window.addEventListener('load', function () {
            FastClick.attach(document.body);
        }, false);

    }


    /*  ----------------------------------------------------------------------------
        Scroll to top
     */

    var td_is_scrolling_animation = false;


    jQuery(document).bind('mousewheel DOMMouseScroll MozMousePixelScroll', function(e){
        if (td_is_scrolling_animation === false) {
            return;
        } else {
            td_is_scrolling_animation = false;
            jQuery("html, body").stop();
        }
    });


    if (document.addEventListener){
        document.addEventListener('touchmove', function(e) {
            if (td_is_scrolling_animation === false) {
                return;
            } else {
                td_is_scrolling_animation = false;
                jQuery("html, body").stop();
            }
        }, false);
    }


    jQuery(window).scroll(function(){
        if(td_is_scrolling_animation) {
            return;
        }
        if (jQuery(this).scrollTop() > 400) {
            jQuery('.td-scroll-up').addClass('td-scroll-up-visible');
        } else {
            jQuery('.td-scroll-up').removeClass('td-scroll-up-visible');
        }
    });

    jQuery('.td-scroll-up').click(function(){
        if(td_is_scrolling_animation) {
            return;
        }
        td_is_scrolling_animation = true;

        jQuery('.td-scroll-up').removeClass('td-scroll-up-visible');

        jQuery("html, body").animate({ scrollTop: 0 }, {
                    duration: 1200,
                    easing:'easeInOutQuart',
                    complete: function(){
                            td_is_scrolling_animation = false;
                        }
                    }
            );
        return false;
    });



    td_fake_clicks();


    /**
     * Modal window js code
     */
    jQuery('.popup-with-form').magnificPopup({
        type: 'inline',
        preloader: false,
        focus: '#name',

        // When elemened is focused, some mobile browsers in some cases zoom in
        // It looks not nice, so we disable it:
        callbacks: {
            beforeOpen: function() {
                //empty all fields
                td_modala_empty_all_fields();

                //empty error display div
                td_modala_empty_err_div();

                if(jQuery(window).width() < 700) {
                    this.st.focus = false;
                } else {
                    if (td_is_ie === false) {
                        //do not focus on ie 10
                        this.st.focus = '#login_email';
                    }

                }
            }
        }
    });


    //login
    jQuery('#login-link').on( "click", function() {
        //hides or shows the divs with inputs
        show_hide_content_modala([['#td-login-div', 1], ['#td-register-div', 0], ['#td-forgot-pass-div', 0]]);

        //moves focus on the tab
        modala_swich_tabs([['#login-link', 1], ['#register-link', 0]]);

         if(jQuery(window).width() > 700 && td_is_ie === false) {
             jQuery('#login_email').focus();
         }

        //empty all fields
        //td_modala_empty_all_fields();

        //empty error display div
        td_modala_empty_err_div();
    });
    //login button
    jQuery('#login_button').on( "click", function() {
        handle_login_for_modal_window();
    });
    //enter key on #login_pass
    jQuery('#login_pass').keydown(function(event) {
        if ((event.which && event.which == 13) || (event.keyCode && event.keyCode == 13)) {
            handle_login_for_modal_window();
        }
    });

    //register
    jQuery('#register-link').on( "click", function() {
        //hides or shows the divs with inputs
        show_hide_content_modala([['#td-login-div', 0], ['#td-register-div', 1], ['#td-forgot-pass-div', 0]]);

        //moves focus on the tab
        modala_swich_tabs([['#login-link', 0], ['#register-link', 1]]);

         if(jQuery(window).width() > 700  && td_is_ie === false) {
            jQuery('#register_email').focus();
         }

        //empty all fields
        //td_modala_empty_all_fields();

        //empty error display div
        td_modala_empty_err_div();
    });
    //register button
    jQuery('#register_button').on( "click", function() {
        handle_register_for_modal_window();
    });
    //enter key on #register_user
    jQuery('#register_user').keydown(function(event) {
        if ((event.which && event.which == 13) || (event.keyCode && event.keyCode == 13)) {
            handle_register_for_modal_window();
        }
    });

    //forgot pass
    jQuery('#forgot-pass-link').on( "click", function() {
        //hides or shows the divs with inputs
        show_hide_content_modala([['#td-login-div', 0], ['#td-register-div', 0], ['#td-forgot-pass-div', 1]]);

        //moves focus on the tab
        modala_swich_tabs([['#login-link', 0], ['#register-link', 0]]);

        if(jQuery(window).width() > 700 && td_is_ie === false) {
            jQuery('#forgot_email').focus();
        }

        //empty all fields
        //td_modala_empty_all_fields();

        //empty error display div
        td_modala_empty_err_div();
    });
    //forgot button
    jQuery('#forgot_button').on( "click", function() {
        handle_forgot_password_for_modal_window();
    });
    //enter key on #forgot_email
    jQuery('#forgot_email').keydown(function(event) {
        if ((event.which && event.which == 13) || (event.keyCode && event.keyCode == 13)) {
            handle_forgot_password_for_modal_window();
        }
    });




    //fake placeholder for ie
    jQuery('input, textarea').placeholder();





    /**
     * More stories box
     */
    if(tds_more_articles_on_post_enable == "show") {
        //adding event to scroll
        jQuery(window).scroll(function(){

            var cookie_more_box = td_read_site_cookie('td-cookie-more-articles');
            //alert(cookie_more_box);

            //setting distance from the top
            if(!isNaN(parseInt(tds_more_articles_on_post_pages_distance_from_top)) && isFinite(tds_more_articles_on_post_pages_distance_from_top) && parseInt(tds_more_articles_on_post_pages_distance_from_top) > 0){
                var set_distance = parseInt(tds_more_articles_on_post_pages_distance_from_top);
            } else {
                var set_distance = 400;
            }

            if (jQuery(this).scrollTop() > set_distance && cookie_more_box != 'hide-more-articles-box') {
                jQuery('.td-more-articles-box').addClass('td-front-end-display-block');
            } else {
                jQuery('.td-more-articles-box').removeClass('td-front-end-display-block');
            }
        });

        //adding event to hide the box
        jQuery('.td-close-more-articles-box').click(function(){

            //hiding the box
            jQuery('.td-more-articles-box').removeClass('td-front-end-display-block');
            jQuery('.td-more-articles-box').hide();

            //cookie life
            if(!isNaN(parseInt(tds_more_articles_on_post_time_to_wait)) && isFinite(tds_more_articles_on_post_time_to_wait)){
                //setting cookie
                td_create_cookie('td-cookie-more-articles', 'hide-more-articles-box', parseInt(tds_more_articles_on_post_time_to_wait));
            }



        });
    }


}); //end on load


//patern to check emails
var td_mod_pattern_email = /^[a-zA-Z0-9][a-zA-Z0-9_\.-]{0,}[a-zA-Z0-9]@[a-zA-Z0-9][a-zA-Z0-9_\.-]{0,}[a-z0-9][\.][a-z0-9]{2,4}$/;

/**
 * handle all request made from login tab
 */
function handle_login_for_modal_window() {
    var login_email = jQuery('#login_email').val();
    var login_pass = jQuery('#login_pass').val();

    if(login_email && login_pass){
        //empty error display div
        //td_modala_empty_err_div();

        modala_add_remove_class(['.td_display_err', 1, "td_display_msg_ok"]);
        jQuery('.td_display_err').show();
        td_modala_write_err_div(td_please_wait);

        //call ajax for log in
        td_modala_call_ajax('td_mod_login', login_email, '', login_pass);
    } else {
        jQuery('.td_display_err').show();
        td_modala_write_err_div(td_email_user_pass_incorrect);
    }
}

/**
 * handle all request made from register tab
 */
function handle_register_for_modal_window() {
    var register_email = jQuery('#register_email').val();
    var register_user = jQuery('#register_user').val();

    if(td_mod_pattern_email.test(register_email) && register_user){
        //empty error display div
        //td_modala_empty_err_div();

        modala_add_remove_class(['.td_display_err', 1, "td_display_msg_ok"]);
        jQuery('.td_display_err').show();
        td_modala_write_err_div(td_please_wait);

        //call ajax
        td_modala_call_ajax('td_mod_register', register_email, register_user, '');
    } else {
        jQuery('.td_display_err').show();
        td_modala_write_err_div(td_email_user_incorrect);
    }
}

/**
 * handle all request made from forgot password tab
 */
function handle_forgot_password_for_modal_window() {
    var forgot_email = jQuery('#forgot_email').val();

    if(td_mod_pattern_email.test(forgot_email)){
        //empty error display div
        //td_modala_empty_err_div();

        modala_add_remove_class(['.td_display_err', 1, "td_display_msg_ok"]);
        jQuery('.td_display_err').show();
        td_modala_write_err_div(td_please_wait);

        //call ajax
        td_modala_call_ajax('td_mod_remember_pass', forgot_email, '', '');
    } else {
        jQuery('.td_display_err').show();
        td_modala_write_err_div(td_email_incorrect);
    }
}

/**
 * swhich the div's acordingly to the user action (Log In, Register, Remember Password)
 *
 * ids_array : array of ids that have to be showed or hidden
 */
function show_hide_content_modala(ids_array) {
    var length = ids_array.length;

    for (var i = 0; i < length; i++) {
        element_id = ids_array[i][0];
        element_visibility = ids_array[i][1];

        if (element_visibility == 1) {
            jQuery(element_id).removeClass('td-dispaly-none').addClass('td-dispaly-block');
        } else {
            jQuery(element_id).removeClass('td-dispaly-block').addClass('td-dispaly-none');
        }
    }
}


/**
 * swhich the tab's acordingly to the user action (Log In, Register, Remember Password)
 *
 * ids_array : array of ids that have to be focus on or unfocus
 */
function modala_swich_tabs(ids_array) {
    var length = ids_array.length;

    for (var i = 0; i < length; i++) {
        element_id = ids_array[i][0];
        element_visibility = ids_array[i][1];

        if (element_visibility == 1) {
            jQuery(element_id).addClass('td_login_tab_focus');
        } else {
            jQuery(element_id).removeClass('td_login_tab_focus');
        }
    }
}


/**
 * adds or remove a class from an html object
 *
 * param : array with object identifier (id - # or class - .)
 * ex: ['.class_indetifier', 1, 'class_to_add'] or ['.class_indetifier', 0, 'class_to_remove']
 */
function modala_add_remove_class(param) {

    //add class
    if (param[1] == 1) {
        jQuery(param[0]).addClass(param[2]);

    //remove class
    } else {
        jQuery(param[0]).removeClass(param[2]);
    }
}


/**
 * empty the error div
 */
function td_modala_empty_err_div() {
    jQuery('.td_display_err').html('');
    jQuery('.td_display_err').hide();
}


/**
 * write text to error div
 */
function td_modala_write_err_div(message) {
    jQuery('.td_display_err').html(message);
}

/**
 * empty all fields in modal window
 */
function td_modala_empty_all_fields() {
    //login fields
    jQuery('#login_email').val('');
    jQuery('#login_pass').val('');

    //register fields
    jQuery('#register_email').val('');
    jQuery('#register_user').val('');

    //forgot pass
    jQuery('#forgot_email').val('');
}


/**
 * call to server from modal window
 *
 * @param $action : what action (log in, register, forgot email)
 * @param $email  : the email beening sent
 * @param $user   : the user name beening sent
 */
function td_modala_call_ajax(sent_action, sent_email, sent_user, sent_pass) {
    jQuery.ajax({
        type: 'POST',
        url: td_ajax_url,
        data: {
            action: sent_action,
            email: sent_email,
            user: sent_user,
            pass: sent_pass
        },
        success: function(data, textStatus, XMLHttpRequest){
            var td_data_object = jQuery.parseJSON(data); //get the data object

            //check the response from server
            switch(td_data_object[0]) {
                case 'login':
                    if(td_data_object[1] == 1) {
                        location.reload(true);
                    } else {
                        modala_add_remove_class(['.td_display_err', 0, 'td_display_msg_ok']);
                        jQuery('.td_display_err').show();
                        td_modala_write_err_div(td_data_object[2]);
                    }
                    break;

                case 'register':
                    if(td_data_object[1] == 1) {
                        modala_add_remove_class(['.td_display_err', 1, "td_display_msg_ok"]);
                        jQuery('.td_display_err').show();
                    } else {
                        modala_add_remove_class(['.td_display_err', 0, "td_display_msg_ok"]);
                        jQuery('.td_display_err').show();
                    }
                    td_modala_write_err_div(td_data_object[2]);
                    break;

                case 'remember_pass':
                    if(td_data_object[1] == 1) {
                        modala_add_remove_class(['.td_display_err', 1, "td_display_msg_ok"]);
                        jQuery('.td_display_err').show();
                    } else {
                        modala_add_remove_class(['.td_display_err', 0, "td_display_msg_ok"]);
                        jQuery('.td_display_err').show();
                    }
                    td_modala_write_err_div(td_data_object[2]);
                    break;

            }


        },
        error: function(MLHttpRequest, textStatus, errorThrown){
            //console.log(errorThrown);
        }
    });
}

function td_live_responsive(is_on_ready) {
    var td_window_width = jQuery(window).width();

    if (td_window_width < 768) {
        if (td_is_js_phone === false) {
            //console.log('mobile');

        }
        td_is_js_phone = true;
    } else {
        if (td_is_js_phone === true || is_on_ready === true) {
            //console.log('not mobile');
            //fix for small -> big top menu
            jQuery('#td-top-menu .sf-menu').supersubs({
                minWidth:    15, // minimum width of sub-menus in em units
                maxWidth:    40, // maximum width of sub-menus in em units
                extraWidth:  1 // extra width can ensure lines don't sometimes turn over
            });
        }
        td_is_js_phone = false;

    }
}


//click on a div -> go to a url
function td_fake_clicks() {
    jQuery('.td-fake-click').click(function(){
        window.location = jQuery(this).data("fake-click");
    });
}




var td_resize_timer_id;
jQuery(window).resize(function() {
    clearTimeout(td_resize_timer_id);
    td_resize_timer_id = setTimeout(td_done_resizing, 500);

});

function td_done_resizing(){
    td_resize_videos();
}



/*  ----------------------------------------------------------------------------
    Resize the videos
 */
function td_resize_videos() {
    //youtube in content
    jQuery(document).find('iframe[src*="youtube.com"]').each(function() {
        var td_video = jQuery(this);
        td_video.attr('width', '100%');
        var td_video_width = td_video.width();
        td_video.css('height', td_video_width * 0.6, 'important');
    });


    //vimeo in content
    jQuery(document).find('iframe[src*="vimeo.com"]').each(function() {
        var td_video = jQuery(this);
        td_video.attr('width', '100%');
        var td_video_width = td_video.width();
        td_video.css('height', td_video_width * 0.6, 'important');
    })


    //daily motion in content
    jQuery(document).find('iframe[src*="dailymotion.com"]').each(function() {
        var td_video = jQuery(this);
        td_video.attr('width', '100%');
        var td_video_width = td_video.width();
        td_video.css('height', td_video_width * 0.6, 'important');
    })
}




/*  ----------------------------------------------------------------------------
    Ajax search
 */
var td_aj_search_cur_sel = 0;
var td_aj_search_results = 0;
var td_aj_first_down_up = true;
function td_ajax_search() {




    jQuery('#td-header-search').keydown(function(event) {

        //console.log(event.keyCode);


        if ((event.which && event.which == 39) || (event.keyCode && event.keyCode == 39) || (event.which && event.which == 37) || (event.keyCode && event.keyCode == 37)) {
            //do nothing on left and right arrows
            td_aj_search_input_focus();
            return;
        }

        if ((event.which && event.which == 13) || (event.keyCode && event.keyCode == 13)) {

            //redirectSearch('q');
            var td_aj_cur_element = jQuery('.td-aj-cur-element');
            if (td_aj_cur_element.length > 0) {
                //alert('ra');
                var td_go_to_url = td_aj_cur_element.find('.entry-title a').attr('href');
                window.location = td_go_to_url;
            } else {
                jQuery(this).parent().parent().submit();
            }

            return false; //redirect for search on enter
        } else {

            if ((event.which && event.which == 40) || (event.keyCode && event.keyCode == 40)) {
                // down
                td_aj_search_move_prompt_down();
                return false; //disable the envent

            } else if((event.which && event.which == 38) || (event.keyCode && event.keyCode == 38)) {
                //up
                td_aj_search_move_prompt_up();
                return false; //disable the envent
            } else {

                //for backspace we have to check if the search query is empty and if so, clear the list
                if ((event.which && event.which == 8) || (event.keyCode && event.keyCode == 8)) {
                    //if we have just one character left, that means it will be deleted now and we also have to clear the search results list
                    var search_query = jQuery(this).val();
                    if (search_query.length == 1) {
                        jQuery('#td-aj-search').empty();
                    }

                }

                //various keys
                td_aj_search_input_focus();
                setTimeout("td_ajax_search_do_request()",100);
            }
            return true;
        }

    });



}

//moves the select up
function td_aj_search_move_prompt_up() {


    if (td_aj_first_down_up === true) {
        td_aj_first_down_up = false;
        if (td_aj_search_cur_sel === 0) {
            td_aj_search_cur_sel = td_aj_search_results - 1;
        } else {
            td_aj_search_cur_sel--;
        }
    } else {
        if (td_aj_search_cur_sel === 0) {
            td_aj_search_cur_sel = td_aj_search_results;
        } else {
            td_aj_search_cur_sel--;
        }
    }


    jQuery('.td_mod_aj_search').removeClass('td-aj-cur-element');



    if (td_aj_search_cur_sel  > td_aj_search_results -1) {
        //the input is selected
        jQuery('.td-search-form').fadeTo(100, 1);
    } else {
        td_aj_search_input_remove_focus();
        jQuery('.td_mod_aj_search').eq(td_aj_search_cur_sel).addClass('td-aj-cur-element');
    }



}

//moves the select prompt down
function td_aj_search_move_prompt_down() {

    if (td_aj_first_down_up === true) {
        td_aj_first_down_up = false;
    } else {
        if (td_aj_search_cur_sel === td_aj_search_results) {
            td_aj_search_cur_sel = 0;
        } else {
            td_aj_search_cur_sel++;
        }
    }


    jQuery('.td_mod_aj_search').removeClass('td-aj-cur-element');

    if (td_aj_search_cur_sel > td_aj_search_results - 1 ) {
        //the input is selected
        jQuery('.td-search-form').fadeTo(100, 1);
    } else {
        td_aj_search_input_remove_focus();
        jQuery('.td_mod_aj_search').eq(td_aj_search_cur_sel).addClass('td-aj-cur-element');
    }


}


// puts the focus on the input box
function td_aj_search_input_focus() {
    td_aj_search_cur_sel = 0;
    td_aj_first_down_up = true;
    jQuery('.td-search-form').fadeTo(100, 1);
    jQuery('.td_mod_aj_search').removeClass('td-aj-cur-element');
}

//removes the focus from the input box
function td_aj_search_input_remove_focus() {
    if (td_aj_search_results !== 0) {
        jQuery('.td-search-form').css('opacity', 0.5);
    }
}

//makes an ajax request
function td_ajax_search_do_request() {

    if (jQuery('#td-header-search').val() == '') {
        td_aj_search_input_focus();
        return;
    }


    var search_query = jQuery('#td-header-search').val();


    //do we have a cache hit
    if (td_local_cache.exist(search_query)) {
        td_ajax_search_process_request(td_local_cache.get(search_query));
        return; //cache HIT
    }


    //fk no cache hit - do the real request



    jQuery.ajax({
        type: 'POST',
        url: td_ajax_url,
        data: {
            action: 'td_ajax_search',
            td_string: search_query
        },
        success: function(data, textStatus, XMLHttpRequest){
            td_local_cache.set(search_query, data);
            td_ajax_search_process_request(data);
        },
        error: function(MLHttpRequest, textStatus, errorThrown){
            //console.log(errorThrown);
        }
    });
}

function td_ajax_search_process_request(data) {
    var current_query = jQuery('#td-header-search').val();

    //the search is empty - drop results
    if (current_query == '') {
        jQuery('#td-aj-search').empty();
        return;
    }

    var td_data_object = jQuery.parseJSON(data); //get the data object
    //drop the result - it's from a old query
    if (td_data_object.td_search_query !== current_query) {
        return;
    }

    //reset the current selection and total posts
    td_aj_search_cur_sel = 0;
    td_aj_search_results = td_data_object.td_total_in_list;
    td_aj_first_down_up = true;


    //update the query
    jQuery('#td-aj-search').html(td_data_object.td_data);

    /*
     td_data_object.td_data
     td_data_object.td_total_results
     td_data_object.td_total_in_list
     */
}






function td_mobile_menu2() {
    //return;
    //alert('mobile menu');
    //******************************************************************
    //MOBILE MENU new

    // helper functions

    var trim = function(str)
    {
        return str.trim ? str.trim() : str.replace(/^\s+|\s+$/g,'');
    };

    var hasClass = function(el, cn)
    {
        return (' ' + el.className + ' ').indexOf(' ' + cn + ' ') !== -1;
    };

    var addClass = function(el, cn)
    {
        if (!hasClass(el, cn)) {
            el.className = (el.className === '') ? cn : el.className + ' ' + cn;
        }
    };

    var removeClass = function(el, cn)
    {
        el.className = trim((' ' + el.className + ' ').replace(' ' + cn + ' ', ' '));
    };

    var hasParent = function(el, id)
    {
        if (el) {
            do {
                if (el.id === id) {
                    return true;
                }
                if (el.nodeType === 9) {
                    break;
                }
            }
            while((el = el.parentNode));
        }
        return false;
    };

    // normalize vendor prefixes

    var doc = document.documentElement;

    var transform_prop = window.Modernizr.prefixed('transform'),
        transition_prop = window.Modernizr.prefixed('transition'),
        transition_end = (function() {
            var props = {
                'WebkitTransition' : 'webkitTransitionEnd',
                'MozTransition'    : 'transitionend',
                'OTransition'      : 'oTransitionEnd otransitionend',
                'msTransition'     : 'MSTransitionEnd',
                'transition'       : 'transitionend'
            };
            return props.hasOwnProperty(transition_prop) ? props[transition_prop] : false;
        })();

    window.App = (function()
    {

        var _init = false;
        var app = { };

        var inner_nav_td = document.getElementById('inner-wrap');
        var nav_open = false;
        var nav_class = 'js-nav';

        //console.log(inner_nav_td);
        app.init = function()
        {
            if (_init) {
                return;
            }
            _init = true;

            var closeNavEnd = function(e)
            {
                if (e && e.target === inner_nav_td) {
                    document.removeEventListener(transition_end, closeNavEnd, false);
                }
                nav_open = false;
            };

            app.closeNav =function()
            {
                if (nav_open) {
                    // close navigation after transition or immediately
                    //console.log(inner_nav_td);

                    jQuery('#inner-wrap').css('minHeight', 'auto');
                    var duration = (transition_end && transition_prop) ? parseFloat(window.getComputedStyle(inner_nav_td, '')[transition_prop + 'Duration']) : 0;
                    if (duration > 0) {
                        document.addEventListener(transition_end, closeNavEnd, false);
                    } else {
                        closeNavEnd(null);
                    }
                }
                removeClass(doc, nav_class);
            };

            app.openNav = function()
            {
                if (nav_open) {
                    return;
                }


                //var td_cur_innerwrap_height = jQuery('#inner-wrap').height();

//                if (td_cur_innerwrap_height != td_cur_mobile_nav_height) {
//
//                }
//                alert(td_cur_mobile_nav_height);
                var td_cur_mobile_nav_height = jQuery('.td-menu-animate').height();
                jQuery('#inner-wrap').css('minHeight', td_cur_mobile_nav_height);
                addClass(doc, nav_class);


                /*
                jQuery(this).delay(1000).queue(function(){
                    if (td_is_phone_screen) {
                        jQuery("html, body").animate({ scrollTop: 0 }, {
                                duration: 1000,
                                easing:'easeInOutQuart',
                                complete: function(){
                                    td_is_scrolling_animation = false;
                                }
                            }
                        );
                    }

                    jQuery(this).dequeue();
                });
*/


                nav_open = true;
            };

            app.toggleNav = function(e)
            {

                if (nav_open && hasClass(doc, nav_class)) {
                    app.closeNav();
                } else {
                    app.openNav();
                }
                if (e) {
                    e.preventDefault();
                }
            };

            // open nav with main "nav" button
            //document.getElementById('nav-open-btn').addEventListener('click', app.toggleNav, false);

            jQuery('#td-top-mobile-toggle a, .td-mobile-close a').click(function(){
                app.toggleNav();
            });




            // close nav with main "close" button
            //document.getElementById('nav-close-btn').addEventListener('click', app.toggleNav, false);



            addClass(doc, 'js-ready');

        };

        return app;

    })();

    if (window.addEventListener) {
        window.addEventListener('DOMContentLoaded', window.App.init, false);
    }




    if (tds_mobile_swipe == 'swipe') {
        //jquery touch swipe
        jQuery("html").swipe( {
            swipeLeft:function(event, distance, duration, fingerCount) {
                if (td_is_slide_moving === true) {
                    return;
                }
                window.App.closeNav();
            },
            swipeRight:function(event, distance, duration, fingerCount) {
                if (td_is_slide_moving === true) {
                    return;
                }
                window.App.openNav();
            },

            //Default is 75px, set to 0 for demo so any distance triggers swipe
            threshold:130,
            allowPageScroll:'vertical',
            triggerOnTouchEnd:false,
            fallbackToMouseEvents:false,
            excludedElements:'.noSwipe'
        });
    }


}




/*  ----------------------------------------------------------------------------
    Slider callbacks
 */
function slideStartedMoving(args) {
    td_is_slide_moving = true; //used on touch screens + mobile menu 2
}

function slideContentComplete(args) {
    td_is_slide_moving = false;
    if(!args.slideChanged) return false;
    jQuery(args.currentSlideObject).parent().find('.slide-info-wrap').removeClass('slide-wrap-active');
    jQuery(args.currentSlideObject).children('.slide-info-wrap').addClass('slide-wrap-active');
}

function slideContentLoaded(args) {
    if(!args.slideChanged) return false;
   // console.log('loaded');
    jQuery(args.currentSlideObject).parent().find('.slide-info-wrap').removeClass('slide-wrap-active');
    jQuery(args.currentSlideObject).children('.slide-info-wrap').addClass('slide-wrap-active');
}


/*  ----------------------------------------------------------------------------
    blocks ajax support
 */

function td_ajax_load() {
    /*  ----------------------------------------------------------------------------
     AJAX pagination next prev
     */

    jQuery(".td-ajax-next-page").click(function(event){
        event.preventDefault();

        if(jQuery(this).hasClass('ajax-page-disabled')) {
            return;
        }

        current_block_obj = td_getBlockObjById(jQuery(this).data('td_block_id'));

        current_block_obj.td_current_page++;
        td_ajax_block_request(current_block_obj);
    });

    jQuery(".td_ajax-prev-page").click(function(event){
        event.preventDefault();

        if(jQuery(this).hasClass('ajax-page-disabled')) {
            return;
        }

        current_block_obj = td_getBlockObjById(jQuery(this).data('td_block_id'));

        current_block_obj.td_current_page--;
        td_ajax_block_request(current_block_obj);
    });


    /*  ----------------------------------------------------------------------------
     AJAX pagination load more
     */

    jQuery(".td_ajax_load_more").click(function(event){
        event.preventDefault();
        if(jQuery(this).hasClass('ajax-page-disabled')) {
            return;
        }

        current_block_obj = td_getBlockObjById(jQuery(this).data('td_block_id'));

        current_block_obj.td_current_page++;
        td_ajax_block_request(current_block_obj, true, true);
    });


    /*  ----------------------------------------------------------------------------
     AJAX pagination infinite load
     */
    jQuery('.td_ajax_infinite').waypoint(function(direction) {
        if (direction === 'down') {
            //console.log('loading');
            current_block_obj = td_getBlockObjById(jQuery(this).data('td_block_id'));

            current_block_obj.td_current_page++;
            td_ajax_block_request(current_block_obj, true, false);
        }

    }, { offset: '110%' });


    /*  ----------------------------------------------------------------------------
     AJAX sub cat filter
     */
    jQuery(".ajax-sub-cat").click(function(event){ //click on an ajax category filter
        event.preventDefault();


        //get the current block id
        var current_block_id = jQuery(this).data('td_block_id');

        //destroy any iossliders to avoid bugs
        jQuery('#' + current_block_id).find('.iosSlider').iosSlider('destroy');;

        //get current block
        current_block_obj = td_getBlockObjById(current_block_id);

        //change cur cat
        current_block_obj.td_cur_cat = jQuery(this).data('cat_id');

        current_block_obj.td_current_page = 1;

        //do request
        td_ajax_block_request(current_block_obj);
    });




    /*  ----------------------------------------------------------------------------
        AJAX MEGA MENU
     */



    var td_mega_menu_last_link = '';

    //it used to hook the mega menu categories
    function td_ajax_sub_cat_mega_run(event) {

        if (td_mega_menu_last_link != jQuery(this).attr('href')) {
            event.preventDefault();
            td_mega_menu_last_link = jQuery(this).attr('href');
        } else {
            td_mega_menu_last_link = '';
        }


        //get the current block id
        var current_block_id = jQuery(this).data('td_block_id');

        //get current block
        current_block_obj = td_getBlockObjById(current_block_id);


        //change cur cat
        current_block_obj.td_cur_cat = jQuery(this).data('cat_id');

        current_block_obj.td_current_page = 1;

        //do request - no append, no animation
        td_ajax_block_request(current_block_obj, false, true);
    }

    //on touch devices use click
    if (td_is_touch_device) {
        jQuery(".ajax-sub-cat-mega").click(td_ajax_sub_cat_mega_run);
    } else {
        jQuery(".ajax-sub-cat-mega").hover(td_ajax_sub_cat_mega_run, function (event) {} );
    }

}

function td_getBlockIndex(myID) {
    cnt = 0;
    tmpReturn = 0;
    jQuery.each(td_blocks, function(index, td_block) {
        //console.log("pid = " + portfolioItem.id + "  id = " + parseInt(myID));
        //alert(myID);
        if (td_block.id === myID) {
            tmpReturn = cnt;
            return false; //brake jquery each
        } else {
            cnt++;
        }
    });
    return tmpReturn;
}


function td_getBlockObjById(myID) {
    return td_blocks[td_getBlockIndex(myID)];
}







function td_ajax_block_request(current_block_obj, td_append, td_use_animation) {

    //append the content in container instead of replacing it
    td_append = (typeof td_append === "undefined") ? false : td_append;

    //do we use animation? default = true
    td_use_animation = (typeof td_use_animation === "undefined") ? true : td_use_animation;

    //search the cache
    var current_block_obj_signature = JSON.stringify(current_block_obj);
    if (td_local_cache.exist(current_block_obj_signature)) {
        //do the animation with no loader
        if(td_use_animation === true) {
            ajax_pagination_loading_start(current_block_obj, false);
        }
        td_ajax_block_process_response(td_local_cache.get(current_block_obj_signature));
        return 'cache_hit'; //cache HIT
    }


    //cache miss

    if(td_use_animation === true) {
        ajax_pagination_loading_start(current_block_obj, true);
    }


    jQuery.ajax({
        type: 'POST',
        url: td_ajax_url,
        cache:true,

        data: {
            action: 'td_ajax_block',
            td_atts: current_block_obj.atts,
            td_cur_cat:current_block_obj.td_cur_cat,
            td_block_id:current_block_obj.id,
            td_column_number:current_block_obj.td_column_number,
            td_current_page:current_block_obj.td_current_page,
            block_type:current_block_obj.block_type
        },
        success: function(data, textStatus, XMLHttpRequest){
            td_local_cache.set(current_block_obj_signature, data);
            td_ajax_block_process_response(data, td_append);
        },
        error: function(MLHttpRequest, textStatus, errorThrown){
            //console.log(errorThrown);
        }
    });
}


function td_ajax_block_process_response(data, td_append) {
    //jQuery(this).parent().parent().parent().find('.td_block_inner').html("");
    var td_data_object = jQuery.parseJSON(data); //get the data object

    /*
     td_data_object.td_block_id
     td_data_object.td_data
     td_data_object.td_cur_cat
     */

    //subcategories
    jQuery('.sub-cat-' + td_data_object.td_block_id).removeClass('cur-sub-cat');
    jQuery('#sub-cat-' + td_data_object.td_block_id + '-' + td_data_object.td_cur_cat).addClass('cur-sub-cat');

    //load the content (in place or append)
    if (td_append === true) {
        jQuery('#' + td_data_object.td_block_id).append(td_data_object.td_data); //show content
    } else {
        jQuery('#' + td_data_object.td_block_id).html(td_data_object.td_data); //show content
    }


    //hide or show prev
    if (td_data_object.td_hide_prev === true) {
        jQuery('#prev-page-' + td_data_object.td_block_id).addClass('ajax-page-disabled');
    } else {
        jQuery('#prev-page-' + td_data_object.td_block_id).removeClass('ajax-page-disabled');
    }

    //hide or show next
    if (td_data_object.td_hide_next === true) {
        jQuery('#next-page-' + td_data_object.td_block_id).addClass('ajax-page-disabled');
    } else {
        jQuery('#next-page-' + td_data_object.td_block_id).removeClass('ajax-page-disabled');
    }


    var  current_block_obj = td_getBlockObjById(td_data_object.td_block_id);
    if (current_block_obj.block_type === 'slide') {
        //make the first slide active (to have caption)
        jQuery('#' + td_data_object.td_block_id + ' .slide-wrap-active-first').addClass('slide-wrap-active');
    }



    //loading effects
    ajax_pagination_loading_end(current_block_obj);
}


function ajax_pagination_loading_start(current_block_obj, show_loader) {




    var el_cur_td_block_inner = jQuery('#' + current_block_obj.id);
    jQuery('.td-loader-gif').remove(); //remove any remaining loaders

    el_cur_td_block_inner.addClass('td_block_inner_overflow');

    //show the loader only if it's needed
    if (show_loader === true) {
        el_cur_td_block_inner.parent().append('<img class="td-loader-gif" src="' + td_get_template_directory_uri + '/images/AjaxLoader.gif" alt=""/>');
    }


    el_cur_td_block_inner.stop();
    el_cur_td_block_inner.fadeTo('500',0.1, 'easeInOutCubic');

    //auto height => fixed height
    var td_tmp_block_height = el_cur_td_block_inner.height();
    el_cur_td_block_inner.css('height', td_tmp_block_height);
}


function ajax_pagination_loading_end(current_block_obj) {

    jQuery(this).delay(100).queue(function(){
        jQuery('.td-loader-gif').remove();


        jQuery('#' + current_block_obj.id).stop();
        jQuery('#' + current_block_obj.id).fadeTo(700, 1, function(){
            jQuery('#' + current_block_obj.id).css('height', 'auto');
            jQuery('.td_block_inner_overflow').removeClass('td_block_inner_overflow');
        });

        jQuery(this).dequeue();
    });

    //refresh waypoints for infinit scroll
    jQuery.waypoints('refresh');
}


/*  ----------------------------------------------------------------------------
    Add retina support
 */

function td_retina() {
    if (window.devicePixelRatio > 1) {
        jQuery('.td-retina').each(function(i) {
            var lowres = jQuery(this).attr('src');
            var highres = lowres.replace(".png", "@2x.png");
            highres = highres.replace(".jpg", "@2x.jpg");
            jQuery(this).attr('src', highres);

        });


        //custom logo support
        jQuery('.td-retina-data').each(function(i) {
            jQuery(this).attr('src', jQuery(this).data('retina'));
            //fix logo aligment on retina devices
            jQuery(this).addClass('td-retina-version');
        });

    }
}

/*
jQuery('body').click(function(e){
    if(! jQuery(e.target).hasClass('custom-background')){
        alert('clicked on something that has not the class theDIV');
    }

});*/

//click only on BACKGROUND, for devices that don't have touch (ex: phone, tablets)
if(!td_is_touch_device && td_ad_background_click_link != '') {

    //var ev = ev || window.event;
    //var target = ev.target || ev.srcElement;
    jQuery('body').click(function(event) {

        //getting the target element that the user clicks - for W3C and MSIE
        var target = (event.target) ? event.target : event.srcElement;

        //only if the background has background image
        if(jQuery('body').hasClass('td-boxed-layout')) {
            if(target.id == 'inner-wrap' || target.className == 'td-header-menu-wrap' || target.className == 'td-header-bg' || target.className == 'td-menu-background affix-top') {

                //open the link ad page
                if(td_ad_background_click_target == '_blank') {
                    //open in a new window
                    window.open(td_ad_background_click_link)
                } else {
                    //open in the same window
                    location.href = td_ad_background_click_link;
                }
            }
        }

        //e.stopPropagation();
        //stopBubble(event);
    });
}


function stopBubble(e){
    if(e && e.stopPropagation) {
        e.stopPropagation();
    } else {
        window.event.cancelBubble=true;
    }
}



/**
 * reading cookies
 * @param name
 * @returns {*}
 */
function td_read_site_cookie(name) {
    var nameEQ = escape(name) + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return unescape(c.substring(nameEQ.length, c.length));
    }
    return null;
}


/**
 *
 * @param td_time_cookie_array
 *
 * @param[0]: name of the cookie
 * @param[1]: value of the cookie
 * @param[2]: expiration time
 */
function td_set_cookies_life(td_time_cookie_array) {
    var expiry = new Date();
    expiry.setTime(expiry.getTime() + td_time_cookie_array[2]);

    // Date()'s toGMTSting() method will format the date correctly for a cookie
    document.cookie = td_time_cookie_array[0] + "=" + td_time_cookie_array[1] + "; expires=" + expiry.toGMTString() + "; path=/";
}
