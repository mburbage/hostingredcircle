<?php 


// Button
add_shortcode('otbutton','otbutton_func');
function otbutton_func($atts, $content = null){
	extract(shortcode_atts(array(
		'btn'		=>	'',
		'style'		=>	'btn-default',
	), $atts));
		$url 	= vc_build_link( $btn );
	ob_start(); 
?>
	
    <?php if ( strlen( $btn ) > 0 && strlen( $url['url'] ) > 0 ) {
		echo '<a class="ot-btn'. esc_attr(' '.$style) . '" href="' . esc_attr( $url['url'] ) . '" target="' . ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) . '">' . htmlspecialchars_decode( $url['title'] ) .'</a>';
	} ?>
  	
<?php
    return ob_get_clean();
}

// Features box
add_shortcode('servicesbox', 'servicesbox_func');
function servicesbox_func($atts, $content = null){
	extract(shortcode_atts(array(
		'icon'		=>	'',
		'img'		=>	'',
		'title'		=>	'',
		'style'		=>	'box1',
	), $atts));
	$meta    = wp_prepare_attachment_for_js($img);
	$alt     = $meta['alt'];
	$img 	 = wp_get_attachment_image_src($img,'full');
	$img 	 = $img[0];
	ob_start(); ?>

    <div class="icon-box <?php echo esc_attr($style); ?>">
    
		<h5><?php echo htmlspecialchars_decode($title); ?></h5>
		<div class="icon-img">
			<?php if($img) { ?>
			<img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($alt); ?>">
			<?php }else{ ?>
			<i class="<?php echo esc_attr($icon); ?>"></i>
			<?php } ?>
		</div>
		
		<div class="icon-box-content">
			<?php echo htmlspecialchars_decode($content); ?>
		</div>
		
	</div>

<?php
    return ob_get_clean();
}


// Icon box
add_shortcode('iconbox', 'iconbox_func');
function iconbox_func($atts, $content = null){
	extract(shortcode_atts(array(
		'icon'		=>	'',
		'img'		=>	'',
		'title'		=>	'',
		'btn'		=>	'',
		'style'		=>	'icon1',
	), $atts));
	$meta    = wp_prepare_attachment_for_js($img);
	$alt     = $meta['alt'];
	$img 	 = wp_get_attachment_image_src($img,'full');
	$img 	 = $img[0];
	$url 	= vc_build_link( $btn );
	ob_start(); ?>

	<?php if( $style == 'icon1' ) { ?>
    <div class="feature-box">
    	<div class="fea-img">
			<?php if($img) { ?>
			<img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($alt); ?>">
			<?php }else{ ?>
			<i class="<?php echo esc_attr($icon); ?>"></i>
			<?php } ?>
		</div>
		<div class="fea-box-content">
			<h5><?php echo htmlspecialchars_decode($title); ?></h5>
			<?php echo htmlspecialchars_decode($content); ?>
		</div>		
	</div>
	<?php }elseif( $style == 'icon2' ) { ?>
	<div class="feature-box icon2">
    	<div class="fea-top">
    		<div class="icon-top">
				<?php if($img) { ?>
				<img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($alt); ?>">
				<?php }else{ ?>
				<i class="<?php echo esc_attr($icon); ?>"></i>
				<?php } ?>
			</div>
			<h4><?php echo htmlspecialchars_decode($title); ?></h4>			
		</div>
		<div class="fea-content">
			<p><?php echo htmlspecialchars_decode($content); ?></p>
			<?php if ( strlen( $btn ) > 0 && strlen( $url['url'] ) > 0 ) {
				echo '<a class="morelink" href="' . esc_attr( $url['url'] ) . '" target="' . ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) . '">' . htmlspecialchars_decode( $url['title'] ) .'</a>';
			} ?>
		</div>		
	</div>
	<?php }elseif( $style == 'icon3' ) { ?>
	<div class="feature-box icon3">
    	<div class="fea-img3">
			<?php if($img) { ?>
			<img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($alt); ?>">
			<?php }else{ ?>
			<i class="<?php echo esc_attr($icon); ?>"></i>
			<?php } ?>
		</div>
		<div class="fea-box-3">
			<h5><?php echo htmlspecialchars_decode($title); ?></h5>
			<?php echo htmlspecialchars_decode($content); ?>
		</div>		
	</div>
	<?php } ?>

