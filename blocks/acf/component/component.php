<?php
$component_id = get_field('component');

if ($component_id) {

    $component_post = get_post($component_id);

    global $post;
    $original_post = $post;

    // Switch context so ACF loads correct fields
    $post = $component_post;
    setup_postdata($post);

    $blocks = parse_blocks($component_post->post_content);

    foreach ($blocks as $block) {
        echo render_block($block);
    }

    // Restore original context
    wp_reset_postdata();
}
