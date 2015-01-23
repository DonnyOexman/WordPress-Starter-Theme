<?php

/**
 * Adds TestimonialsWidget widget.
 */
class TestimonialsWidget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'testimonials_widget', // Base ID
            __( 'Testimonials', THEME_SLUG ), // Name
            array(
                'description' => __( 'Widget to show testimonials.', THEME_SLUG )
            ) // Args
        );
    }

    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
    public function widget( $args, $instance ) {
        $widget_id = $args['widget_id'];

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 3;

        $slide_enable = ( isset( $instance['slide_enable'] ) && $instance['slide_enable'] === 1 ) ? true : false;
        $slide_transition_mode = ( ! empty( $instance['slide_transition_mode'] ) ) ? esc_attr( $instance['slide_transition_mode'] ) : 'fade';
        $slide_transition_speed = ( ! empty( $instance['slide_transition_speed'] ) ) ? absint( $instance['slide_transition_speed'] ) : 500;
        $slide_amount_between_transition = ( ! empty( $instance['slide_amount_between_transition'] ) ) ? absint( $instance['slide_amount_between_transition'] ) : 4000;
        $slide_auto = ( isset( $instance['slide_auto'] ) && $instance['slide_auto'] === 1 ) ? true : false;
        $slide_show_controls = ( isset( $instance['slide_show_controls'] ) && $instance['slide_show_controls'] === 1 ) ? true : false;
        $slide_show_pager = ( isset( $instance['slide_show_pager'] ) && $instance['slide_show_pager'] === 1 ) ? true : false;

        $query = new WP_Query( array(
            'post_type' => 'as_testimonial',
            'posts_per_page' => $number
        ) );

        if( $query->have_posts() ) :

            echo $args['before_widget'];

            if ( ! empty( $instance['title'] ) ) {
                echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
            }
?>

            <ul class="testimonials bxslider">

                <?php while( $query->have_posts() ) : $query->the_post(); ?>

                    <li>
                        <div class="quote"><?php the_content(); ?></div>

                        <?php the_title( '<p class="client-name">', '</p>' ); ?>
                    </li>

                <?php endwhile; wp_reset_postdata(); ?>

            </ul>

            <?php if( $slide_enable === true ) : ?>

                <script>
                    jQuery(function($) {
                        $( '#<?php echo $widget_id; ?> .bxslider' ).bxSlider({
                            mode: '<?php echo $slide_transition_mode; ?>',
                            speed: <?php echo $slide_transition_speed; ?>,
                            pause: <?php echo $slide_amount_between_transition; ?>,
                            <?php
                                if( $slide_show_controls === false ) echo 'controls: false,';
                                if( $slide_auto === true ) echo 'auto: true,';
                                if( $slide_show_pager === false ) echo 'pager: false,';
                            ?>
                        });
                    });
                </script>

            <?php endif; ?>

<?php
            echo $args['after_widget'];

        endif;
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $title = ( ! empty( $instance['title'] ) ) ? esc_attr( $instance['title'] ) : '';

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 3;

        $slide_enable = ( isset( $instance['slide_enable'] ) && $instance['slide_enable'] === 1 ) ? 1 : 0;
        $slide_transition_mode = ( ! empty( $instance['slide_transition_mode'] ) ) ? esc_attr( $instance['slide_transition_mode'] ) : 'fade';
        $slide_transition_speed = ( ! empty( $instance['slide_transition_speed'] ) ) ? absint( $instance['slide_transition_speed'] ) : 500;
        $slide_amount_between_transition = ( ! empty( $instance['slide_amount_between_transition'] ) ) ? absint( $instance['slide_amount_between_transition'] ) : 4000;
        $slide_auto = ( isset( $instance['slide_auto'] ) && $instance['slide_auto'] === 1 ) ? 1 : 0;
        $slide_show_controls = ( isset( $instance['slide_show_controls'] ) && $instance['slide_show_controls'] === 1 ) ? 1 : 0;
        $slide_show_pager = ( isset( $instance['slide_show_pager'] ) && $instance['slide_show_pager'] === 1 ) ? 1 : 0;
?>

        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', THEME_SLUG ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Number of posts to show:', THEME_SLUG ); ?></label>
            <input id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" type="text" value="<?php echo esc_attr( $number ); ?>" size="3" />
        </p>

        <p>
            <label><input type="checkbox" id="<?php echo $this->get_field_id( 'slide_enable' ); ?>" name="<?php echo $this->get_field_name( 'slide_enable' ); ?>" value="1" <?php checked( $slide_enable, 1 ); ?> /> <?php _e( 'Enable slideshow?', THEME_SLUG ); ?></label>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'slide_transition_mode' ) ); ?>"><?php _e( 'Slide transition mode:', THEME_SLUG ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'slide_transition_mode' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slide_transition_mode' ) ); ?>">
                <option value="horizontal" <?php selected( $slide_transition_mode, 'horizontal' ); ?> ><?php _e( 'Horizontal', THEME_SLUG ); ?></option>
                <option value="vertical" <?php selected( $slide_transition_mode, 'vertical' ); ?> ><?php _e( 'Vertical', THEME_SLUG ); ?></option>
                <option value="fade" <?php selected( $slide_transition_mode, 'fade' ); ?> ><?php _e( 'Fade', THEME_SLUG ); ?></option>
            </select>
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'slide_transition_speed' ) ); ?>"><?php _e( 'Slide transition speed:', THEME_SLUG ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'slide_transition_speed' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slide_transition_speed' ) ); ?>" type="text" value="<?php echo esc_attr( $slide_transition_speed ); ?>" size="5" />
        </p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'slide_amount_between_transition' ) ); ?>"><?php _e( 'Slide amount between transition:', THEME_SLUG ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'slide_amount_between_transition' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'slide_amount_between_transition' ) ); ?>" type="text" value="<?php echo esc_attr( $slide_amount_between_transition ); ?>" size="5" />
        </p>

        <p>
            <label><input type="checkbox" id="<?php echo $this->get_field_id( 'slide_auto' ); ?>" name="<?php echo $this->get_field_name( 'slide_auto' ); ?>" value="1" <?php checked( $slide_auto, 1 ); ?> /> <?php _e( 'Automatically slide?', THEME_SLUG ); ?></label>
        </p>

        <p>
            <label><input type="checkbox" id="<?php echo $this->get_field_id( 'slide_show_controls' ); ?>" name="<?php echo $this->get_field_name( 'slide_show_controls' ); ?>" value="1" <?php checked( $slide_show_controls, 1 ); ?> /> <?php _e( 'Show slide controls?', THEME_SLUG ); ?></label>
        </p>

        <p>
            <label><input type="checkbox" id="<?php echo $this->get_field_id( 'slide_show_pager' ); ?>" name="<?php echo $this->get_field_name( 'slide_show_pager' ); ?>" value="1" <?php checked( $slide_show_pager, 1 ); ?> /> <?php _e( 'Show slide bullets?', THEME_SLUG ); ?></label>
        </p>