<?php
    return ob_get_clean();
}


// Form search domain
add_shortcode('hosted_search_domain','hosted_search_domain_func');
function hosted_search_domain_func($atts, $content = null){
    extract( shortcode_atts( array(
      'holder'   	=> '',   
      'actionlink'  => '', 
   ), $atts ) );

    ob_start(); ?>

    <div class="domain-search">		
		<form method="post" action="<?php echo esc_url($actionlink); ?>">
          	<div class="domain-search-inner">
            	<input type="text" name="domain" placeholder="<?php echo esc_attr($holder); ?>">
          		<button type="submit" class="btn-domain"><i class="fa fa-search"></i></button>
          	</div>
        </form>
	</div>

<?php
    return ob_get_clean();
}

// Price domain name
add_shortcode('prdomain','prdomain_func');
function prdomain_func($atts, $content = null){
    extract( shortcode_atts( array(
      'domain'  => '',       
      'width'   => '',       
   ), $atts ) );
    $doms = (array) vc_param_group_parse_atts( $domain );
    ob_start(); ?>

    <?php foreach ( $doms as $dom ) { ?>
	<div class="hosted-domain-price" style="<?php if($width) echo 'width: '.esc_attr($width).'; '; ?>">
		<div class="inner">
		    <h2><?php echo esc_html($dom['title']); ?></h2>
		    <span><?php echo esc_html($dom['price']); ?></span>
	    </div>
	</div>
	<?php } ?>

<?php
    return ob_get_clean();
}

// Call To Action
add_shortcode('callaction','callaction_func');
function callaction_func($atts, $content = null){
    extract( shortcode_atts( array(
      'title'  => '',       
      'btn'    => '',       
   ), $atts ) );
	$url 	= vc_build_link( $btn );
    ob_start(); ?>

    <div class="callaction">
    	<h4><?php echo htmlspecialchars_decode($title); ?></h4>
    	<?php if ( strlen( $btn ) > 0 && strlen( $url['url'] ) > 0 ) {
			echo '<a class="ot-btn btn-color" href="' . esc_attr( $url['url'] ) . '" target="' . ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) . '">' . htmlspecialchars_decode( $url['title'] ) .'</a>';
		} ?>
    </div>

<?php
    return ob_get_clean();
}

// Member Team
add_shortcode('member','member_func');
function member_func($atts, $content = null){
	extract(shortcode_atts(array(
		'photo'		=>	'',
		'name'		=>	'',
		'job'		=>	'',
		'social'	=>	'',
	), $atts));
		$meta    = wp_prepare_attachment_for_js($photo);
		$alt     = $meta['alt'];
		$img 	 = wp_get_attachment_image_src($photo,'full');
		$img 	 = $img[0];
		$socials = (array) vc_param_group_parse_atts( $social );
	ob_start(); 
?>

	<div class="team-member">
		<div class="team-img">
			<img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($alt); ?>" />
		</div>
		<div class="team-info">
			<h4><?php echo htmlspecialchars_decode($name); ?></h4>
			<?php if($job) { ?><span class="id-color"><?php echo htmlspecialchars_decode($job); ?></span><?php } ?>
			<?php if($content) { ?>
			<div class="details">
				<?php echo htmlspecialchars_decode($content); ?>
			</div>
			<?php }if($socials) { ?>
			<div class="team-social">
				<ul class="none-style">
					<?php foreach ( $socials as $soc ) : if($soc) : ?>
						<li>
							<a class="id-color" href="<?php echo esc_url($soc['link']); ?>"><i class="<?php echo esc_attr($soc['icon']); ?>"></i></a>
						</li>
					<?php endif; endforeach; ?>
				</ul>
			</div>
			<?php } ?>
		</div>
	</div>

<?php
    return ob_get_clean();
}

