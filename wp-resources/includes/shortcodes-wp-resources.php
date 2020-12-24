<?php
add_shortcode( 'wpresources', 'wpresource_short_func' );

function wpresource_short_func( $atts ) {
	$a = shortcode_atts( array(
		'title' => '',
		'id' => '',
	), $atts );

    global $wpdb;
    $meta = get_post_custom( $atts['id'] );

    if(!empty($meta['wpresourcemetadata'])){
        $wpresource_unserialized_data = $meta['wpresourcemetadata'];
        foreach($wpresource_unserialized_data as $result) {
            $get_serialized_value = unserialize($result);
        }
    }

    $get_shortcode_blog = $get_serialized_value['wpresource_blogs'][0];
    $get_shortcode_ebook = $get_serialized_value['wpresource_ebooks'][0];
    $get_shortcode_casestudy = $get_serialized_value['wpresource_casestudies'][0];

    $wpresources_static_content = "Always stay on top of things with complete analytic tool and numerous KPIs";
    if(!empty($get_shortcode_ebook)){
        $content_post_ebook = get_post($get_shortcode_ebook);
        $content_ebook = $content_post_ebook->post_content;
        if(!empty($content_ebook)){
            $content_trimmed_ebook = wp_trim_words( $content_ebook, 15 );
        }    
    }

    if(!empty($get_shortcode_blog)){
        $content_post_blog = get_post($get_shortcode_blog);
        $content_blog = $content_post_blog->post_content;
        if(!empty($content_blog)){
            $content_trimmed_blog = wp_trim_words( $content_blog, 15 );
        }
    }

    if(!empty($get_shortcode_casestudy)){
        $content_post_cs = get_post($get_shortcode_casestudy);
        $content_cs = $content_post_cs->post_content;
        if(!empty($content_cs)){
            $content_trimmed_cs = wp_trim_words( $content_cs, 15 );
        }
    }

   ob_start(); ?>
   <div class="main-wpresource-container">
    <div class="wpresource-background">
        <div class="wpresource-library">
            <h3>Resource library</h3>
            <p>Learn how to get most out of unified communications</p>
        </div>
        
    </div>
       <!---content section start-->
       <div class="wpresource-blocks">
            <div class="container mt-4">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="content-box-section">
                            <img class="card-img-top" src="<?php echo plugins_url( 'lib/img/wpresource-block1.png', __DIR__ ); ?>" alt="">
                            <div class="card-body">
                            <h3 class="card-title"><span>Explore</span> E-Books <span id="wpres-arr"></span></h3>
                            <h5>Title: <b><?php echo substr(get_the_title($get_shortcode_ebook),0,15) ; ?></b></h5>
                            <p><?php echo !empty($content_trimmed_ebook) ? $content_trimmed_ebook : $wpresources_static_content;  ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="content-box-section blogs-block">
                            <img class="card-img-top" src="<?php echo plugins_url( 'lib/img/wpresource-block2.png', __DIR__ ); ?>" alt="">
                            <div class="card-body">
                            <h3 class="card-title"><span>Explore</span> Blogs <span id="wpres-arr"></span></h3>
                            <h5>Title: <b><?php echo substr(get_the_title($get_shortcode_blog),0,15) ; ?></b></h5>
                            <p><?php echo !empty($content_trimmed_blog) ? $content_trimmed_blog : $wpresources_static_content;  ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="content-box-section">
                            <img class="card-img-top" src="<?php echo plugins_url( 'lib/img/wpresource-block3.png', __DIR__ ); ?>" alt="">
                            <div class="card-body">
                            <h3 class="card-title"><span>Explore</span> Case Study <span id="wpres-arr"></span></h3>
                            <h5>Title: <b><?php echo substr(get_the_title($get_shortcode_casestudy),0,15) ; ?></b></h5>
                            <p><?php echo !empty($content_trimmed_cs) ? $content_trimmed_cs : $wpresources_static_content;  ?></p>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
        <!---content section end-->
    </div>
<?php
    $content = ob_get_clean();
    return  $content;
}
