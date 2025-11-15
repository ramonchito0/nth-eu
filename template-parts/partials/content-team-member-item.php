<?php
$member = get_query_var( 'member' );
$show_location = get_query_var( 'show_location', false );
$booking_link = get_query_var( 'booking_link', null );

if ( ! $member instanceof WP_Post ) {
    return;
}

$member_id = $member->ID;
$member_title = get_the_title( $member_id );
$member_permalink = get_permalink( $member_id );
$member_featured_image = get_the_post_thumbnail( $member_id, 'full', array( 'class' => 'w-full h-full object-cover' ) );

$job_title = get_field( 'position', $member_id );
$short_description = get_field( 'short_description', $member_id );
?>
<div class="nds-team-member-item max-lg:border-b max-lg:border-solid max-lg:border-primary">

    <div class="nds-team-member-image bg-[rgba(229,229,229,0.5)] w-full h-[28.625rem] rounded-[1.375rem] overflow-hidden mb-7.5 relative max-lg:mb-[3.6875rem]">
        <?php if ( $show_location ) : ?>
            <?php
            $locations = wp_get_post_terms( $member_id, 'location' );
            if ( ! empty( $locations ) && ! is_wp_error( $locations ) ) :
            ?>
                <div class="nds-team-member-locations absolute flex flex-wrap gap-2.5 top-6 left-6 hidden">
                    <?php foreach ( $locations as $index => $location ) : ?>
                        <span class="location-item text-base bg-[#E5E5E5] rounded-full py-2 px-7.5"><?php echo esc_html( $location->name ); ?></span><?php if ( $index < count( $locations ) - 1 ) : ?> </span><?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ( $member_featured_image ) : ?>
            <?php echo $member_featured_image; ?>
        <?php endif; ?>
    </div>
    
    <div class="nds-team-member-content border-b border-solid border-primary pb-7 max-lg:pb-6">
        <?php if ( $member_title ) : ?>
            <h3 class="nds-team-member-name !mb-2 max-lg:!text-[1.375rem] max-lg:!mb-0">
                <?php echo esc_html( $member_title ); ?>
            </h3>
        <?php endif; ?>
        
        <p class="nds-team-member-job-title min-h-7.5 max-lg:min-h-auto max-lg:text-sm">
            <?php if ( $job_title ) : ?>
                <?php echo esc_html( $job_title ); ?>
            <?php endif; ?>
        </p>

        <?php 
        if ( $booking_link ) : 
            $link_array['link'] = $booking_link;
            $link_array['style'] = 'plain';

            echo nds_button_single_render(  $link_array );
        
        endif; ?>
    </div>

    <?php if ( $short_description ) : ?>
        <button type="button" class="nds-btn-expand-description flex gap-5 justify-between text-left w-full cursor-pointer mt-[1.1875rem] max-lg:hidden"><span>Learn more</span></button>
        <div class="nds-team-member-description max-h-0 overflow-hidden w-[calc(100%-2.3125rem)] transform translate-y-[-1.3125rem] max-lg:!max-h-none max-lg:w-full max-lg:!translate-y-0 max-lg:!opacity-100 max-lg:!py-6">
            <?php echo wp_kses_post( wpautop( $short_description ) ); ?>
        </div>
    <?php endif; ?>
</div>