// Testimonial Item
add_shortcode('testitem','testitem_func');
function testitem_func($atts, $content = null){
	extract(shortcode_atts(array(
		'name'		=>	'',
		'job'		=>	'',
		'photo'		=>	'',
		'star'		=>	'',
	), $atts));
	$meta    = wp_prepare_attachment_for_js($photo);
	$alt     = $meta['alt'];
	$img 	 = wp_get_attachment_image_src($photo,'full');
	$img 	 = $img[0];
	ob_start(); 
?>

	<div class="single-testi">
		<div class="testi-info">
			<img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr($alt); ?>">
			<div class="info-right">
				<h5 class="white"><?php echo htmlspecialchars_decode($name); ?></h5>
				<h5 class="id-color"><?php echo htmlspecialchars_decode($job); ?></h5>
				<?php if($star) { ?>
				<span class="id-color">
					<?php for ($i=0; $i < $star ; $i++) { 
						echo htmlspecialchars_decode("<i class='fa fa-star'></i>");
					} ?>
				</span>
				<?php } ?>
			</div>
		</div>
		<div class="testi-content3">
			<?php echo htmlspecialchars_decode($content); ?>
		</div>
    </div>

<?php
    return ob_get_clean();
}

// Testimonial Silder
add_shortcode('testslide','testslide_func');
function testslide_func($atts, $content = null){
	extract(shortcode_atts(array(
		'testi'		=>	'',
		'dark'		=>	'',
		'style'		=>	's1',
	), $atts));
	$test = (array) vc_param_group_parse_atts( $testi );
	ob_start(); 
?>
	
	<?php if($style == 's1') { ?>
	<div class="testimonial-slider <?php if($dark) echo 'dark-text';?>">
		<?php foreach ( $test as $tes ) { ?>
		<div class="slider-item">
			<img src="<?php echo get_template_directory_uri()."/images/testi.png" ?>" alt="testimonial" />
			<p><?php echo htmlspecialchars_decode($tes['text']); ?></p>
			<span class="id-color"><?php echo esc_html($tes['name']); ?></span>
		</div>
        <?php } ?>
    </div>
    <?php }else{ ?>
    <div class="testimonial-s2 <?php if($dark) echo 'dark-text';?>">
		<?php foreach ( $test as $tes ) { ?>
		<div class="s2-item">
			<h4><?php echo htmlspecialchars_decode($tes['name']); ?></h4>
			<span class="id-color"><?php echo esc_html($tes['job']); ?></span>
			<p><?php echo htmlspecialchars_decode($tes['text']); ?></p>			
		</div>
        <?php } ?>
    </div>
    <?php } ?>

<?php
    return ob_get_clean();
}


// Testimonial Silder 2
add_shortcode('testslide2','testslide2_func');
function testslide2_func($atts, $content = null){
	extract(shortcode_atts(array(
		'testi'		=>	'',
	), $atts));
	$test = (array) vc_param_group_parse_atts( $testi );
	ob_start(); 
?>

	<div class="testimonial2">
		<?php foreach ( $test as $tes ) { ?>
		<?php $img = wp_get_attachment_image_src($tes['photo'],'full'); $meta = wp_prepare_attachment_for_js($test['photo']); $alt = $meta['alt']; $img = $img[0]; ?>
		<div class="testi-item">
			<img src="<?php echo esc_url($img) ?>" alt="testimonial" />
			<div class="testi-content">
				<p><?php echo htmlspecialchars_decode($tes['text']); ?></p>
				<span class="name"><?php echo esc_html($tes['name']); ?></span>
				<span class="id-color"><?php echo esc_html($tes['job']); ?></span>
			</div>
		</div>
        <?php } ?>
    </div>

<?php
    return ob_get_clean();
}

