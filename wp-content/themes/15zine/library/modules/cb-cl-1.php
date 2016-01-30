 <?php /* Custom Links */

$cb_title_header = NULL;
$i = 1;
if ( $cb_title != NULL ) {
    $cb_title_header = '<div class="cb-module-header"><h2 class="cb-module-title" >' . $cb_title . '</h2>' . $cb_subtitle . '</div>';
}

$cb_feature_width = '378';
$cb_feature_height = '300';
$cb_arr = $cb_arr_sorted = array();
foreach ($cb_module as $key => $value) {

    if (substr($key, 0, 5) == "cb_cl") {

        $cb_arr[$key] = $value;
    }
}

if ( $cb_size == '1' ) {
    $cb_size = 'cb-grid-x cb-grid-6';
} elseif ( $cb_size == '2' ) {
    $cb_size = 'cb-single-link cb-cl-block';
} elseif ( $cb_size == '3' ) {
    $cb_size = 'cb-grid-3-sq cb-module-block cb-cl-block';
}

$cb_arr = array_filter($cb_arr);

foreach ( $cb_arr as $key => $value) {
    $cb_field_check = substr($key, -2);
    $cb_field = substr($key, 0, -2);
    if ( $cb_field_check == '_1' ) {
        $cb_arr_sorted['1'][$cb_field] = $value;
    } elseif ( $cb_field_check == '_2' ) {
        $cb_arr_sorted['2'][$cb_field] = $value;
    } elseif ( $cb_field_check == '_3' ) {
        $cb_arr_sorted['3'][$cb_field] = $value;
    } elseif ( $cb_field_check == '_4' ) {
        $cb_arr_sorted['4'][$cb_field] = $value;
    } elseif ( $cb_field_check == '_5' ) {
        $cb_arr_sorted['5'][$cb_field] = $value;
    } elseif ( $cb_field_check == '_6' ) {
        $cb_arr_sorted['6'][$cb_field] = $value;
    }
}

?>

<div class="cb-grid-block cb-module-block clearfix">
    
    <?php echo $cb_title_header; ?>
    
    <div class="<?php echo $cb_size; ?> clearfix">

        <?php foreach ( $cb_arr_sorted as $key ) { ?>
            <?php 
                if ( is_numeric($key['cb_cl_img']) ) {
                    $cb_img = wp_get_attachment_image_src( $key['cb_cl_img'], 'full' ); 
                } else {
                    $cb_img = array();
                    $cb_img[] = $key['cb_cl_img']; 
                }       

            ?>
    
            <div class="cb-grid-feature cb-s <?php echo ot_get_option( 'cb_grid_tile_design', 'cb-meta-style-4'); ?> cb-feature-<?php echo esc_attr( $i ); ?> clearfix">

                <div class="cb-grid-img"><img src="<?php echo esc_url( $cb_img[0] ); ?>" alt=""></div>

                <div class="cb-article-meta">
                    <h2><a href="<?php echo esc_url( $key['cb_cl'] ); ?>"><?php echo ( $key['cb_cl_text'] ); ?></a></h2>
               </div>

               <a href="<?php echo esc_url( $key['cb_cl'] ); ?>" class="cb-link-overlay"></a>

            </div>
            <?php $i++; ?>
        <?php } ?>

    </div>
</div>