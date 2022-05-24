<?php

/**
 * Latest posts.
 */
class Latest_Posts_Widget extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'latest_posts',
			esc_html__( 'Latest posts', 'sanjose' ),
			array( 'description' => esc_html__( 'Get latest posts', 'sanjose' ), )
		);
	}
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['count_posts'] = strip_tags( $new_instance['count_posts'] );
		return $instance;
	}
	public function form( $instance ) {
		$instance['title'] = ( isset( $instance['title'] ) && ! empty( $instance['title'] ) ) ? $instance['title'] : '';
		$instance['count_posts'] = ( isset( $instance['count_posts'] ) && ! empty( $instance['count_posts'] ) ) ? $instance['count_posts'] : '';
		?>
		<p>
			<label for="<?php print $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title', 'sanjose' ); ?></label>
			<input class="widefat" id="<?php print $this->get_field_id( 'title' ); ?>" 
				name="<?php print $this->get_field_name( 'title' ); ?>" type="text" 
				value="<?php print $instance['title']; ?>" />
		</p>
		<p>
			<label for="<?php print $this->get_field_id( 'count_posts' ); ?>"><?php esc_html_e( 'Count posts', 'sanjose' ); ?></label>
			<input class="widefat" id="<?php print $this->get_field_id( 'count_posts' ); ?>" 
				name="<?php print $this->get_field_name( 'count_posts' ); ?>" type="text" 
				value="<?php print $instance['count_posts']; ?>" />
		</p>
		<?php
	}

	public function widget( $args, $instance ) {

		/** This filter is documented in wp-includes/default-widgets.php */
		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
		$count_posts = ( ! empty( $instance['count_posts'] ) && is_numeric( $instance['count_posts'] ) ) ? $instance['count_posts'] : 2;

		print $args['before_widget'];
		if ( $title ) {
			print $args['before_title'] . $title . $args['after_title'];
		}
				
		$posts = get_posts( array( 'numberposts' => $count_posts ) );
		if ( $posts ) {
			if ( ! file_exists( EF_ROOT . '/aq_resizer.php' ) ) {
				print "<p>" . esc_html__( 'Plaese activate required plugins', 'sanjose' ) . ".</p>";
			} else {
				require_once EF_ROOT . '/aq_resizer.php';
				$output  = '<div class="sanjose-latest-post">';
				$output .= '<ul>';
				foreach ( $posts as $post ) {
					$img_url = wp_get_attachment_url( get_post_thumbnail_id( $post->ID ) );

					$output .= '<li>';
					$output .= ( ! empty( $img_url ) ) ? '<a class="wrapp-img" href="' . get_permalink( $post->ID ) . '"><img src="' . aq_resize( $img_url, 92, 70, true, true, true ) . '" class="hidden-img" alt=""></a>' : '';
					$output .= ( ! empty( $img_url ) ) ? '<div class="content">' : '<div>';
					$output .= '<a href="' . get_permalink( $post->ID ) . '" class="link">' . $post->post_title . '</a>';
					$output .= '<div class="post-info-content">';
					$output .= '<span class="post-date">' . get_the_time( get_option('date_format'), $post->ID ) . '</span>';
					$output .= '</div>';
					$output .= '</div>';
					$output .= '</li>';
				}
				$output .= '</ul>';
				$output .= '</div>';
			}
			
			echo $output;
		}

		echo $args['after_widget'];
	}
}

add_action( 'widgets_init', function() {
	register_widget( 'Latest_Posts_Widget' );
});

/**
 * Info Widget.
 */