// Pricing Table
add_shortcode('table', 'table_func');
function table_func($atts, $content = null){
	extract(shortcode_atts(array(
		'cur'		=>	'',
		'title'		=>	'',
		'feature'	=>	'',
		'feat'		=>	'',
		'linkbox'	=>	'',
		'price'		=>	'',
		'per'		=>	'',
		'vat'		=>	'',
		'width'		=>	'',
		'style'		=>	'style1',
	), $atts)); 
		$url 	= vc_build_link( $linkbox );
	ob_start(); ?>

	<?php if($style == 'style1') { ?>
	<div class="pricing <?php if($feature) echo 'active'; ?>">
								
		<!--=== start pricing-title ===-->
		<h3 class="pricing-title id-color"><?php echo htmlspecialchars_decode($title); ?></h3>
		<!--=== end pricing-title ===-->
		
		<!--=== start pricing-price ===-->
		<div class="pricing-price">
			<p class="price"><?php echo htmlspecialchars_decode($price); ?></p>
			<span class="per"><?php echo htmlspecialchars_decode($per); ?></span>
		</div>
		<!--=== end pricing-price ===-->
		
		<!--=== start pricing-features ===-->
		<div class="pricing-features">
			<?php echo htmlspecialchars_decode($content); ?>
		</div>
		<!--=== end pricing-features ===-->
		
		<!--=== start pricing-btn ===-->
		<div class="price-btn">
			<?php if ( strlen( $linkbox ) > 0 && strlen( $url['url'] ) > 0 ) {
				echo '<a class="ot-btn btn-dark" href="' . esc_attr( $url['url'] ) . '" target="' . ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) . '">' . esc_attr( $url['title'] ).'</a>';
			} ?>
		</div>
		<!--=== ejd pricing-btn ===-->
		
	</div>
	<?php }elseif($style == 'style2') { ?>
	<div class="pricing2" style="<?php if($width) { echo 'width:'.$width.';' ; } ?>">
		
		<?php if($feature) { ?><span class="feat id-color"><?php echo esc_html($feat); ?></span><?php } ?>
		<!--=== start pricing-title ===-->
		<h4 class="pricing-title id-color"><?php echo htmlspecialchars_decode($title); ?></h4>
		<!--=== end pricing-title ===-->
		
		<!--=== start pricing-features ===-->
		<div class="pricing-features">
			<?php echo htmlspecialchars_decode($content); ?>
		</div>
		<!--=== end pricing-features ===-->

		<!--=== start pricing-price ===-->
		<div class="pricing-price">
			<?php echo htmlspecialchars_decode($price); ?>
		</div>
		<!--=== end pricing-price ===-->
		
		<!--=== start pricing-btn ===-->
		<div class="price-btn">
			<?php if ( strlen( $linkbox ) > 0 && strlen( $url['url'] ) > 0 ) {
				echo '<a class="ot-btn btn-color" href="' . esc_attr( $url['url'] ) . '" target="' . ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) . '">' . esc_attr( $url['title'] ).'</a>';
			} ?>
		</div>
		<!--=== ejd pricing-btn ===-->
		
	</div>
	<?php }elseif($style == 'style3') { ?>
	<div class="pricing3">
		
		<!--=== start pricing-title ===-->
		<h4 class="pricing-title"><?php echo htmlspecialchars_decode($title); ?></h4>
		<!--=== end pricing-title ===-->

		<!--=== start pricing-price ===-->
		<div class="pricing-price id-color">
			<?php echo htmlspecialchars_decode($price); ?><span><?php echo htmlspecialchars_decode($per); ?></span>
		</div>
		<div class="vat"><?php echo htmlspecialchars_decode($vat); ?></div>
		<!--=== end pricing-price ===-->
		
		<!--=== start pricing-features ===-->
		<div class="pricing-features">
			<?php echo htmlspecialchars_decode($content); ?>
		</div>
		<!--=== end pricing-features ===-->
		
		<!--=== start pricing-btn ===-->
		<div class="price-btn">
			<?php if ( strlen( $linkbox ) > 0 && strlen( $url['url'] ) > 0 ) {
				echo '<a class="ot-btn btn-color" href="' . esc_attr( $url['url'] ) . '" target="' . ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) . '">' . esc_attr( $url['title'] ).'</a>';
			} ?>
		</div>
		<!--=== ejd pricing-btn ===-->
		
	</div>
	<?php } ?>

<?php
    return ob_get_clean();
}

// Pricing Table Compare

