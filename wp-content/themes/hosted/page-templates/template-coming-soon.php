<?php

/*
 * Template Name: Coming Soon
 * Description: A Page Template.
 */
 ?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8 no-js lt-ie9" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    
<?php 
	wp_head();
	$cdate = hosted_get_option("time_date") ? hosted_get_option("time_date") : '09/14/2017';
?>
</head>
	
<body>

	<section class="no-padding bg-img bgcms text-center">
		<div class="warp-404">
			<div class="warp-comingsoon-inner">
				<div class="top-cms">
					<div class="container">
						<h1 class="logocms">
							<?php $logo = hosted_get_option( 'logocms' ) ? hosted_get_option( 'logocms' ) : get_template_directory_uri().'/images/logo-cms.png'; ?>
					        <a href="<?php echo esc_url( home_url('/') ); ?>">
					            <img src="<?php echo esc_url($logo); ?>" alt="">
					        </a>
						</h1>
						<div class="big-title"><?php esc_html_e('Something awesome is coming soon', 'hosted'); ?></div>
						<p><?php esc_html_e('We are working hard to finish our amazing new website. We are almost done!', 'hosted'); ?></p>
					</div>
				</div>
				<div class="countdown">
					<div class="container">
						<div class="row">
							<div class="col-count">
								<div class="item-counter-down">
		                        	<span class="days">00</span>
		                        	<div class="days_ref"><?php esc_html_e('days', 'hosted'); ?></div>
		                        </div>
		                    </div>
		                    <div class="col-count"> 
		                    	<div class="item-counter-down">
		                        	<span class="hours">00</span>
		                        	<div class="hours_ref">hours<?php esc_html_e('hours', 'hosted'); ?></div>
		                        </div>
		                    </div>
		                     <div class="col-count">
		                     	<div class="item-counter-down">
		                        	<span class="minutes">00</span>
		                        	<div class="minutes_ref"><?php esc_html_e('minutes', 'hosted'); ?></div>
		                        </div>
		                    </div>
		                    <div class="col-count">  
		                    	<div class="item-counter-down">
		                        	<span class="seconds">00</span>
		                        	<div class="seconds_ref"><?php esc_html_e('seconds', 'hosted'); ?></div>
		                        </div>
		                    </div>
	                   	</div>
                   	</div>
				</div>
				<div class="subsc">
					<div class="container">
					   	<div class="big-title"><?php esc_html_e('Subscribe & stay updated', 'hosted'); ?></div>
					   	<p><?php esc_html_e('Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
					   	Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 'hosted'); ?></p>
					   	<?php echo do_shortcode("".hosted_get_option('mailchimp').""); ?>
				   	</div>
				</div>
			</div>
		</div>
	</section>

</body>

<script type="text/javascript">
  	(function($) {
  		"use strict";	
    
		$.fn.downCount = function (options, callback) {
			var settings = $.extend({
					date: null,
					offset: null
				}, options);

			// Throw error if date is not set
			if (!settings.date) {
				$.error('Date is not defined.');
			}

			// Throw error if date is set incorectly
			if (!Date.parse(settings.date)) {
				$.error('Incorrect date format, it should look like this, 12/24/2012 12:00:00.');
			}

			// Save container
			var container = this;

			/**
			 * Change client's local date to match offset timezone
			 * @return {Object} Fixed Date object.
			 */
			var currentDate = function () {
				// get client's current date
				var date = new Date();

				// turn date to utc
				var utc = date.getTime() + (date.getTimezoneOffset() * 60000);

				// set new Date object
				var new_date = new Date(utc + (3600000*settings.offset))

				return new_date;
			};

			/**
			 * Main downCount function that calculates everything
			 */
			function countdown () {
				var target_date = new Date(settings.date), // set target date
					current_date = currentDate(); // get fixed current date

				// difference of dates
				var difference = target_date - current_date;

				// if difference is negative than it's pass the target date
				if (difference < 0) {
					// stop timer
					clearInterval(interval);

					if (callback && typeof callback === 'function') callback();

					return;
				}

				// basic math variables
				var _second = 1000,
					_minute = _second * 60,
					_hour = _minute * 60,
					_day = _hour * 24;

				// calculate dates
				var days = Math.floor(difference / _day),
					hours = Math.floor((difference % _day) / _hour),
					minutes = Math.floor((difference % _hour) / _minute),
					seconds = Math.floor((difference % _minute) / _second);

					// fix dates so that it will show two digets
					days = (String(days).length >= 2) ? days : '0' + days;
					hours = (String(hours).length >= 2) ? hours : '0' + hours;
					minutes = (String(minutes).length >= 2) ? minutes : '0' + minutes;
					seconds = (String(seconds).length >= 2) ? seconds : '0' + seconds;

				// based on the date change the refrence wording
				var ref_days = (days === 1) ? 'day' : 'days',
					ref_hours = (hours === 1) ? 'hour' : 'hours',
					ref_minutes = (minutes === 1) ? 'minute' : 'minutes',
					ref_seconds = (seconds === 1) ? 'second' : 'seconds';
					

				// set to DOM
				container.find('.days').text(days);
				container.find('.hours').text(hours);
				container.find('.minutes').text(minutes);
				container.find('.seconds').text(seconds);

				container.find('.days_ref').text(ref_days);
				container.find('.hours_ref').text(ref_hours);
				container.find('.minutes_ref').text(ref_minutes);
				container.find('.seconds_ref').text(ref_seconds);
			};
			
			// start
			var interval = setInterval(countdown, 1000);
		};

		$('.countdown').downCount({
		  date: '<?php echo esc_js($cdate); ?>',
		  offset: +10
		});

  	})(jQuery);
</script>


<?php wp_footer(); ?>
