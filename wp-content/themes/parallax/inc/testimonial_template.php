<?php
/* Testimonial */

// frontend display
function parallax_testimonial_render_display()
{
	global $post;
        // Set directory uri
        $directory_uri = get_template_directory_uri();
        $testimonials = array();
	if(is_page())
	{
		$parallax_testimonial_title = get_post_meta( $post->ID, 'ir_testimonial_title', true );
 		$testimonial_background = get_post_meta( $post->ID, 'testimonial_background', true );
		 // Get testimonial images
                $testimonials[0]['img'] = get_post_meta( $post->ID, 'cyberchimps_blog_testimonial_image_one', true );
                $testimonials[1]['img'] = get_post_meta( $post->ID, 'cyberchimps_blog_testimonial_image_two', true );
                $testimonials[2]['img'] = get_post_meta( $post->ID, 'cyberchimps_blog_testimonial_image_three', true );

                 // get testimonial clients
                $testimonials[0]['client'] = get_post_meta( $post->ID, 'cyberchimps_blog_client_one', true );
                $testimonials[1]['client'] = get_post_meta( $post->ID, 'cyberchimps_blog_client_two', true );
                $testimonials[2]['client'] = get_post_meta( $post->ID, 'cyberchimps_blog_client_three', true );

                // get testimonial  - about clients
                $testimonials[0]['client_abt'] = get_post_meta( $post->ID, 'cyberchimps_blog_client_abt_one', true );
                $testimonials[1]['client_abt'] = get_post_meta( $post->ID, 'cyberchimps_blog_client_abt_two', true );
                $testimonials[2]['client_abt'] = get_post_meta( $post->ID, 'cyberchimps_blog_client_abt_three', true );

                  // get testimonial  - about clients

                $testimonials[0]['text'] = get_post_meta( $post->ID, 'cyberchimps_testimonial_one_text', true );
                $testimonials[1]['text'] = get_post_meta( $post->ID, 'cyberchimps_testimonial_two_text', true );
                $testimonials[2]['text'] = get_post_meta( $post->ID, 'cyberchimps_testimonial_three_text', true );

	}
	else
	{
		$parallax_testimonial_title = cyberchimps_get_option('ir_testimonial_title');
		$testimonial_background = cyberchimps_get_option('testimonial_background');

                // Get testimonial images

		$testimonials[0]['img'] = cyberchimps_get_option( 'cyberchimps_blog_testimonial_image_one' );
                $testimonials[1]['img'] = cyberchimps_get_option( 'cyberchimps_blog_testimonial_image_two' );
                $testimonials[2]['img'] = cyberchimps_get_option( 'cyberchimps_blog_testimonial_image_three' );

                // get testimonial clients
                $testimonials[0]['client'] = cyberchimps_get_option( 'cyberchimps_blog_client_one' );
                $testimonials[1]['client'] = cyberchimps_get_option( 'cyberchimps_blog_client_two' );
                $testimonials[2]['client'] = cyberchimps_get_option( 'cyberchimps_blog_client_three' );

                // get testimonial  - about clients

                $testimonials[0]['client_abt'] = cyberchimps_get_option( 'cyberchimps_blog_client_abt_one' );
                $testimonials[1]['client_abt'] = cyberchimps_get_option( 'cyberchimps_blog_client_abt_two' );
                $testimonials[2]['client_abt'] = cyberchimps_get_option( 'cyberchimps_blog_client_abt_three' );

                // get testimonial description

                $testimonials[0]['text'] = cyberchimps_get_option( 'cyberchimps_testimonial_one_text' );
                $testimonials[1]['text'] = cyberchimps_get_option( 'cyberchimps_testimonial_two_text' );
                $testimonials[2]['text'] = cyberchimps_get_option( 'cyberchimps_testimonial_three_text' );

	}

	if(  !empty($parallax_testimonial_title)  ){

        if($testimonial_background)
        {
        ?>
	<style type="text/css" media="all">
	    	#testimonial_section{
	    		background-image: url("<?php echo $testimonial_background; ?>");
				margin: 0 0 10% 0;
				border-top: 5px solid rgba(0, 0, 0, 0.3);
				border-bottom: 5px solid rgba(0, 0, 0, 0.3);
			}
			@media(max-width:767px){
	 			#testimonial_section{
	 				   margin: 0 0 20% 0;
	 			}
	 	  	}
	</style>
        <?php
        }
        else
        {
    	?>
		<style>
        #testimonial_section{
				background-color: <?php echo '#999';?>;
				margin: 0 0 10% 0;
				border-top: 5px solid rgba(0, 0, 0, 0.3);
				border-bottom: 5px solid rgba(0, 0, 0, 0.3);
			}
	   @media(max-width:767px){
			#testimonial_section{
				   margin: 0 0 20% 0;
			}
	  	}
        </style>
          <?php
          }
        ?>

	<div id="parallax_testimonial_top">
		<?php if( !empty($parallax_testimonial_title) ) { ?>


				<?php if(!empty($parallax_testimonial_title)) { ?>
				<h2 class="parallax_main_title">
					<?php echo $parallax_testimonial_title; ?>
				</h2>
				<?php } ?>


		<?php } ?>
	</div>


      <section class="parallax_slider_text_img">
        <div id="slider2" class="flexslider">
          <ul class="slides">
			<?php	foreach( $testimonials as $testimonial) {
        					 ?>

				<li class="col-md-12">
                                    <span class="parallax_testimonial_text"><?php if(!empty($testimonial['text'])){echo $testimonial['text'];} ?></span>
					<?php if(!empty($testimonial['text']))
							{ ?>
							<hr class="after_testimonial_text"> </hr>
					<?php } ?>
					<div class="parallax_testimonial_author">
                                                <?php  if(!empty($testimonial['client'])){echo $testimonial['client'];} ?>
					</div>
					<div class="parallax_testimonial_abt_author">
                                                <?php if(!empty($testimonial['client_abt'])){echo $testimonial['client_abt'];} ?>
					</div>
				</li>
			<?php  } ?>


          </ul>
        </div>
	<?php $slide_counters = 0; ?>
        <div id="carousel2" class="flexslider">
          <ul class="slides parallax_carousel" >
			<?php	foreach( $testimonials as $testimonial ) {
                          if(!empty($testimonial['img'])){


					?>

 					<li class="col-md-4">
						<a id="carousel-selector-<?php echo $slide_counters; ?>" class="<?php echo ( $slide_counters == 0 ) ? "selected" : ""; ?>">
                            <img src="<?php echo $testimonial['img']; ?>" class="img-responsive">

                        </a>

					</li>
			<?php  $slide_counters++;
					}
                        }
    ?>


          </ul>
        </div>
      </section>

	<script type="text/javascript" charset="utf-8">
	(function($) {

	// store the slider in a local variable
	  var $window = $(window),
		  flexslider = { vars:{} };

	  // tiny helper function to add breakpoints
	  function getGridSize() {
		return (window.innerWidth < 480) ? 70 :
			   (window.innerWidth < 767) ? 90 :
		       (window.innerWidth < 1200) ? 100 : 130;
	  }

	$(window).load(function() {
		 $('#carousel2').flexslider({
			animation: "slide",
			controlNav: false,
			animationLoop: true,
			slideshow: false,
			slideshowSpeed: 7000,
			itemWidth: getGridSize(),
			itemMargin: 20,
			asNavFor: '#slider2'
		  });

		  $('#slider2').flexslider({
			animation: "slide",
			controlNav: false,
			directionNav: false,
			animationLoop: true,
			slideshow: false,
			slideshowSpeed: 7000,
			sync: "#carousel2"
		  });
		});
		// check grid size on resize event
	  $window.resize(function() {
		var gridSize = getGridSize();

		flexslider.vars.itemWidth = gridSize;
	  });
						})(jQuery);
			</script>


<?php
}
}