<?php
    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update( $new_instance, $old_instance ) {
        $instance = array();

        $instance['title']  = strip_tags( $new_instance['title'] );

        $instance['number'] = ( ! empty( $new_instance['number'] ) ) ? absint( $new_instance['number'] ) : 3;

        $instance['slide_enable'] = ( isset( $new_instance['slide_enable'] ) && $new_instance['slide_enable'] === '1' ) ? 1 : 0;
        $instance['slide_transition_mode'] = ( ! empty( $new_instance['slide_transition_mode'] ) ) ? esc_attr( $new_instance['slide_transition_mode'] ) : 'fade';
        $instance['slide_transition_speed'] = ( ! empty( $new_instance['slide_transition_speed'] ) ) ? absint( $new_instance['slide_transition_speed'] ) : 500;
        $instance['slide_amount_between_transition'] = ( ! empty( $new_instance['slide_amount_between_transition'] ) ) ? absint( $new_instance['slide_amount_between_transition'] ) : 4000;
        $instance['slide_auto'] = ( isset( $new_instance['slide_auto'] ) && $new_instance['slide_auto'] === '1' ) ? 1 : 0;
        $instance['slide_show_controls'] = ( isset( $new_instance['slide_show_controls'] ) && $new_instance['slide_show_controls'] === '1' ) ? 1 : 0;
        $instance['slide_show_pager'] = ( isset( $new_instance['slide_show_pager'] ) && $new_instance['slide_show_pager'] === '1' ) ? 1 : 0;

        return $instance;
    }
}
