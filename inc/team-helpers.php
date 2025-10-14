<?php
/**
 * Helper Functions for Team Member Components
 */

if ( ! function_exists( 'render_team_member_card' ) ) {
    /**
     * Render a team member card
     *
     * @param WP_Post|int $post Team member post object or ID
     * @param array $args Optional arguments
     * @return void
     */
    function render_team_member_card( $post, $args = [] ) {
        if ( is_numeric( $post ) ) {
            $post = get_post( $post );
        }
        
        if ( ! $post || $post->post_type !== 'team_member' ) {
            return;
        }
        
        $defaults = [
            'post' => $post,
            'class_modifier' => '',
            'show_contact' => true,
        ];
        
        $args = wp_parse_args( $args, $defaults );
        
        get_template_part( 'template-parts/components/team-member-card', null, $args );
    }
}

if ( ! function_exists( 'get_team_members' ) ) {
    /**
     * Get team members with optional filters
     *
     * @param array $args WP_Query arguments
     * @return WP_Post[]
     */
    function get_team_members( $args = [] ) {
        $defaults = [
            'post_type' => 'team_member',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'menu_order',
            'order' => 'ASC',
        ];
        
        $args = wp_parse_args( $args, $defaults );
        
        $query = new WP_Query( $args );
        
        return $query->posts;
    }
}

if ( ! function_exists( 'render_team_grid' ) ) {
    /**
     * Render a grid of team members
     *
     * @param array $team_members Array of team member posts
     * @param array $args Grid configuration
     * @return void
     */
    function render_team_grid( $team_members, $args = [] ) {
        if ( empty( $team_members ) ) {
            return;
        }
        
        $defaults = [
            'columns' => 3,
            'class_modifier' => 'grid-item',
            'show_contact' => true,
            'tag_title_card' => 'h3',
        ];
        
        $args = wp_parse_args( $args, $defaults );

        printf( '<div class="teams_grid">' );
        
        foreach ( $team_members as $team_member ) {
            render_team_member_card( $team_member, [
                'class_modifier' => $args['class_modifier'],
                'show_contact' => $args['show_contact'],
            ] );
        }
        
        echo '</div>';
    }
}
?>