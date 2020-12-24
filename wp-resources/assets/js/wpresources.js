jQuery(document).ready(function($) {

    $('.wpresource-tab-group-left li:first-child').addClass('activewpresource');
    $(".wpresource-tab-group-left li").on('click', function(e){
        e.preventDefault();
        var get_tab_pos = $(this).index();
        $(this).addClass('wpresourcetab-selected').siblings()
        .removeClass('wpresourcetab-selected');
        if($( this ).hasClass( "activewpresource" )){
            $(".wpresource-tab-list li:first-child a").css("background-color", "#fff");
        }
        else{
            $(".wpresource-tab-list li:first-child a").css("background-color", "#DDDDDE");
        }
        get_id = $(this).attr("id");
        modified_data = get_id.substring(3);
        get_input_source =  "wpresource-tab-input-" + modified_data;
        //console.log(get_input_source);
        new_get_input_source = "."+get_input_source;
        $(new_get_input_source).addClass('wpresource-selected-input').siblings()
        .removeClass('wpresource-selected-input');
        if(get_input_source === "wpresource-tab-input-blogs"){
            $(".wpresource-tab-input-blogs").css("display", "grid");
        }
        else{
            $(".wpresource-tab-input-blogs").css("display", "none");
        }

    });
});