class Info_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'Info_Widget',
			esc_html__( 'Info Widget', 'sanjose' ),
			array( 'classname' => 'info_widget','description' => esc_html__( 'Displays image box with text', 'sanjose' ), )
		);
	}

	function widget( $args, $instance ) {
		// Widget output

		extract($args, EXTR_SKIP);

		$title     = empty($instance['title']) ? ''  : $instance['title'];
		$form_text = ( ! empty( $instance['form_text'] ) ) ? $instance['form_text'] : '';
        $url_tw    = empty($instance['url_tw']) ? ''  : apply_filters('widget_url_tw', $instance['url_tw']);
        $url_fb    = empty($instance['url_fb']) ? ''  : apply_filters('widget_url_fb', $instance['url_fb']);
        $url_gg    = empty($instance['url_gg']) ? ''  : apply_filters('widget_url_gg', $instance['url_gg']);
        $url_pt    = empty($instance['url_pt']) ? ''  : apply_filters('widget_url_pt', $instance['url_pt']);
        $url_lk    = empty($instance['url_lk']) ? ''  : apply_filters('widget_url_lk', $instance['url_lk']);

		echo $args['before_widget'];

		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		$output  = '<div class="info-content">';

		$output .= ( ! empty( $form_text ) ) ? '<p>' . $form_text . '</p>' : '';

		$output .= '<ul>';

		    if ( ! empty( $url_tw ) ) :
		        $output .= '<li><a href="' . esc_url( $url_tw ) . '"><i class="fa fa-twitter"></i></a></li>';
		    endif;

		    if ( ! empty( $url_fb ) ) :
		        $output .= '<li><a href="' . esc_url( $url_fb ) . '"><i class="fa fa-facebook"></i></a></li>';
		    endif;

            if ( ! empty( $url_gg ) ) :
                $output .= '<li><a href="' . esc_url( $url_gg ) . '"><i class="fa fa-google-plus"></i></a></li>';
            endif;

            if ( ! empty( $url_pt ) ) :
                $output .= '<li><a href="' . esc_url( $url_pt ) . '"><i class="fa fa-pinterest-p"></i></a></li>';
            endif;

            if ( ! empty( $url_lk ) ) :
                $output .= '<li><a href="' . esc_url( $url_lk ) . '"><i class="fa fa-linkedin"></i></a></li>';
            endif;

		$output .= '</ul>';

		$output .= '</div>';

		echo $output;

		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['form_text'] = $new_instance['form_text'];
		$instance['url_tw']    = $new_instance['url_tw'];
		$instance['url_fb']    = $new_instance['url_fb'];
		$instance['url_gg']    = $new_instance['url_gg'];
		$instance['url_pt']    = $new_instance['url_pt'];
		$instance['url_lk']    = $new_instance['url_lk'];

		return $instance;
	}

	function form( $instance ) {
		// Output admin widget options form
		$instance = wp_parse_args( (array) $instance, array( 
			'title'     => '',
			'form_text' => '',
			'url_tw'    => '',
			'url_fb'    => '',
			'url_gg'    => '',
			'url_pt'    => '',
			'url_lk'    => '',
			)
		);
		$title     = $instance['title'];
		$form_text = $instance['form_text'];
		$url_tw    = $instance['url_tw'];
		$url_fb    = $instance['url_fb'];
		$url_gg    = $instance['url_gg'];
		$url_pt    = $instance['url_pt'];
		$url_lk    = $instance['url_lk'];

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title:','sanjose'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('form_text'); ?>">
				<?php esc_html_e( 'Text:','sanjose'); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('form_text'); ?>"
				name="<?php echo $this->get_field_name('form_text'); ?>"
				type="text" value="<?php echo esc_attr($form_text); ?>" />
			</label>
		</p>
        <p>
            <label for="<?php echo $this->get_field_id('url_tw'); ?>">
                <?php esc_html_e( 'Twitter url:','sanjose'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('url_tw'); ?>"
                       name="<?php echo $this->get_field_name('url_tw'); ?>"
                       type="text" value="<?php echo esc_attr($url_tw); ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('url_fb'); ?>">
                <?php esc_html_e( 'Facebook url:','sanjose'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('url_fb'); ?>"
                       name="<?php echo $this->get_field_name('url_fb'); ?>"
                       type="text" value="<?php echo esc_attr($url_fb); ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('url_gg'); ?>">
                <?php esc_html_e( 'Google plus url:','sanjose'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('url_gg'); ?>"
                       name="<?php echo $this->get_field_name('url_gg'); ?>"
                       type="text" value="<?php echo esc_attr($url_gg); ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('url_pt'); ?>">
                <?php esc_html_e( 'Pinterest url:','sanjose'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('url_pt'); ?>"
                       name="<?php echo $this->get_field_name('url_pt'); ?>"
                       type="text" value="<?php echo esc_attr($url_pt); ?>" />
            </label>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('url_lk'); ?>">
                <?php esc_html_e( 'Linkedin url:','sanjose'); ?>
                <input class="widefat" id="<?php echo $this->get_field_id('url_lk'); ?>"
                       name="<?php echo $this->get_field_name('url_lk'); ?>"
                       type="text" value="<?php echo esc_attr($url_lk); ?>" />
            </label>
        </p>
		<?php
	}
}

add_action( 'widgets_init', function() {
	register_widget( 'Info_Widget' );
});

/**
 * Social Widget.
 */
class Social_Widget extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'Social_Widget',
			esc_html__( 'Displays image box with text', 'sanjose' ),
			array( 'classname' => 'Social_Widget','description' => esc_html__( 'Social Widget', 'sanjose' ), )
		);
	}

	function widget( $args, $instance ) {
		// Widget output

		extract($args, EXTR_SKIP);

		$title = empty($instance['title']) ? ''  : apply_filters('widget_title', $instance['title']);

		$title_fb = empty($instance['title_fb']) ? ''  : apply_filters('widget_title_fb', $instance['title_fb']);
		$title_gp = empty($instance['title_gp']) ? ''  : apply_filters('widget_title_gp', $instance['title_gp']);
		$title_tw = empty($instance['title_tw']) ? ''  : apply_filters('widget_title_tw', $instance['title_tw']);
		$title_in = empty($instance['title_in']) ? ''  : apply_filters('widget_title_in', $instance['title_in']);

		$fb = ( ! empty( $instance['fb'] ) ) ? $instance['fb'] : '';
		$gp = ( ! empty( $instance['gp'] ) ) ? $instance['gp'] : '';
		$tw = ( ! empty( $instance['tw'] ) ) ? $instance['tw'] : '';
		$in = ( ! empty( $instance['in'] ) ) ? $instance['in'] : '';
		
		echo $args['before_widget'];

		if ( $title ) {
			print $args['before_title'] . $title . $args['after_title'];
		}
		$output = '';
		$output .= '<ul class="social-info">';
		$output .= ( ! empty( $fb ) ) ? '<li><a href="' . esc_url( $fb ) . '"><i class="fa fa-facebook"></i>' . $title_fb . '</a></li>' : '';
		$output .= ( ! empty( $gp ) ) ? '<li><a href="' . esc_url( $gp ) . '"><i class="fa fa-google-plus"></i>' . $title_gp . '</a></li>' : '';
		$output .= ( ! empty( $tw ) ) ? '<li><a href="' . esc_url( $tw ) . '"><i class="fa fa-twitter"></i>' . $title_tw . '</a></li>' : '';
		$output .= ( ! empty( $in ) ) ? '<li><a href="' . esc_url( $in ) . '"><i class="fa fa-linkedin"></i>' . $title_in . '</a></li>' : '';
		$output .= '</ul>';

		echo $output;

		echo $args['after_widget'];
	}

	function update( $new_instance, $old_instance ) {
		// Save widget options
		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];

		$instance['title_fb'] = $new_instance['title_fb'];
		$instance['title_gp'] = $new_instance['title_gp'];
		$instance['title_tw'] = $new_instance['title_tw'];
		$instance['title_in'] = $new_instance['title_in'];

		$instance['fb'] = $new_instance['fb'];
		$instance['gp'] = $new_instance['gp'];
		$instance['tw'] = $new_instance['tw'];
		$instance['in'] = $new_instance['in'];
		return $instance;
	}

	function form( $instance ) {
		// Output admin widget options form
		$instance = wp_parse_args( (array) $instance, array( 
			'title' => '',
			'title_fb' => '',
			'title_gp' => '',
			'title_tw' => '',
			'title_in' => '',
			'fb' => '',
			'gp' => '',
			'tw' => '',
			'in' => '',
			) 
		);

		$title = $instance['title'];

		$title_fb = $instance['title_fb'];
		$title_gp = $instance['title_gp'];
		$title_tw = $instance['title_tw'];
		$title_in = $instance['title_in'];

		$fb = $instance['fb'];
		$gp = $instance['gp'];
		$tw = $instance['tw'];
		$in = $instance['in'];

		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php esc_html_e( 'Title Widget:','sanjose'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('fb'); ?>">
				<?php esc_html_e( 'Facebook URL:','sanjose'); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('fb'); ?>" 
				name="<?php echo $this->get_field_name('fb'); ?>" 
				type="text" value="<?php echo esc_attr($fb); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('title_fb'); ?>"><?php esc_html_e( 'Title Facebook:','sanjose'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('title_fb'); ?>" name="<?php echo $this->get_field_name('title_fb'); ?>" type="text" value="<?php echo esc_attr($title_fb); ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('gp'); ?>">
				<?php esc_html_e( 'Google Plus URL:','sanjose'); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('gp'); ?>" 
				name="<?php echo $this->get_field_name('gp'); ?>" 
				type="text" value="<?php echo esc_attr($gp); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('title_gp'); ?>"><?php esc_html_e( 'Title Google Plus:','sanjose'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('title_gp'); ?>" name="<?php echo $this->get_field_name('title_gp'); ?>" type="text" value="<?php echo esc_attr($title_gp); ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('tw'); ?>">
				<?php esc_html_e( 'Twitter URL:','sanjose'); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('tw'); ?>" 
				name="<?php echo $this->get_field_name('tw'); ?>" 
				type="text" value="<?php echo esc_attr($tw); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('title_tw'); ?>"><?php esc_html_e( 'Title Twitter:','sanjose'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('title_tw'); ?>" name="<?php echo $this->get_field_name('title_tw'); ?>" type="text" value="<?php echo esc_attr($title_tw); ?>" /></label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('in'); ?>">
				<?php esc_html_e( 'Linkedin URL:','sanjose'); ?>
				<input class="widefat" id="<?php echo $this->get_field_id('in'); ?>" 
				name="<?php echo $this->get_field_name('in'); ?>" 
				type="text" value="<?php echo esc_attr($in); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('title_in'); ?>"><?php esc_html_e( 'Title Linkedin:','sanjose'); ?>
			<input class="widefat" id="<?php echo $this->get_field_id('title_in'); ?>" name="<?php echo $this->get_field_name('title_in'); ?>" type="text" value="<?php echo esc_attr($title_in); ?>" /></label>
		</p>
		<?php
	}
}

add_action( 'widgets_init', function() {
	register_widget( 'Social_Widget' );
});