add_shortcode('pricingtable2', 'pricingtable2_func');
function pricingtable2_func($atts, $content = null){
  extract(shortcode_atts(array(
    'title'    => '',
    'price'    => '',
    'per'      => '',
    'head'     => '',
    'btn'      => '',
    'link'     => '',
  ), $atts));
  $hea = '';
  if($head == 'true'){
    $hea = ' hostingfeatures';
  }
  ob_start(); ?>

  <div class="comparison <?php echo esc_attr($hea); ?>">
    <div class="title-<?php if($head == 'true') echo 'features'; else echo 'alt'; ?>">
    <h4 class="id-color"><?php echo htmlspecialchars_decode($title); ?></h4>
    <?php if($price) { ?><div class="price"><?php echo htmlspecialchars_decode($price); ?> <span><?php echo htmlspecialchars_decode($per); ?></span></div><?php } ?>
    </div>
    <div class="pricing-table alter <?php if($head == 'true') echo 'features'; ?>">
    <?php echo htmlspecialchars_decode($content); ?>
    <?php if($btn) { ?><div class="btn-table"><a class="ot-btn btn-color" href="<?php echo esc_url($link); ?>"><?php echo esc_attr($btn); ?></a></div><?php } ?>
    </div>
  </div>

  <?php
    return ob_get_clean();
}

// Data Center
add_shortcode('datacenter','datacenter_func');
function datacenter_func($atts, $content = null){
	extract(shortcode_atts(array(
		'data'		=>	'',
	), $atts));
	$datas = (array) vc_param_group_parse_atts( $data );
	ob_start(); 
?>

	<div class="datacenter">
		<?php foreach ( $datas as $dat ) { ?>
		<?php 
		if(!empty($dat['photo'])) { $img = wp_get_attachment_image_src($dat['photo'],'full'); $meta = wp_prepare_attachment_for_js($dat['photo']); $alt = $meta['alt']; $img = $img[0]; }		
		if(!empty($dat['linkbox'])) $url = vc_build_link( $dat['linkbox'] ); ?>
		<div class="center-item">
			<?php if(!empty($img)) { ?><img src="<?php echo esc_url($img) ?>" alt="datacenter" /><?php } ?>
			<div class="center-content">
				<h4 class="id-color"><?php echo htmlspecialchars_decode($dat['name']); ?></h4>
				<?php echo htmlspecialchars_decode($dat['des']); ?>
			</div>
			<?php if ( !empty( $dat['linkbox'] ) && strlen( $url['url'] ) > 0 ) {
				echo '<a class="ot-btn btn-dark" href="' . esc_attr( $url['url'] ) . '" target="' . ( strlen( $url['target'] ) > 0 ? esc_attr( $url['target'] ) : '_self' ) . '">' . esc_attr( $url['title'] ).'</a>';
			} ?>
		</div>
        <?php } ?>
    </div>

<?php
    return ob_get_clean();
}

