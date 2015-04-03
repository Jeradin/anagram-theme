<?php


add_shortcode( 'gallery', 'anagram_photoswipe_shortcode' );
add_shortcode( 'photoswipe', 'anagram_photoswipe_shortcode' );

/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/

function anagram_photoswipe()  {


        // comment reply script for threaded comments
  //  if ( is_single() ) {

        	 wp_register_script( 'anagram-photoswipe', get_stylesheet_directory_uri() . '/js/photoswipe/photoswipe.js' );

        	 wp_register_script( 'anagram-photoswipe-default', get_stylesheet_directory_uri() . '/js/photoswipe/photoswipe-ui-default.min.js' );

		 	  wp_register_style( 'anagram-cssphotoswipe', get_stylesheet_directory_uri() . '/js/photoswipe/photoswipe.css', array(), '', 'all' );

		      wp_register_style( 'anagram-cssphotoskin', get_stylesheet_directory_uri() . '/js/photoswipe/default-skin/default-skin.css', array(), '', 'all' );

		      wp_register_script( 'anagram-masonry', get_stylesheet_directory_uri() . '/js/masonry.pkgd.min.js',  '', '', false );

		      wp_register_script( 'anagram-imagesloaded', get_stylesheet_directory_uri() . '/js/imagesloaded.pkgd.min.js',  '', '', false );


				wp_enqueue_style( 'anagram-cssphotoswipe' );
			    wp_enqueue_style( 'anagram-cssphotoskin' );
		   		wp_enqueue_script( 'anagram-photoswipe' );
		   		wp_enqueue_script( 'anagram-photoswipe-default' );
			    wp_enqueue_script( 'anagram-masonry' );
			    wp_enqueue_script( 'anagram-imagesloaded' );

}
add_action( 'wp_enqueue_scripts', 'anagram_photoswipe' ); // Register this fxn and allow Wordpress to call it automatcally in the header


function anagram_photoswipe_function() {
    echo ' <!-- Root element of PhotoSwipe. Must have class pswp. -->
			<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

			    <!-- Background of PhotoSwipe.
			         Its a separate element, as animating opacity is faster than rgba(). -->
			    <div class="pswp__bg"></div>

			    <!-- Slides wrapper with overflow:hidden. -->
			    <div class="pswp__scroll-wrap">

			        <!-- Container that holds slides.
			                PhotoSwipe keeps only 3 slides in DOM to save memory. -->
			        <div class="pswp__container">
			            <!-- dont modify these 3 pswp__item elements, data is added later on -->
			            <div class="pswp__item"></div>
			            <div class="pswp__item"></div>
			            <div class="pswp__item"></div>
			        </div>

			        <!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
			        <div class="pswp__ui pswp__ui--hidden">

			            <div class="pswp__top-bar">

			                <!--  Controls are self-explanatory. Order can be changed. -->

			                <div class="pswp__counter"></div>

			                <button class="pswp__button pswp__button--close" title="Close (Esc)"></button>

			                <button class="pswp__button pswp__button--share" title="Share"></button>

			                <button class="pswp__button pswp__button--fs" title="Toggle fullscreen"></button>

			                <button class="pswp__button pswp__button--zoom" title="Zoom in/out"></button>

			                <!-- Preloader demo http://codepen.io/dimsemenov/pen/yyBWoR -->
			                <!-- element will get class pswp__preloader--active when preloader is running -->
			                <div class="pswp__preloader">
			                    <div class="pswp__preloader__icn">
			                      <div class="pswp__preloader__cut">
			                        <div class="pswp__preloader__donut"></div>
			                      </div>
			                    </div>
			                </div>
			            </div>

			            <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
			                <div class="pswp__share-tooltip"></div>
			            </div>

			            <button class="pswp__button pswp__button--arrow--left" title="Previous (arrow left)">
			            </button>

			            <button class="pswp__button pswp__button--arrow--right" title="Next (arrow right)">
			            </button>

			            <div class="pswp__caption">
			                <div class="pswp__caption__center"></div>
			            </div>

			          </div>

			        </div>

			</div>
			';
}







