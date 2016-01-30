<?php
    get_header();
    $cb_sidebar = ot_get_option('cb_buddypress_sidebar', 'sidebar');
    $cb_current_user = bp_displayed_user_id();
    $cb_title_prefix = get_the_title();
    $cb_bp_current_component = bp_current_component();
    $cb_bp_current_action = bp_current_action();

    if ( ( ( $cb_bp_current_component == 'activity' ) || ( $cb_bp_current_component == 'profile' ) ) && ( bp_is_directory() == false ) && ( $cb_bp_current_action != NULL ) ) {
        $cb_title_prefix = __( 'Member', 'buddypress' );
    }

    if ( ( $cb_bp_current_component == 'groups' )   && ( $cb_bp_current_action != NULL ) ) {
        $cb_title_prefix = __( 'Group', 'buddypress' );
    }

    if ( ( $cb_bp_current_component == 'groups' )   && ( ( $cb_bp_current_action == 'my-groups' ) || ( $cb_bp_current_action == 'invites' ) ) ) {
        $cb_title_prefix = __( 'Groups', 'buddypress' );
    }

    if ( ( $cb_bp_current_component == 'settings' ) ) {
        $cb_title_prefix = __( 'Settings', 'buddypress' );
    }

    if ( ( $cb_bp_current_component == 'forums' ) ) {
        $cb_title_prefix = __( 'Forums', 'buddypress' );
    }

    if ( ( $cb_bp_current_component == 'activity' ) && ( $cb_bp_current_action == NULL ) ) {
        $cb_title_prefix = __( 'Activity', 'buddypress' );
    }

    if ( ( $cb_bp_current_component == 'groups' ) && ( $cb_bp_current_action == NULL ) ) {
        $cb_title_prefix = __( 'Groups', 'buddypress' ) . ' ' . '<a class="cb-group-create cb-tip-bot" title="' . __( 'Create a Group', 'buddypress' ) . '" href="' . trailingslashit( bp_get_root_domain() . '/' . bp_get_groups_root_slug() . '/create' ) . '"><i class="fa fa-plus"></i></a>';
    }

    if ( ( $cb_bp_current_component == 'groups' ) && ( $cb_bp_current_action == 'create' ) ) {
        $cb_title_prefix = __( 'Create a Group', 'buddypress' );
    }

    if ( (string)(int) $cb_bp_current_action == $cb_bp_current_action && ( $cb_bp_current_component == 'activity' ) ) {
        $cb_title_prefix = __( 'Activity', 'buddypress' );
    }


?>
    <div id="cb-content" class="wrap clearfix">

    <div id="main" class="cb-main" role="main">

        <div class="cb-module-header cb-category-header">
           <h1 class="cb-module-title"><?php echo $cb_title_prefix  ; ?></h1>
        </div>

        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

            <section class="cb-entry-content clearfix" itemprop="articleBody">
                <?php the_content(); ?>
            </section> <!-- end article section -->

        </article> <!-- end article -->

        <?php endwhile; endif; ?>

    </div> <!-- end #main -->

    <?php if ( ( $cb_sidebar != 'nosidebar' ) && ( $cb_sidebar != 'nosidebar-fw' ) ) { get_sidebar(); } ?>

    </div> <!-- end #cb-content -->

<?php get_footer(); ?>