//FAQs
add_shortcode('otfaqs','otfaqs_func');
function otfaqs_func($atts, $content = null){
	extract(shortcode_atts(array(
		'faqs'		=>	'',
	), $atts));
		$faqs = (array) vc_param_group_parse_atts( $faqs );
	ob_start(); 
?>
	
	<div class="row">
		<div id="faqs-masonry" class="faqs-list">
		    <?php foreach ( $faqs as $faq ) { ?>
		    <div class="col-md-6 item">
			    <div class="faq-box">					
					<h4 class="faq-title"><?php echo htmlspecialchars_decode($faq['title']); ?></h4>
					<div class="faq-content"><?php echo htmlspecialchars_decode($faq['des']); ?></div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>

<?php
    return ob_get_clean();
}

// Our Facts
add_shortcode('facts','facts_func');
function facts_func($atts, $content = null){
	extract(shortcode_atts(array(
		'num'		=>	'',
		'icon'		=>	'',
		'title'		=>	'',
		'ico'		=>	'',
		'style'		=>	'style1',
	), $atts));
		
	ob_start(); 
?>
	
	<?php if($style == 'style1') { ?>
	<div class="de_count">
		<span class="timer" data-to="<?php echo esc_html($num); ?>" data-speed="2500">0</span>
        <?php if($icon) { ?>
        	<div class="icon-fact"><i class="<?php echo esc_attr($icon); ?>"></i></div>
        <?php } ?>
        <h3><?php echo htmlspecialchars_decode($title); ?></h3>
    </div>
	<?php }elseif($style == 'style2') { ?>
	<div class="de_count2">
		<?php if($icon) { ?>
        	<div class="icon-fact2 id-color"><i class="<?php echo esc_attr($icon); ?>"></i></div>
        <?php } ?>
		<span class="timer timer2" data-to="<?php echo esc_html($num); ?>" data-speed="2500">0</span>        
        <h6><?php echo htmlspecialchars_decode($title); ?></h6>
    </div>
	<?php } ?>
  	
<?php
    return ob_get_clean();
}

// Popup Video
add_shortcode('popupvideo', 'popupvideo_func');
function popupvideo_func($atts, $content = null){
	extract(shortcode_atts(array(
		'title'		=>	'',
		'link'		=>	'',
	), $atts));

	ob_start(); ?>

	<div class="video text-center">
								
		<a href="<?php echo esc_url($link); ?>" class="play-btn video-popup"><img src="<?php echo get_template_directory_uri(); ?>/images/btn-video.png" alt="video" /></a>
	
		<?php if($title) { ?><h5><?php echo htmlspecialchars_decode($title); ?></h5><?php } ?>
		
	</div>

<?php
    return ob_get_clean();
}


// Portfolio Filter
add_shortcode('portfoliof', 'portfoliof_func');
function portfoliof_func($atts, $content = null){
	extract(shortcode_atts(array(
		'all'		=> 	'All Items',
		'num'		=> 	'12',
		'col'		=>	'3',	
		'popup'		=>	'',	
	), $atts));
	ob_start(); ?>

	<div class="container project-filter">

        <!-- portfolio filter begin -->
        <div class="row">
            <ul id="filters" class="none-style">
                <li><a href="#" data-filter="*" class="selected"><?php echo esc_html($all); ?></a></li>
            	<?php 
		  			$categories = get_terms('categories');
		   			foreach( (array)$categories as $categorie){
		    			$cat_name = $categorie->name;
		    			$cat_slug = $categorie->slug;
				?>
		      	<li><a href="#" data-filter=".<?php echo htmlspecialchars_decode( $cat_slug ); ?>"><?php echo htmlspecialchars_decode( $cat_name ); ?></a></li>
		    	<?php } ?>
            </ul>
        </div>
        <!-- portfolio filter close -->

    </div>

	<div id="gallery" class="gallery pf_full_width pf_<?php echo esc_attr($col); ?>_cols gallery_border <?php if($popup) echo ' grid_gallery'; ?>">

        <?php 
  			$args = array(   
    			'post_type' => 'portfolio',   
    			'posts_per_page' => $num,	            
  			);  
  			$wp_query = new WP_Query($args);
  			while ($wp_query -> have_posts()) : $wp_query -> the_post(); 
  			$cates = get_the_terms(get_the_ID(),'categories');
  			$cate_name ='';
  			$cate_slug = '';
      		foreach((array)$cates as $cate){
      			if(count($cates)>0){
        			$cate_name .= $cate->name.'<span>, </span>' ;
        			$cate_slug .= $cate->slug .' ';     
      			} 
  			}
  			$image = wp_get_attachment_url(get_post_thumbnail_id());
  			$meta  = wp_prepare_attachment_for_js(get_post_thumbnail_id());
			$alt   = $meta['alt'];
  			$video = get_post_meta(get_the_ID(),'_cmb_popup_video', true);
		?>
        <div class="item <?php echo esc_attr($cate_slug); ?>">
            <div class="picframe">
                <a class="project-name" href="<?php the_permalink(); ?>">
                	<div class="overlay">
                		<i class="fa fa-plus"></i>
                	</div>
                	<img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($alt); ?>" />
                </a>
                <div class="cat-name">
                	<?php echo htmlspecialchars_decode($cate_name); ?>
                </div>
                <a class="project-name" href="<?php the_permalink(); ?>">
                    <?php the_title(); ?>
                </a>
            </div>
        </div>
        <?php endwhile; wp_reset_postdata(); ?>

    </div>

<?php
    return ob_get_clean();
}



// Logo Clients
add_shortcode('clients','clients_func');

function clients_func($atts, $content = null){
	extract(shortcode_atts(array(
		'gallery'		=> 	'',
		'col'		  	=>	'5',	
	), $atts));
		$img = wp_get_attachment_image_src($gallery,'full');
		$img = $img[0];
		$id = uniqid( 'logos-' );
	ob_start(); ?>
        	
		<div id="<?php echo esc_attr($id); ?>" class="owl-carousel owl-theme owl-partner">
			<?php 
				$img_ids = explode(",",$gallery);
				foreach( $img_ids AS $img_id ){
				$meta = wp_prepare_attachment_for_js($img_id);
				$caption = $meta['caption'];
				$title = $meta['title'];	
				$alt = $meta['alt'];	
				$description = $meta['description'];
				$image_src = wp_get_attachment_image_src($img_id,''); 
			?>
            <div class="item">
                <div class="partner-item">
                	<?php if($caption){ ?><a href="<?php echo esc_url($caption); ?>" target="_blank" ><?php } ?>
                		<img src="<?php echo esc_url( $image_src[0] ); ?>" alt="<?php echo esc_attr($alt); ?>">
                	<?php if($caption){ ?></a><?php } ?>
                </div>
            </div>
            <?php } ?>
        </div>

		<script>
			(function($) { "use strict";	

				var $logos = $( "#<?php echo esc_js($id); ?>" );
      			$logos.owlCarousel({
      				autoPlay: 7000,
      				items : <?php echo esc_attr($col); ?>,
      				itemsDesktop : [1200,<?php echo esc_attr($col); ?> - 1],
      				itemsDesktopSmall     : [979,3],
		          	itemsTablet       : [768,2],
		          	itemsMobile       : [480,1],
      				pagination: false
      			});

			})(jQuery); 
		</script>

<?php
    return ob_get_clean();	
}

//Google Map

add_shortcode('maps','maps_func');
function maps_func($atts, $content = null){
	extract(shortcode_atts(array(
		'height'	 	 => '450px',
		'imgmap'	 	 => '',
		'tooltip'	 	 => '',
		'latitude'		 => '',
		'longitude'	 	 => '',
		'zoom'		 	 => '',
	), $atts));
	$id = 'map-canvas-'.(rand(10,10000));
	ob_start(); ?>
	<?php 
		$img = wp_get_attachment_image_src($imgmap,'full');
		$img = $img[0];
		if(!$zoom){
			$zoom = 13;
		}
	 ?>

	<div id="<?php echo esc_attr($id); ?>" class="map-warp" style="<?php if($height) echo 'height: '.esc_attr($height).';';?>"></div>

	<script>
	(function($) { "use strict";
		var mapOptions = {
        zoom: <?php echo esc_js($zoom); ?>,
        scrollwheel: false,
        center: new google.maps.LatLng(<?php echo esc_js($latitude); ?>, <?php echo esc_js($longitude); ?>, 20.75),
        styles: [{
            "featureType": "water",
            "elementType": "geometry.fill",
            "stylers": [{
                "color": "#d3d3d3"
            }]
        },
            {
                "featureType": "transit",
                "stylers": [{
                    "color": "#808080"
                },
                    {
                        "visibility": "off"
                    }
						   ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "visibility": "on"
				},
                    {
                        "color": "#b3b3b3"
                    }
						   ]
            },
            {
                "featureType": "road.highway",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#ffffff"
                }]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry.fill",
                "stylers": [{
					"visibility": "on"
				},
                    {
                        "color": "#ffffff"
                    },
                    {
                        "weight": 1.8
                    }
						   ]
            },
            {
                "featureType": "road.local",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#d7d7d7"
                }]
            },
            {
                "featureType": "poi",
                "elementType": "geometry.fill",
                "stylers": [{
					"visibility": "on"
				},
                    {
                        "color": "#ebebeb"
                    }
						   ]
            },
            {
                "featureType": "administrative",
                "elementType": "geometry",
                "stylers": [{
                    "color": "#a7a7a7"
                }]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#ffffff"
                }]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#ffffff"
                }]
            },
            {
                "featureType": "landscape",
                "elementType": "geometry.fill",
                "stylers": [{
					"visibility": "on"
				},
                    {
                        "color": "#efefef"
                    }
						   ]
            },
            {
                "featureType": "road",
                "elementType": "labels.text.fill",
                "stylers": [{
                    "color": "#696969"
                }]
            },
            {
                "featureType": "administrative",
                "elementType": "labels.text.fill",
                "stylers": [{
					"visibility": "on"
				},
                    {
                        "color": "#737373"
                    }
						   ]
            },
            {
                "featureType": "poi",
                "elementType": "labels.icon",
                "stylers": [{
                    "visibility": "off"
                }]
            },
            {
                "featureType": "poi",
                "elementType": "labels",
                "stylers": [{
                    "visibility": "off"
                }]
            },
            {
                "featureType": "road.arterial",
                "elementType": "geometry.stroke",
                "stylers": [{
                    "color": "#d6d6d6"
                }]
            },
            {
                "featureType": "road",
                "elementType": "labels.icon",
                "stylers": [{
                    "visibility": "off"
                }]
            },
            {},
            {
                "featureType": "poi",
                "elementType": "geometry.fill",
                "stylers": [{
                    "color": "#dadada"
                }]
            }
				]
    };
	
    var mapElement = document.getElementById('<?php echo esc_attr($id); ?>'),
		map = new google.maps.Map(mapElement, mapOptions),
		marker = new google.maps.Marker({
			position: new google.maps.LatLng(<?php echo esc_js($latitude); ?>, <?php echo esc_js($longitude); ?>, 20.75),
			map: map,
			title: '',
			icon: '<?php echo esc_url($img); ?>'
		});
	})(jQuery); 

	</script>

	<?php

    return ob_get_clean();

}