function anagram_photoswipe_shortcode( $attr ) {



				add_action('wp_footer', 'anagram_photoswipe_function');

	global $post;
	global $photoswipe_count;

	$show_controls = false;

	$full_size = 'large';

	$thumbnail_width = 300;

	static $instance = 0;
	$instance++;

	if ( ! empty( $attr['ids'] ) ) {
		// 'ids' is explicitly ordered, unless you specify otherwise.
		if ( empty( $attr['orderby'] ) ) {
			$attr['orderby'] = 'post__in';
		}
		$attr['include'] = $attr['ids'];
	}

	$args = shortcode_atts(array(
		'id' 				=> intval($post->ID),
		'columns'    => 3,
		'size'       => 'medium',
		'order'      => 'DESC',
		'orderby'    => 'menu_order ID',
		'include'    => '',
		'exclude'    => ''
	), $attr);

	$photoswipe_count += 1;
	$post_id = intval($post->ID) . '_' . $photoswipe_count;


	$output_buffer='';

	    if ( !empty($args['include']) ) {

			//"ids" == "inc"

			$include = preg_replace( '/[^0-9,]+/', '', $args['include'] );
			$_attachments = get_posts( array('include' => $args['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $args['order'], 'orderby' => $args['orderby']) );

			$attachments = array();
			foreach ( $_attachments as $key => $val ) {
				$attachments[$val->ID] = $_attachments[$key];
			}

		} elseif ( !empty($args['exclude']) ) {
			$exclude = preg_replace( '/[^0-9,]+/', '', $args['exclude'] );
			$attachments = get_children( array('post_parent' => $args['id'], 'exclude' => $args['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $args['order'], 'orderby' => $args['orderby']) );
		} else {

			$attachments = get_children( array('post_parent' => $args['id'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $args['order'], 'orderby' => $args['orderby']) );

		}

		$columns = intval($args['columns']);
        $itemwidth = $columns > 0 ? floor(100/$columns) : 100; //gets precentage

        $imgwidth = intval(1140/$args['columns']);


		//if( $photoswipe_count < 2){

			$output_buffer .= "

			<style type='text/css'>

				/* PhotoSwipe Plugin */
				.photoswipe_gallery {
					margin: auto;
					padding-bottom:40px;

					-webkit-transition: all 0.4s ease;
					-moz-transition: all 0.4s ease;
					-o-transition: all 0.4s ease;
					transition: all 0.4s ease;


					opacity:0;
				}

				.photoswipe_gallery.photoswipe_showme{
					opacity:1;
				}

				.photoswipe_gallery figure {
					margin: 0px;
					padding:5px;
					width: ".$imgwidth."px;
					text-align:center;
				}
				.photoswipe_gallery img {
					margin:auto;
				}
				.photoswipe_gallery figure figcaption{
					font-size:13px;
				}

				.msnry{
					margin:auto;
				}
			</style>";

		//}


		$size_class = sanitize_html_class( $args['size'] );
		$output_buffer .=' <div style="clear:both"></div>

		<div id="photoswipe_gallery_'.$post_id.'" class="photoswipe_gallery gallery-columns-'.$columns.' gallery-size-'.$size_class.'" itemscope itemtype="http://schema.org/ImageGallery" >';


		if ( !empty($attachments) ) {
			foreach ( $attachments as $aid => $attachment ) {

				$thumb = wp_get_attachment_image_src( $aid ,  $args['size'] );

				$thumb = anagram_resize_image(array('width' => $imgwidth ,'url' => true,'image_id' => $aid ));

				$full = wp_get_attachment_image_src( $aid , $full_size);

				$_post = get_post($aid);

				$image_title = esc_attr($_post->post_title);
				$image_alttext = get_post_meta($aid, '_wp_attachment_image_alt', true);
				$image_caption = $_post->post_excerpt;
				$image_description = $_post->post_content;

				$output_buffer .='
				<figure class="msnry_item  " itemscope itemtype="http://schema.org/ImageObject">
					<a href="'. $full[0] .'" itemprop="contentUrl" data-size="'.$full[1].'x'.$full[2].'">
				        <img src='. $thumb[0] .' itemprop="thumbnail" alt="'.$image_description.'"  />
				    </a>
				    <figcaption class="photoswipe-gallery-caption" >'. $image_caption .'</figcaption>
			    </figure>
				';

			}
		}



		$output_buffer .="</div>

		<div style='clear:both'></div>

		<script type='text/javascript'>

			var container_".$post_id." = document.querySelector('#photoswipe_gallery_".$post_id."');
			var msnry;

			// initialize Masonry after all images have loaded
			imagesLoaded( container_".$post_id.", function() {

				// initialize Masonry after all images have loaded
				new Masonry( container_".$post_id.", {
				  // options...
				  itemSelector: '.msnry_item',


				  isFitWidth: true
				});

				(container_".$post_id.").classList.add('photoswipe_showme');
			});

			// PhotoSwipe
			var initPhotoSwipeFromDOM = function(gallerySelector) {

		    // parse slide data (url, title, size ...) from DOM elements
		    // (children of gallerySelector)
		    var parseThumbnailElements = function(el) {
		        var thumbElements = el.childNodes,
		            numNodes = thumbElements.length,
		            items = [],
		            figureEl,
		            linkEl,
		            size,
		            item;

		        for(var i = 0; i < numNodes; i++) {

		            figureEl = thumbElements[i]; // <figure> element

		            // include only element nodes
		            if(figureEl.nodeType !== 1) {
		                continue;
		            }

		            linkEl = figureEl.children[0]; // <a> element

		            size = linkEl.getAttribute('data-size').split('x');

		            // create slide object
		            item = {
		                src: linkEl.getAttribute('href'),
		                w: parseInt(size[0], 10),
		                h: parseInt(size[1], 10)
		            };



		            if(figureEl.children.length > 1) {
		                // <figcaption> content
		                item.title = figureEl.children[1].innerHTML;
		            }

		            if(linkEl.children.length > 0) {
		                // <img> thumbnail element, retrieving thumbnail url
		                item.msrc = linkEl.children[0].getAttribute('src');
		            }

		            item.el = figureEl; // save link to element for getThumbBoundsFn
		            items.push(item);
		        }

		        return items;
		    };

		    // find nearest parent element
		    var closest = function closest(el, fn) {
		        return el && ( fn(el) ? el : closest(el.parentNode, fn) );
		    };

		    // triggers when user clicks on thumbnail
		    var onThumbnailsClick = function(e) {
		        e = e || window.event;
		        e.preventDefault ? e.preventDefault() : e.returnValue = false;

		        var eTarget = e.target || e.srcElement;

		        // find root element of slide
		        var clickedListItem = closest(eTarget, function(el) {
		            return el.tagName === 'FIGURE';
		        });

		        if(!clickedListItem) {
		            return;
		        }

		        // find index of clicked item by looping through all child nodes
		        // alternatively, you may define index via data- attribute
		        var clickedGallery = clickedListItem.parentNode,
		            childNodes = clickedListItem.parentNode.childNodes,
		            numChildNodes = childNodes.length,
		            nodeIndex = 0,
		            index;

		        for (var i = 0; i < numChildNodes; i++) {
		            if(childNodes[i].nodeType !== 1) {
		                continue;
		            }

		            if(childNodes[i] === clickedListItem) {
		                index = nodeIndex;
		                break;
		            }
		            nodeIndex++;
		        }



		        if(index >= 0) {
		            // open PhotoSwipe if valid index found
		            openPhotoSwipe( index, clickedGallery );
		        }
		        return false;
		    };

		    // parse picture index and gallery index from URL (#&pid=1&gid=2)
		    var photoswipeParseHash = function() {
		        var hash = window.location.hash.substring(1),
		        params = {};

		        if(hash.length < 5) {
		            return params;
		        }

		        var vars = hash.split('&');
		        for (var i = 0; i < vars.length; i++) {
		            if(!vars[i]) {
		                continue;
		            }
		            var pair = vars[i].split('=');
		            if(pair.length < 2) {
		                continue;
		            }
		            params[pair[0]] = pair[1];
		        }

		        if(params.gid) {
		            params.gid = parseInt(params.gid, 10);
		        }

		        if(!params.hasOwnProperty('pid')) {
		            return params;
		        }
		        params.pid = parseInt(params.pid, 10);
		        return params;
		    };

		    var openPhotoSwipe = function(index, galleryElement, disableAnimation) {
		        var pswpElement = document.querySelectorAll('.pswp')[0],
		            gallery,
		            options,
		            items;

		        items = parseThumbnailElements(galleryElement);

		        // define options (if needed)
		        options = {
		            index: index,
		            //closeEl:true,
					//captionEl: true,
					fullscreenEl: false,
					//zoomEl: true,
					shareEl: false,
					//counterEl: true,
					//arrowEl: true,
					//preloaderEl: true,

		            // define gallery index (for URL)
		            galleryUID: galleryElement.getAttribute('data-pswp-uid'),

		            getThumbBoundsFn: function(index) {
		                // See Options -> getThumbBoundsFn section of documentation for more info
		                var thumbnail = items[index].el.getElementsByTagName('img')[0], // find thumbnail
		                    pageYScroll = window.pageYOffset || document.documentElement.scrollTop,
		                    rect = thumbnail.getBoundingClientRect();

		                return {x:rect.left, y:rect.top + pageYScroll, w:rect.width};
		            }

		        };

		        if(disableAnimation) {
		            options.showAnimationDuration = 0;
		        }

		        // Pass data to PhotoSwipe and initialize it
		        gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options);
		        gallery.init();
		    };

		    // loop through all gallery elements and bind events
		    var galleryElements = document.querySelectorAll( gallerySelector );

		    for(var i = 0, l = galleryElements.length; i < l; i++) {
		        galleryElements[i].setAttribute('data-pswp-uid', i+1);
		        galleryElements[i].onclick = onThumbnailsClick;
		    }

		    // Parse URL and open gallery if it contains #&pid=3&gid=1
		    var hashData = photoswipeParseHash();
		    if(hashData.pid > 0 && hashData.gid > 0) {
		        openPhotoSwipe( hashData.pid - 1 ,  galleryElements[ hashData.gid - 1 ], true );
		    }
		};

		// execute above function
		initPhotoSwipeFromDOM('.photoswipe_gallery');

	</script>

	";



		return $output_buffer;
}