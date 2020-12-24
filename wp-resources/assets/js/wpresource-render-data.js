jQuery(function ($) {
    $("#blog_count").on('input', function () {
        var testingObj1 = {
            init: function () {
                testingObj1.callAjaxMethod();
            },
            callAjaxMethod:function(){
                var wrapper = $('#wpresource-tab-input-blogs');
                var start_count_fields = 0;
                var get_blogs_count = $('#blog_count').val();
                var count_dy_blogs = 0;
                var data = {
                    'action': 'wpresource_action_for_blogs',
                    'name': get_blogs_count,
                };
                
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        //console.log(response);
                        var inputs = $("#wpresource-tab-input-blogs").find($("select") );
                        //console.log(inputs.length);
                        if(get_blogs_count > start_count_fields && inputs.length == 0){
            
                            for(i=0; i < get_blogs_count; i++){
                                $(wrapper).append(response);
                            }    
                            
                        }
                        else if(get_blogs_count > start_count_fields && get_blogs_count > inputs.length){
                            get_blogs_count_new = get_blogs_count - inputs.length ;
                            for(i=0; i < get_blogs_count_new; i++){
                                $(wrapper).append(response);
                            }    
                        }
                        $('#wpresource-tab-input-blogs span').on('click',function(event){
                            $(this).parent().remove(); 
                            count_dy_blogs++;
                            if(get_blogs_count - count_dy_blogs == 0){
                                $('input#blog_count').val("");
                            }
                            else{
                                $('input#blog_count').val(get_blogs_count - count_dy_blogs);
                            }
                        });
                    }
                });
            }
        }
        testingObj1.init();    
    });
  
    $("#ebook_count").on('input', function () {
        var testingObj2 = {
            init: function () {
                testingObj2.callAjaxMethod();
            },
            callAjaxMethod:function(){
                var wrapper = $('#wpresource-tab-input-ebooks');
                var start_count_fields = 0;
                var get_blogs_count = $('#ebook_count').val();
                var count_dy_ebooks = 0;
                var data = {
                    'action': 'wpresource_action_for_ebooks',
                    'name': get_blogs_count,
                };
    
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        //console.log(response);
                        var inputs = $("#wpresource-tab-input-ebooks").find($("select") );
                        //console.log(inputs.length);
                        if(get_blogs_count > start_count_fields && inputs.length == 0){
            
                            for(i=0; i < get_blogs_count; i++){
                                $(wrapper).append(response);
                            }    
                            
                        }
                        else if(get_blogs_count > start_count_fields && get_blogs_count > inputs.length){
                            get_blogs_count_new = get_blogs_count - inputs.length ;
                            for(i=0; i < get_blogs_count_new; i++){
                                $(wrapper).append(response);
                            }    
                        }
                        $('#wpresource-tab-input-ebooks span').on('click',function(event){
                            $(this).parent().remove(); 
                            count_dy_ebooks++;
                            if(get_blogs_count - count_dy_ebooks == 0){
                                $('input#ebook_count').val("");
                            }
                            else{
                                $('input#ebook_count').val(get_blogs_count - count_dy_ebooks);
                            }
                        });
                    }
                });
            }
        }
        testingObj2.init();    
    });
    $("#casestudy_count").on('input', function () {
        var testingObj3 = {
            init: function () {
                testingObj3.callAjaxMethod();
            },
            callAjaxMethod:function(){
                var wrapper = $('#wpresource-tab-input-casestudies');
                var start_count_fields = 0;
                var get_case_count = $('#casestudy_count').val();
                var count_dy_casestudies = 0;

                var data = {
                    'action': 'wpresource_action_for_casestudies',
                    'name': get_case_count,
                };
    
                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: data,
                    success: function (response) {
                        //console.log(response);
                        var inputs = $("#wpresource-tab-input-casestudies").find($("select") );
                        //console.log(inputs.length);
                        if(get_case_count > start_count_fields && inputs.length == 0){
            
                            for(i=0; i < get_case_count; i++){
                                $(wrapper).append(response);
                            }    
                            
                        }
                        else if(get_case_count > start_count_fields && get_case_count > inputs.length){
                            get_blogs_count_new = get_case_count - inputs.length ;
                            for(i=0; i < get_blogs_count_new; i++){
                                $(wrapper).append(response);
                            }    
                        }
                        $('#wpresource-tab-input-casestudies span').on('click',function(event){
                            $(this).parent().remove(); 
                            count_dy_casestudies++;
                            if(get_case_count - count_dy_casestudies == 0){
                                $('input#casestudy_count').val("");
                            }
                            else{
                                $('input#casestudy_count').val(get_case_count - count_dy_casestudies);
                            }
                        });
                    }
                });
            }
        }
        testingObj3.init();       
    });

    var count_blogs = 0;
    var count_ebooks = 0;
    var count_casestudies = 0;
    get_blogs_tot_count = $('#blog_count').val();
    get_ebooks_tot_count = $('#ebook_count').val();
    get_case_tot_count = $('#casestudy_count').val();
    $('#wpresource-tab-input-blogs span').on('click',function(event){
        $(this).parent().remove(); 
        count_blogs++;
        if(get_blogs_tot_count - count_blogs == 0){
            $('input#blog_count').val("");
        }
        else{
            $('input#blog_count').val(get_blogs_tot_count - count_blogs);
        }
    });
    $('#wpresource-tab-input-ebooks span').on('click',function(event){
        $(this).parent().remove(); 
        count_ebooks++;
        if(get_ebooks_tot_count - count_ebooks == 0){
            $('input#ebook_count').val("");
        }
        else{
            $('input#ebook_count').val(get_ebooks_tot_count - count_ebooks);
        }
    });
    $('#wpresource-tab-input-casestudies span').on('click',function(event){
        $(this).parent().remove(); 
        count_casestudies++;
        console.log(get_case_tot_count);
        if(get_case_tot_count - count_casestudies == 0){
            $('input#casestudy_count').val("");
        }
        else{
            $('input#casestudy_count').val(get_case_tot_count - count_casestudies);
        }
    });
});