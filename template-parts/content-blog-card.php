<article <?php post_class('blog-card'); ?>>
    <div class="blog-card__inner">

        <?php if (has_post_thumbnail()) : ?>
            <div class="blog-card__image">
                <a href="<?php the_permalink(); ?>">
                    <?php the_post_thumbnail('large'); ?>
                </a>
            </div>
        <?php endif; ?>

        <div class="blog-card__content">
            <div class="blog-card__meta">
                <span class="blog-card__date"><?php echo get_the_date('F j, Y'); ?></span>
                <?php
                    $categories = get_the_category();
                    if (!empty($categories)) :
                ?>
                    <span class="blog-card__dot">•</span>
                    <span class="blog-card__category">
                        <?php echo esc_html($categories[0]->name); ?>
                    </span>
                <?php endif; ?>
            </div>

            <h3 class="blog-card__title">
                <a href="<?php the_permalink(); ?>" class="h-text-18"><?php the_title(); ?></a>
            </h3>

            <p class="blog-card__excerpt">
                <?php echo wp_trim_words(get_the_excerpt(), 13, '…'); ?>
            </p>

<a href="<?php the_permalink(); ?>" class="btn btn-default btn-secondary">
                Read Article <span class="arrow">
<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M5.48071 0.375L10.8749 5.52401L5.48071 10.673" stroke="#1C1C1C" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"></path>
<path d="M10.8749 5.52417L0.375 5.52417" stroke="#1C1C1C" stroke-width="0.75" stroke-linecap="round" stroke-linejoin="round"></path>
</svg>
                    
                </span>
            </a>            
        </div>
    </div>
</article>
