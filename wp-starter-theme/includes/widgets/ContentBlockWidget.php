<?php

/**
 * Adds ContentBlockWidget widget.
 */
class ContentBlockWidget extends WP_Widget {

    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'content_block_widget', // Base ID
            __( 'Content Block', THEME_SLUG ), // Name
            array(
                'description' => __( 'Widget to show content blocks.', THEME_SLUG )
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
        $selected_post_id = ( isset( $instance['content-block-id'] ) ) ? $instance['content-block-id'] : 0;

        $show_title = ( isset( $instance['show-title'] ) ) ? $instance['show-title'] : 0;

        echo $args['before_widget'];

        if( $selected_post_id !== 0 ) {
            $post = get_post( $selected_post_id );

            if( $post instanceof WP_POST ) {
                $content = apply_filters( 'the_content', $post->post_content );
                $content = str_replace( ']]>', ']]&gt;', $content );

                if( $show_title ) {
                    $title = apply_filters( 'widget_title', $post->post_title );

                    echo $args['before_title'] . $title . $args['after_title'];
                }

                echo $content;
            }
        }

        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
    public function form( $instance ) {
        $posts = get_posts( array(
            'post_type' => 'as_content_block',
            'numberposts' => -1
        ) );

        $selected_post_id = ( isset( $instance['content-block-id'] ) ) ? $instance['content-block-id'] : 0;

        $title = ( $selected_post_id ) ? get_the_title( $selected_post_id ) : '';

        $show_title = ( isset( $instance['show-title'] ) ) ? $instance['show-title'] : 0;
?>

        <input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="hidden" value="<?php echo esc_attr( $title ); ?>" />

        <p>
            <label for="<?php echo $this->get_field_id( 'content-block-id' ); ?>"><?php _e( 'Show content block:', THEME_SLUG ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'content-block-id' ); ?>" name="<?php echo $this->get_field_name( 'content-block-id' ); ?>" required>
                <option value="0" disabled <?php selected( $selected_post_id, 0 ); ?>>
                    <?php
                        if( empty( $posts ) ) {
                            _e( 'No content blocks found.', THEME_SLUG );
                        } else {
                            _e( 'Select a content block.', THEME_SLUG );
                        }
                    ?>
                </option>

                <?php foreach( $posts as $post ) : ?>
                    <option value="<?php echo $post->ID; ?>" <?php selected( $selected_post_id, $post->ID ); ?>><?php echo $post->post_title; ?></option>
                <?php endforeach; ?>
            </select>
        </p>

        <p>
            <label><input type="checkbox" id="<?php echo $this->get_field_id( 'show-title' ); ?>" name="<?php echo $this->get_field_name( 'show-title' ); ?>" value="1" <?php checked( $show_title, 1 ); ?> /> <?php _e( 'Show title?', THEME_SLUG ); ?></label>
        </p>

        <p><?php printf( __( 'Manage content blocks %shere%s.', THEME_SLUG ), '<a href="'. admin_url( 'edit.php?post_type=as_content_block' ) .'">', '</a>' ); ?></p>

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

        $instance['content-block-id'] = $new_instance['content-block-id'];

        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';

        $instance['show-title'] = ( isset( $new_instance['show-title'] ) && $new_instance['show-title'] == 1 ) ? 1 : 0;

        return $instance;
    }
}
