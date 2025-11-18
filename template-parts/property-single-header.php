            <section class="flex flex-col gap-8 mt-8">
                <!-- Title -->
                <h1 class="h-text-56 !mb-0">
                    <?php the_title(); ?>
                </h1>

                <!-- Meta Row -->
                <div class="flex flex-wrap items-center gap-4 text-[#1C1C1C]">

                    <!-- Location -->
                    <?php 
                    $city = get_field('city');
                    $state = get_field('state');
                    ?>
                    <?php if ($city || $state): ?>
                        <div class="flex items-center gap-2">
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1165_20521)">
                            <path d="M1.51172 16.534L11.4559 16.6501C11.4559 16.6501 11.433 16.0436 11.3152 15.4643C10.99 13.865 9.92789 11.0364 6.48303 11.0364C3.03818 11.0364 1.97608 13.865 1.65087 15.4643C1.53308 16.0436 1.51172 16.534 1.51172 16.534Z" stroke="#393B44" stroke-width="1.5" stroke-linecap="square"/>
                            <path d="M13.0273 11.0364C15.2042 11.0364 16.0957 13.2856 16.4557 14.9067C16.65 15.7821 15.9419 16.534 15.0451 16.534H14.0745" stroke="#393B44" stroke-width="1.5" stroke-linecap="square"/>
                            <path d="M6.48322 7.10951C8.07364 7.10951 9.36293 5.82022 9.36293 4.2298C9.36293 2.63939 8.07364 1.3501 6.48322 1.3501C4.8928 1.3501 3.60352 2.63939 3.60352 4.2298C3.60352 5.82022 4.8928 7.10951 6.48322 7.10951Z" stroke="#393B44" stroke-width="1.5" stroke-linecap="square"/>
                            <path d="M11.9805 7.10951C13.5709 7.10951 14.5984 5.82022 14.5984 4.2298C14.5984 2.63939 13.5709 1.3501 11.9805 1.3501" stroke="#393B44" stroke-width="1.5" stroke-linecap="square"/>
                            </g>
                            <defs>
                            <clipPath id="clip0_1165_20521">
                            <rect width="18" height="18" fill="white"/>
                            </clipPath>
                            </defs>
                            </svg>


                            <span class="text-sm">
                                <?php echo esc_html($city); ?><?php if ($city && $state) echo ', '; ?>
                                <?php echo esc_html($state); ?>
                            </span>
                        </div>
                    <?php endif; ?>

                    <!-- Divider -->
                    <span class="text-gray-400">|</span>

                    <!-- Guest Count -->
                    <?php $guest_count = get_field('guest_count'); ?>
                    <?php if ($guest_count): ?>
                        <div class="flex items-center gap-2">
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_1165_20521)">
                                <path d="M1.51172 16.534L11.4559 16.6501C11.4559 16.6501 11.433 16.0436 11.3152 15.4643C10.99 13.865 9.92789 11.0364 6.48303 11.0364C3.03818 11.0364 1.97608 13.865 1.65087 15.4643C1.53308 16.0436 1.51172 16.534 1.51172 16.534Z" stroke="#393B44" stroke-width="1.5" stroke-linecap="square"/>
                                <path d="M13.0273 11.0364C15.2042 11.0364 16.0957 13.2856 16.4557 14.9067C16.65 15.7821 15.9419 16.534 15.0451 16.534H14.0745" stroke="#393B44" stroke-width="1.5" stroke-linecap="square"/>
                                <path d="M6.48322 7.10951C8.07364 7.10951 9.36293 5.82022 9.36293 4.2298C9.36293 2.63939 8.07364 1.3501 6.48322 1.3501C4.8928 1.3501 3.60352 2.63939 3.60352 4.2298C3.60352 5.82022 4.8928 7.10951 6.48322 7.10951Z" stroke="#393B44" stroke-width="1.5" stroke-linecap="square"/>
                                <path d="M11.9805 7.10951C13.5709 7.10951 14.5984 5.82022 14.5984 4.2298C14.5984 2.63939 13.5709 1.3501 11.9805 1.3501" stroke="#393B44" stroke-width="1.5" stroke-linecap="square"/>
                                </g>
                                <defs>
                                <clipPath id="clip0_1165_20521">
                                <rect width="18" height="18" fill="white"/>
                                </clipPath>
                                </defs>
                                </svg>


                            <span class="text-sm">
                                <?php echo esc_html($guest_count); ?> people
                            </span>
                        </div>
                    <?php endif; ?>

                </div>

                <!-- Description + Read More -->
                <?php 
                $description = get_field('description'); 
                if ($description):
                ?>
                    <div x-data="{ expanded: false }" class="text-[#1C1C1C] leading-relaxed">

                        <!-- Truncated preview -->
                        <div x-show="!expanded">
                            <div class="line-clamp-3">
                                <?php echo wp_kses_post($description); ?>
                            </div>
                            <button 
                                @click="expanded = true" 
                                class="mt-2 text-[#1C1C1C] underline font-medium"
                            >
                                Read More
                            </button>
                        </div>

                        <!-- Full description -->
                        <div x-show="expanded" x-cloak>
                            <?php echo wp_kses_post($description); ?>
                            <button 
                                @click="expanded = false" 
                                class="mt-2 text-[#1C1C1C] underline font-medium"
                            >
                                Read Less
                            </button>
                        </div>

                    </div>
                <?php endif; ?>

            </section>