// Google Map

add_shortcode('ggmap2','ggmap2_func');
function ggmap2_func($atts, $content = null){
    extract( shortcode_atts( array(
      'height'   => '',
      'address'  => '',
      'zoom'     => '',
      'icon'     => '',
   ), $atts ) );
   
   $lls = (array) vc_param_group_parse_atts( $address );
   $icon1 = wp_get_attachment_image_src($icon,'full');
   $icon1 = $icon1[0];
   if(!$zoom){
    $zoom = 2;
   }
      
    ob_start(); ?>
       
    <div id="mmaps" class="contacts-map" style="<?php if($height) echo 'height: '.$height.'px;'; ?>"></div>

    <script type="text/javascript">
  
    (function($) {
    "use strict"
    $(document).ready(function(){
        
    var map;
    var bounds = new google.maps.LatLngBounds();
    var mapOptions = {
        mapTypeId: 'roadmap',
        styles: [{"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},{"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},{"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},{"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},{"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},{"elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},{"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},{"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}]
    };

    // Display a map on the page
    map = new google.maps.Map(document.getElementById("mmaps"), mapOptions);
    map.setTilt(45);

    // Multiple Markers
    var markers = [
      <?php foreach ( $lls as $ll ) { ?>
        ['', <?php echo esc_js($ll['llong']); ?>],
      <?php } ?>
    ];

    // Info Window Content
    var infoWindowContent = [
      <?php foreach ( $lls as $ll ) { ?>
        ['<div class="info_content"><?php echo esc_js($ll["info"]); ?></div>'],
      <?php } ?>
    ];

    // Display multiple markers on a map
    var infoWindow = new google.maps.InfoWindow(), marker, i;

    // Loop through our array of markers & place each one on the map
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
        bounds.extend(position);
        marker = new google.maps.Marker({
            position: position,
            map: map,
            title: markers[i][0],
            icon: '<?php echo esc_url( $icon1 );?>'
        });

        // Allow each marker to have an info window
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

        // Automatically center the map fitting all markers on the screen
        map.fitBounds(bounds);
    }

    // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
    var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
        this.setZoom(<?php echo esc_js($zoom); ?>);
        google.maps.event.removeListener(boundsListener);
    });
    });
    })(jQuery);     
    </script>
<?php

    return ob_get_clean();

}
