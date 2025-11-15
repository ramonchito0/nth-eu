(function ($) {

      window.ndsIsInViewport = function (el, percentVisible = 0.25) {
            const rect = el.getBoundingClientRect();
            const windowHeight = window.innerHeight || document.documentElement.clientHeight;

            // Element height
            const elementHeight = rect.height;

            // How much is visible in viewport
            const visibleTop = Math.max(0, 0 - rect.top);
            const visibleBottom = Math.max(0, rect.bottom - windowHeight);
            const visibleHeight = elementHeight - visibleTop - visibleBottom;

            return visibleHeight >= elementHeight * percentVisible;
      };

      function ndsSiteMenu(){

            $('#primary-menu-toggle').click(function(e){
                  e.preventDefault();
                  $(this).toggleClass('active');

                  $('body').toggleClass('nds-mobile-menu-open overflow-hidden');

                  let menuWrapper = $('.nds-mobile-menu-wrapper');
                  if ($('body').hasClass('nds-mobile-menu-open')){
                        let headerHeight = $('.nds-site-header').outerHeight() - 1;
                        //menuWrapper.css('top', headerHeight + 'px');
                  }
            });

            $('.nds-mobile-primary-menu > ul > li.menu-item-has-children > a[href="#"], .nds-mobile-primary-menu > ul > li.menu-item-has-children > a > .arrow').click(function(e){
                  e.preventDefault();
                  e.stopPropagation();

                  let parentItem = $(this).closest('.menu-item-has-children');

                  if(parentItem.hasClass('active')){
                        parentItem.removeClass('active');
                        parentItem.children('.sub-menu').slideUp(300);
                  } else {
                        $('.nds-mobile-menu-wrapper .menu-item-has-children').removeClass('active');
                        $('.nds-mobile-menu-wrapper .sub-menu').slideUp(300);
                  }

                  parentItem.addClass('active');
                  parentItem.children('.sub-menu').slideDown(300);
            });

            $('.nds-primary-menu a[data-identifier]').hover(
                  function () {
                        let $this = $(this);
                        currentMenuSlug = $this.data('identifier');

                        $('.nds-megamenu-item').hide();
                        $('#' + currentMenuSlug).css('display', 'flex');
                        setTimeout(function () {
                              $('#' + currentMenuSlug).addClass('active');
                        }, 300);

                        $('.nds-megamenu').addClass('active');

                        $this.closest('li').addClass('active');
                        $('body').addClass('nds-megamenu-open');
                  },
                  function () {
                        $(this).closest('li').removeClass('active');
                        $('body').removeClass('nds-megamenu-open');

                        //setTimeout(function () {
                              if (!$('.nds-megamenu').is(':hover')) {
                                    $('.nds-megamenu').removeClass('active');
                                    $('.nds-megamenu-item').removeClass('active');
                                    $('.nds-megamenu-item').hide();
                              }
                        //}, 100);
                  }
            );

            function closeMega() {
                  var $wrap = $('.nds-megamenu');

                  $wrap.removeClass('active');
                  $('body').removeClass('nds-megamenu-open'); 
                  $('.nds-primary-menu a[data-identifier]').closest('li').removeClass('active');
                  $('.nds-megamenu-item').stop(true, true).hide();

                  window.currentMenuSlug = null;
            }

            $('.nds-megamenu').hover(
                  function () {
                        $(this).addClass('active');

                        $('.nds-primary-menu a[data-identifier]').closest('li').removeClass('active');
                        $('.nds-primary-menu a[data-identifier="' + window.currentMenuSlug + '"]').closest('li').addClass('active');
                        $('#' + window.currentMenuSlug).addClass('active');

                  },
                  function () {
                        closeMega();
                  }
            );

            (function () {
                  var scrollTimer = null;
                  var didCloseThisScroll = false;

                  $(window).on('scroll.ndsMega wheel.ndsMega touchmove.ndsMega', function () {
                  if (!didCloseThisScroll) {     
                        didCloseThisScroll = true;
                        closeMega();
                  }
                  clearTimeout(scrollTimer);
                  scrollTimer = setTimeout(function () {
                        didCloseThisScroll = false; 
                  }, 150);
                  });
            })();

            
            // $(window).on('load resize', function() {
            //       var navHeight = $('.nds-main-nav').outerHeight();
            //       $('.nds-site-header').height(navHeight);
            // });

            $('.nds-mobile-primary-menu a[data-identifier]').on('click.ndsMobileMega', function(e) {
                  e.preventDefault();
                  
                  const $clickedLink = $(this);
                  const identifier = $clickedLink.data('identifier');
                  
                  if (!identifier) return;
                  
                  // Add active class to mobile megamenu wrapper
                  $('.nds-mobile-menu-wrapper').addClass('active');
                  $('.nds-mobile-megamenu').addClass('active');
                  
                  // Remove active class from all megamenu items
                  $('.nds-mobile-megamenu-item').removeClass('active');
                  
                  // Add active class to the matching megamenu item
                  $(`.nds-mobile-megamenu-item[data-identifier="${identifier}"]`).addClass('active');
                  
                  // Optional: Add active state to the clicked menu item
                  $('.nds-mobile-primary-menu a[data-identifier]').parent().removeClass('menu-active');
                  $clickedLink.parent().addClass('menu-active');
            });

            // Close mobile megamenu when clicking back button (if needed)
            $('.nds-mobile-megamenu-title').on('click.ndsMobileMegaClose', function() {
                  $('.nds-mobile-menu-wrapper').removeClass('active');
                  $('.nds-mobile-megamenu').removeClass('active');
                  $('.nds-mobile-megamenu-item').removeClass('active');
                  $('.nds-mobile-primary-menu li').removeClass('menu-active');
            });

      }

      window.ndsBlockSection = function (scope = document) {
            if (!scope.querySelector('.nds-lazyvideo')) return;

            let hasInteracted = false;

            function loadAndPlayVideos() {
                  $(scope).find('.nds-lazyvideo').each(function () {
                        let $el = $(this);

                        // YouTube iframe
                        if ($el.is('iframe') && $el.data('src')) {
                              let iframe = this;

                              if (!iframe.src) {
                                    iframe.src = $el.data('src');
                              }

                              if (window.YT && YT.Player) {
                                    new YT.Player(iframe, {
                                          events: {
                                                onReady: function (event) {
                                                      event.target.mute();
                                                      event.target.playVideo();
                                                }
                                          }
                                    });
                              }
                        }

                        // Local video
                        if ($el.is('video') && $el.data('src')) {
                              let video = this;

                              video.muted = true;
                              video.setAttribute('muted', ''); 
                              video.setAttribute('playsinline', ''); 

                              if (!$el.data('loaded')) {
                                    let source = document.createElement('source');
                                    source.src = $el.data('src');
                                    source.type = $el.data('type') || 'video/mp4';
                                    video.appendChild(source);
                                    $el.data('loaded', true);
                                    video.load();
                              }

                              video.play().catch(err => console.log('Video play error:', err));
                        }
                  });
            }

            function loadYouTubeAPI() {
                  if (typeof YT === 'undefined' || typeof YT.Player === 'undefined') {
                        let tag = document.createElement('script');
                        tag.src = "https://www.youtube.com/iframe_api";
                        let firstScriptTag = document.getElementsByTagName('script')[0];
                        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
                  }
            }

            function triggerOnce() {
                  if (!hasInteracted) {
                        hasInteracted = true;
                        loadAndPlayVideos();
                  }
            }

            // Load YT API in case YouTube videos exist
            if ($(scope).find('iframe.nds-lazyvideo[data-src]').length > 0) {
                  loadYouTubeAPI();
            }

            // Trigger on user interaction
            $(window).one('click scroll mousemove touchstart', triggerOnce);

            // Fallback autoplay after 8 seconds
            setTimeout(triggerOnce, 8000);
      }

      window.ndsYoutubeEmbed = function (scope = document) {
            // Exit early in WordPress admin/editor
            if (
            document.body.classList.contains('wp-admin') ||
            document.body.classList.contains('block-editor-page')
            ) {
                  return;
            }

            const $blocks = $(scope).find('.nds-youtube-embed');
            if (!$blocks.length) return;

            $blocks.each(function () {
                  const $block = $(this);
                  const $wrapper = $block.find('.yt-wrapper');
                  const $container = $block.find('.yt-container');
                  const videoId = $container.data('youtube-id');

                  if (!videoId) return;

                  const state = { loaded: false, played: false };

                  function loadYouTubeIframe(autoplay = false) {
                        if (state.loaded && (!autoplay || state.played)) return;

                        const params = [
                        `autoplay=${autoplay ? 1 : 0}`,
                        'enablejsapi=1',
                        'rel=0',
                        'playsinline=1',
                        'modestbranding=1',
                        'showinfo=0'
                        ].join('&');

                        const iframe = `
                        <iframe
                        src="https://www.youtube.com/embed/${videoId}?${params}"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen
                        class="w-full h-full"
                        ></iframe>
                        `;

                        $container.empty().html(iframe);
                        state.loaded = true;
                        if (autoplay) {
                        state.played = true;
                        $block.addClass('video-active');
                        }
                  }

                  function preloadIframe() {
                        if (!state.loaded) loadYouTubeIframe(false);
                  }

                  // Click-to-play per block
                  $wrapper.off('click.ndsYT').on('click.ndsYT', function () {
                        if (!state.played) loadYouTubeIframe(true);
                  });

                  // Smart, per-block preload when near viewport
                  if ('IntersectionObserver' in window) {
                        const io = new IntersectionObserver(
                        (entries) => {
                              entries.forEach((entry) => {
                                    if (entry.isIntersecting) {
                                          preloadIframe();
                                          io.unobserve(entry.target);
                                    }
                              });
                        },
                        { root: null, rootMargin: '300px 0px', threshold: 0.01 }
                        );
                        io.observe($block[0]);
                  } else {
                        // Fallback: user events & timeout (namespaced so multiple blocks don't collide)
                        const ns = '.ndsYT-' + Math.random().toString(36).slice(2);
                        const once = () => {
                              preloadIframe();
                              $(window).off(ns);
                        };
                        $(window).on('scroll' + ns + ' mousemove' + ns + ' touchstart' + ns, once);
                        setTimeout(once, 10000);
                  }

                  // Store controls for external usage (e.g., when slide changes)
                  $block.data('ndsYT', {
                        pause: () => {
                        const iframe = $container.find('iframe')[0];
                        if (iframe && iframe.contentWindow) {
                        iframe.contentWindow.postMessage(
                              JSON.stringify({ event: 'command', func: 'pauseVideo', args: [] }),
                              '*'
                        );
                        }
                        },
                        stop: () => {
                        $container.empty();
                        state.loaded = false;
                        state.played = false;
                        $block.removeClass('video-active');
                        }
                  });
            });
      };

      // Optional helpers: pause/stop all within a scope (e.g., the current slider)
      window.ndsYoutubePauseAll = function (scope = document) {
            $(scope).find('.nds-youtube-embed').each(function () {
                  $(this).data('ndsYT')?.pause();
            });
      };

      window.ndsYoutubeStopAll = function (scope = document) {
            $(scope).find('.nds-youtube-embed').each(function () {
                  $(this).data('ndsYT')?.stop();
            });
      };

      function ndsFooterDisclaimer() {
            function handleFooterClick() {
                  if ($(window).width() < 782) {
                        $('.nds-container-footer-disclaimer p:first-child').off('click.ndsFooter').on('click.ndsFooter', function() {
                              $('.nds-container-footer-disclaimer').toggleClass('active');
                        });
                  } else {
                        $('.nds-container-footer-disclaimer p:first-child').off('click.ndsFooter');
                        $('.nds-container-footer-disclaimer').removeClass('active');
                  }
            }

            handleFooterClick();
            $(window).on('resize', handleFooterClick);
      }

      window.ndsTeamMembers = function (scope = document) {
            const $scope = $(scope);

            // Team member description expand/collapse functionality
            function initTeamMemberExpand() {
                  $scope.find('.nds-btn-expand-description').off('click.ndsTeam').on('click.ndsTeam', function(e) {
                        e.preventDefault();
                        
                        const $button = $(this);
                        const $teamMemberItem = $button.closest('.nds-team-member-item');
                        
                        if (!$teamMemberItem.length) {
                              return;
                        }
                        
                        const $description = $teamMemberItem.find('.nds-team-member-description');
                        
                        if (!$description.length) {
                              return;
                        }
                        
                        const isExpanded = $teamMemberItem.hasClass('expanded');
                        
                        if (isExpanded) {
                              // Collapse
                              $description.css('max-height', $description[0].scrollHeight + 'px');
                              
                              // Force reflow
                              $description[0].offsetHeight;
                              
                              $description.css('max-height', '0px');
                              $teamMemberItem.removeClass('expanded');
                              
                              const expandText = $button.data('expand-text') || 'Read More';
                              $button.html('<span>' + expandText + '</span>');
                              $button.attr('aria-expanded', 'false');
                        } else {
                              // Expand
                              $teamMemberItem.addClass('expanded');
                              $description.css('max-height', $description[0].scrollHeight + 'px');
                              
                              const collapseText = $button.data('collapse-text') || 'Read Less';
                              $button.html('<span>' + collapseText + '</span>');
                              $button.attr('aria-expanded', 'true');
                              
                              // After transition ends, set to auto for dynamic content
                              setTimeout(() => {
                                    if ($teamMemberItem.hasClass('expanded')) {
                                          $description.css('max-height', 'none');
                                    }
                              }, 300);
                        }
                  });
            }

            // Initialize Swiper for team members
            function initTeamMemberSwiper() {
                  $scope.find('.nds-teams-featured .swiper').each(function() {
                        const $swiper = $(this);
                        const swiperId = $swiper.attr('id');
                        const blockContainer = $swiper.closest('.nds-teams-featured');
                        
                        if (!swiperId || $swiper.data('swiper-initialized')) {
                              return;
                        }

                        // Get columns from the closest block data attribute or default to 3
                        const $block = $swiper.closest('.nds-teams-featured');
                        const columns = $block.data('columns') || 3;
                        
                        const swiperInstance = new Swiper('#' + swiperId, {
                              slidesPerView: 1,
                              spaceBetween: 13,
                              loop: false,
                              navigation: {
                                    nextEl: blockContainer.find('.swiper-button-next')[0],
                                    prevEl: blockContainer.find('.swiper-button-prev')[0],
                              },
                              breakpoints: {
                                    781: {
                                          slidesPerView: 2,
                                          spaceBetween: 13,
                                    },
                                    1023: {
                                          slidesPerView: columns,
                                          spaceBetween: 13,
                                    }
                              },
                              speed: 1000,
                              effect: 'slide',
                              a11y: {
                                    enabled: true,
                                    prevSlideMessage: 'Previous team member',
                                    nextSlideMessage: 'Next team member',
                              }
                        });

                        // Mark as initialized to prevent double initialization
                        $swiper.data('swiper-initialized', true);
                        $swiper.data('swiper-instance', swiperInstance);
                  });
            }

            // Initialize Swiper for team members (grid)
            function initTeamMemberGridSwiper() {
                  $scope.find('.nds-teams-grid .swiper').each(function() {
                        const $swiper = $(this);
                        const swiperId = $swiper.attr('id');
                        const blockContainer = $swiper.closest('.nds-teams-grid');
                        
                        if (!swiperId || $swiper.data('swiper-initialized')) {
                              return;
                        }

                        const $block = $swiper.closest('.nds-teams-grid');
                        
                        const swiperInstance = new Swiper('#' + swiperId, {
                              slidesPerView: 1,
                              spaceBetween: 13,
                              loop: false,
                              navigation: {
                                    nextEl: blockContainer.find('.swiper-button-next')[0],
                                    prevEl: blockContainer.find('.swiper-button-prev')[0],
                              },
                              speed: 1000,
                              effect: 'slide',
                              a11y: {
                                    enabled: true,
                                    prevSlideMessage: 'Previous team member',
                                    nextSlideMessage: 'Next team member',
                              }
                        });

                        // Mark as initialized to prevent double initialization
                        $swiper.data('swiper-initialized', true);
                        $swiper.data('swiper-instance', swiperInstance);
                  });
            }

            // Initialize Swiper for team members
            function initTeamMemberLocationSwiper() {
                  $scope.find('.nds-teams-location .swiper').each(function() {
                        const $swiper = $(this);
                        const swiperId = $swiper.attr('id');
                        const blockContainer = $swiper.closest('.nds-teams-location');

                        if (!swiperId || $swiper.data('swiper-initialized')) {
                              return;
                        }

                        // Get columns from the closest block data attribute or default to 3
                        const $block = $swiper.closest('.nds-teams-location');
                        const columns = $block.data('columns') || 3;
                        
                        const swiperInstance = new Swiper('#' + swiperId, {
                              slidesPerView: 1,
                              spaceBetween: 13,
                              loop: false,
                              navigation: {
                                    nextEl: blockContainer.find('.swiper-button-next')[0],
                                    prevEl: blockContainer.find('.swiper-button-prev')[0],
                              },
                              breakpoints: {
                                    781: {
                                          slidesPerView: 2,
                                          spaceBetween: 13,
                                    },
                                    1023: {
                                          slidesPerView: columns,
                                          spaceBetween: 13,
                                    }
                              },
                              speed: 1000,
                              effect: 'slide',
                              a11y: {
                                    enabled: true,
                                    prevSlideMessage: 'Previous team member',
                                    nextSlideMessage: 'Next team member',
                              }
                        });

                        // Mark as initialized to prevent double initialization
                        $swiper.data('swiper-initialized', true);
                        $swiper.data('swiper-instance', swiperInstance);
                  });
            }

            // Initialize both functionalities
            initTeamMemberExpand();
            initTeamMemberSwiper();
            initTeamMemberGridSwiper();
            initTeamMemberLocationSwiper();
      };

      window.ndsTestimonials = function (scope = document) {
            const $scope = $(scope);

            // Initialize Swiper for testimonials
            function initTestimonialsSwiper() {
                  $scope.find('.nds-testimonials .testimonials-swiper').each(function() {
                        const $swiper = $(this);
                        const $block = $swiper.closest('.nds-testimonials');
                        const blockId = $block.data('block-id');
                        
                        if (!blockId || $swiper.data('swiper-initialized')) {
                              return;
                        }

                        // Get autoplay setting from block data attribute
                        const autoplay = $block.data('autoplay') || false;
                        const autoplayConfig = autoplay ? {
                              delay: 5000,
                              disableOnInteraction: false,
                        } : false;
                        
                        const swiperInstance = new Swiper($swiper[0], {
                              loop: true,
                              speed: 1500,
                              autoplay: autoplayConfig,
                              pagination: {
                                    el: $block.find('.swiper-pagination')[0],
                                    clickable: true
                              },
                              navigation: {
                                    nextEl: $block.find('.swiper-button-next')[0],
                                    prevEl: $block.find('.swiper-button-prev')[0]
                              },
                              // Accessibility
                              a11y: {
                                    enabled: true,
                                    prevSlideMessage: 'Previous testimonial',
                                    nextSlideMessage: 'Next testimonial',
                              },
                              // Smooth transitions
                              effect: 'slide',
                              // Keyboard control
                              keyboard: {
                                    enabled: true,
                                    onlyInViewport: true,
                              }
                        });

                        // Mark as initialized to prevent double initialization
                        $swiper.data('swiper-initialized', true);
                        $swiper.data('swiper-instance', swiperInstance);
                        
                        // Pause autoplay on hover if enabled
                        if (autoplay) {
                              $block.on('mouseenter.ndsTestimonials', function() {
                                    swiperInstance.autoplay.stop();
                              }).on('mouseleave.ndsTestimonials', function() {
                                    swiperInstance.autoplay.start();
                              });
                        }
                  });
            }

            // Initialize testimonials functionality
            initTestimonialsSwiper();
      };

      window.ndsTimelineSlider = function (scope = document) {
            const $scope = $(scope);

            // Initialize Swiper for timeline slider
            function initTimelineSwiper() {
                  $scope.find('.nds-timeline-slider .nds-timeline-slider-wrapper').each(function() {
                        const $swiper = $(this);
                        const $block = $swiper.closest('.nds-timeline-slider');
                        const blockId = $block.data('block-id');
                        
                        if (!blockId || $swiper.data('swiper-initialized')) {
                              return;
                        }

                        // Get configuration from data attributes
                        const itemsPerSlide = $block.data('items-per-slide') || 3;
                        const forceLineFullwidth = $block.data('force-line-fullwidth') || false;
                        
                        const swiperInstance = new Swiper($swiper[0], {
                              slidesPerView: 1,
                              spaceBetween: 34,
                              speed: 1500,
                              navigation: {
                                    nextEl: $block.find('.swiper-button-next')[0],
                                    prevEl: $block.find('.swiper-button-prev')[0]
                              },
                              breakpoints: {
                                    1023: {
                                          slidesPerView: "auto",
                                          spaceBetween: 120
                                    },
                                    782: {
                                          slidesPerView: 2,
                                          spaceBetween: 40
                                    }
                              },
                              // Accessibility
                              a11y: {
                                    enabled: true,
                                    prevSlideMessage: 'Previous timeline item',
                                    nextSlideMessage: 'Next timeline item',
                              },
                              // Keyboard control
                              keyboard: {
                                    enabled: true,
                                    onlyInViewport: true,
                              }
                        });

                        // Handle force line to fullwidth
                        if (forceLineFullwidth) {
                              $swiper.addClass('!overflow-visible');
                              $swiper.find('.swiper-wrapper').addClass('!overflow-visible');
                              
                              const $section = $block.closest('.section');
                              if ($section.length) {
                                    $section.addClass('overflow-hidden');
                              }
                        }

                        // Mark as initialized to prevent double initialization
                        $swiper.data('swiper-initialized', true);
                        $swiper.data('swiper-instance', swiperInstance);
                  });
            }

            // Initialize expand/collapse functionality
            function initTimelineExpand() {
                  $scope.find('.nds-timeline-slider .nds-expandable').each(function() {
                        const $slide = $(this);
                        const $shortText = $slide.find('.nds-timeline-slide-short-text');
                        const $expandContent = $slide.find('.nds-timeline-slide-expand-content');
                        
                        if (!$shortText.length || !$expandContent.length) {
                              return;
                        }

                        // Skip if already initialized
                        if ($shortText.data('expand-initialized')) {
                              return;
                        }

                        // Set up expand content for smooth transitions
                        $expandContent.css({
                              'transition': 'max-height 0.4s ease, opacity 0.3s ease',
                              'overflow': 'hidden',
                              'max-height': '0',
                              'opacity': '0'
                        }).removeClass('hidden');
                        
                        // Add click event with namespace
                        $shortText.off('click.ndsTimeline').on('click.ndsTimeline', function() {
                              if (!$slide.hasClass('expanded')) {
                                    // Expand
                                    $expandContent.css({
                                          'max-height': $expandContent[0].scrollHeight + 'px',
                                          'opacity': '1'
                                    });
                                    $slide.addClass('expanded');
                              } else {
                                    // Collapse
                                    $expandContent.css({
                                          'max-height': '0',
                                          'opacity': '0'
                                    });
                                    $slide.removeClass('expanded');
                              }
                        });

                        // Mark as initialized
                        $shortText.data('expand-initialized', true);
                  });
            }

      // Initialize both functionalities
      initTimelineSwiper();
      initTimelineExpand();
};

// FAQ Accordion Functionality
window.ndsFaqAccordion = function() {
      const SCOPE_SELECTOR = ".block-faqs"; // change to ".block-faqs .group" to scope per column
      const PER_GROUP = false; // set true if you want each .group independent

      function getScopes() {
            if (PER_GROUP) {
                  return Array.from(document.querySelectorAll(`${SCOPE_SELECTOR} .group`));
            }
            return Array.from(document.querySelectorAll(SCOPE_SELECTOR));
      }

      function attachListenerToDetail(detail, scopeRoot) {
            // ensure we don't attach twice
            if (detail.__faq_listener_attached) return;
            detail.__faq_listener_attached = true;

            detail.addEventListener("toggle", (e) => {
                  // only act when it opened (not when closed)
                  if (!detail.open) return;

                  // close other details in the same scope
                  const others = Array.from(scopeRoot.querySelectorAll("details"));
                  others.forEach((d) => {
                        if (d !== detail && d.open) {
                              // more reliable: set property instead of removing attribute
                              try {
                                    d.open = false;
                              } catch (err) {
                                    // fallback
                                    d.removeAttribute("open");
                              }
                        }
                  });
            });
      }

      function scanAndAttach() {
            const scopes = getScopes();
            scopes.forEach((scopeRoot) => {
                  const details = Array.from(scopeRoot.querySelectorAll("details"));
                  details.forEach((d) => attachListenerToDetail(d, scopeRoot));
            });
      }

      // Observe for dynamically inserted/updated details inside each scope
      function observeScopes() {
            const scopes = getScopes();
            scopes.forEach((scopeRoot) => {
                  // mark observed so we don't create multiple observers for same root
                  if (scopeRoot.__faq_observer_attached) return;
                  scopeRoot.__faq_observer_attached = true;

                  const mo = new MutationObserver((mutations) => {
                        mutations.forEach((m) => {
                              if (m.type === "childList") {
                                    m.addedNodes.forEach((node) => {
                                          if (!(node instanceof Element)) return;
                                          if (node.matches && node.matches("details")) {
                                                attachListenerToDetail(node, scopeRoot);
                                          } else {
                                                // if subtree contains details
                                                node.querySelectorAll && node.querySelectorAll("details").forEach((d) => attachListenerToDetail(d, scopeRoot));
                                          }
                                    });
                              }
                              if (m.type === "attributes" && m.target && m.target.matches && m.target.matches("details")) {
                                    // attribute changes on details — attach listener if not attached
                                    attachListenerToDetail(m.target, scopeRoot);
                              }
                        });
                  });

                  mo.observe(scopeRoot, { childList: true, subtree: true, attributes: true, attributeFilter: ["open"] });
            });
      }

      function init() {
            scanAndAttach();
            observeScopes();

            // Also monitor page for newly inserted scope containers (e.g., editor)
            const bodyObserver = new MutationObserver(() => {
                  scanAndAttach();
                  observeScopes();
            });
            bodyObserver.observe(document.body, { childList: true, subtree: true });
      }

      if (document.readyState === "loading") {
            document.addEventListener("DOMContentLoaded", init);
      } else {
            init();
      }
};

// Team Grid AJAX Filtering
window.ndsTeamGrid = function() {
      const $grids = $('.team-grid-wrapper');
      
      $grids.each(function() {
            const $wrapper = $(this);
            const $grid = $wrapper.find('.team-grid');
            const $filters = $wrapper.find('.team-filters select');
            const $loadingOverlay = $wrapper.find('.loading-overlay');
            
            // Store original grid items for mobile Swiper
            let originalItems = [];
            let swiperInstance = null;
            
            // Initialize Swiper for mobile if needed
            function initMobileSwiper() {
                  if (window.innerWidth <= 767 && !swiperInstance) {
                        originalItems = $grid.find('.team-member-item').toArray();
                        
                        // Convert grid to swiper structure
                        $grid.addClass('swiper-container');
                        const $wrapper = $('<div class="swiper-wrapper"></div>');
                        
                        $grid.find('.team-member-item').each(function() {
                              $(this).wrap('<div class="swiper-slide"></div>');
                        });
                        
                        $grid.wrapInner($wrapper);
                        
                        // Initialize Swiper
                        swiperInstance = new Swiper($grid[0], {
                              slidesPerView: 1.2,
                              spaceBetween: 20,
                              breakpoints: {
                                    480: {
                                          slidesPerView: 1.5,
                                          spaceBetween: 24
                                    }
                              }
                        });
                  }
            }
            
            // Destroy Swiper for desktop
            function destroyMobileSwiper() {
                  if (swiperInstance) {
                        swiperInstance.destroy(true, true);
                        swiperInstance = null;
                        
                        // Restore original grid structure
                        $grid.removeClass('swiper-container');
                        $grid.find('.swiper-slide').each(function() {
                              $(this).replaceWith($(this).contents());
                        });
                        $grid.find('.swiper-wrapper').replaceWith($grid.find('.swiper-wrapper').contents());
                  }
            }
            
            // Initialize Team Slider Swiper
            function initTeamSliderSwiper() {
                  const $sliderContainer = $wrapper.find('.nds-team-slider-container');
                  if (!$sliderContainer.length) return;
                  
                  $sliderContainer.find('.swiper').each(function() {
                        const $swiper = $(this);
                        const swiperId = $swiper.attr('id');
                        
                        if (!swiperId) {
                              return;
                        }
                        
                        // Destroy existing instance if it exists
                        if ($swiper.data('swiper-initialized')) {
                              const existingInstance = $swiper.data('swiper-instance');
                              if (existingInstance && existingInstance.destroy) {
                                    existingInstance.destroy(true, true);
                              }
                              $swiper.removeData('swiper-initialized');
                              $swiper.removeData('swiper-instance');
                        }
                        
                        const swiperInstance = new Swiper('#' + swiperId, {
                              slidesPerView: 1,
                              spaceBetween: 24,
                              loop: false,
                              navigation: {
                                    nextEl: $sliderContainer.find('.swiper-button-next')[0],
                                    prevEl: $sliderContainer.find('.swiper-button-prev')[0],
                              },
                              breakpoints: {
                                    768: {
                                          slidesPerView: 3,
                                          spaceBetween: 24,
                                    },
                                    1024: {
                                          slidesPerView: 4,
                                          spaceBetween: 24,
                                    }
                              },
                              speed: 1000,
                              effect: 'slide',
                              a11y: {
                                    enabled: true,
                                    prevSlideMessage: 'Previous team member',
                                    nextSlideMessage: 'Next team member',
                              },

                        });
                        
                        // Mark as initialized to prevent double initialization
                        $swiper.data('swiper-initialized', true);
                        $swiper.data('swiper-instance', swiperInstance);
                  });
            }
            
            // Handle filter changes
            $filters.on('change', function() {
                  // Show loading overlay
                  $loadingOverlay.removeClass('hidden').addClass('flex');
                  
                  // Collect all filter values
                  const filterData = {};
                  $filters.each(function() {
                        const name = $(this).attr('name');
                        const value = $(this).val();
                        if (value && value !== '') {
                              filterData[name] = value;
                        }
                  });
                  
                  // Get block attributes
                  const blockData = $wrapper.data();
                  
                  // Check if AJAX is available
                  if (typeof nds_ajax === 'undefined') {
                        $loadingOverlay.removeClass('flex').addClass('hidden');
                        return;
                  }
                  
                  // AJAX request
                  $.ajax({
                        url: nds_ajax.ajax_url,
                        type: 'POST',
                        data: {
                              action: 'filter_team_grid',
                              nonce: nds_ajax.team_nonce,
                              filters: filterData,
                              posts_per_page: blockData.postsPerPage || 12,
                              show_excerpt: blockData.showExcerpt || false,
                              show_location: blockData.showLocation || false,
                              excerpt_words: blockData.excerptWords || 25,
                              enable_grid: blockData.enableGrid !== false,
                              grid_category: blockData.gridCategory || null,
                              enable_slider: blockData.enableSlider !== false,
                              slider_category: blockData.sliderCategory || null,
                              booking_link: blockData.bookingLink || null
                        },
                        success: function(response) {
                              if (response.success) {
                                    // Destroy current Swiper if exists
                                    destroyMobileSwiper();
                                    
                                    // Update desktop grid content
                                    $grid.html(response.data.html);
                                    
                                    // Update mobile swiper content
                                    const $mobileSwiper = $wrapper.find('.nds-team-members-slider .swiper-wrapper');
                                    if ($mobileSwiper.length && response.data.mobile_html) {
                                          $mobileSwiper.html(response.data.mobile_html);
                                    }
                                    
                                    // Update team slider content if it exists
                                    const $teamSliderWrapper = $wrapper.find('.nds-team-slider-container .swiper-wrapper');
                                    if ($teamSliderWrapper.length && response.data.slider_html) {
                                          $teamSliderWrapper.html(response.data.slider_html);
                                    }
                                    
                                    // Re-initialize team member expand functionality for new content
                                    if (typeof ndsTeamMembers === 'function') {
                                          ndsTeamMembers($wrapper[0]);
                                    }
                                    
                                    // Re-initialize team slider swiper
                                    initTeamSliderSwiper();
                                    
                                    // Re-initialize mobile Swiper if needed
                                    setTimeout(() => {
                                          initMobileSwiper();
                                          $loadingOverlay.removeClass('flex').addClass('hidden');
                                    }, 100);
                              }
                        },
                        error: function() {
                              $loadingOverlay.removeClass('flex').addClass('hidden');
                              console.error('Team grid filter error');
                        }
                  });
            });
            
            // Handle resize
            $(window).on('resize', function() {
                  if (window.innerWidth <= 767) {
                        initMobileSwiper();
                  } else {
                        destroyMobileSwiper();
                  }
            });
            
            // Initialize on load
            initMobileSwiper();
            initTeamSliderSwiper();
      });
};

// Articles Archive AJAX Filtering and Pagination
window.ndsArticlesArchive = function() {
      const $archives = $('.nds-articles-archive');
      
      $archives.each(function() {
            const $wrapper = $(this);
            const $grid = $wrapper.find('.nds-articles-archive-posts-grid');
            const $categoryFilter = $wrapper.find('[data-filter="category"]');
            const $searchInput = $wrapper.find('[data-filter="search"]');
            const $searchForm = $wrapper.find('.nds-articles-search-form');
            const $loadMoreBtn = $wrapper.find('.nds-load-more-btn');
            const $loadingOverlay = $wrapper.find('.loading-overlay');
            
            let currentPage = 1;
            let currentCategory = '';
            let currentSearch = '';
            let isLoading = false;
            
            // Get block data
            const postsPerPage = parseInt($wrapper.data('posts-per-page')) || 6;
            
            // Handle category filter change
            $categoryFilter.on('change', function() {
                  if (isLoading) return;
                  
                  currentCategory = $(this).val();
                  currentPage = 1;
                  loadPosts(false); // Replace content
            });
            
            // Handle search form submission
            $searchForm.on('submit', function(e) {
                  e.preventDefault();
                  if (isLoading) return;
                  
                  currentSearch = $searchInput.val();
                  currentPage = 1;
                  loadPosts(false); // Replace content
            });
            
            // Handle search input changes (optional: real-time search)
            let searchTimeout;
            $searchInput.on('input', function() {
                  if (isLoading) return;
                  
                  clearTimeout(searchTimeout);
                  searchTimeout = setTimeout(() => {
                        currentSearch = $(this).val();
                        currentPage = 1;
                        loadPosts(false); // Replace content
                  }, 500); // Debounce for 500ms
            });
            
            // Handle load more button
            $loadMoreBtn.on('click', function() {
                  if (isLoading) return;
                  
                  currentPage++;
                  loadPosts(true); // Append content
            });
            
            function loadPosts(loadMore = false) {
                  if (isLoading) return;
                  
                  isLoading = true;
                  
                  // Show loading state
                  if (loadMore) {
                        $loadMoreBtn.text('Loading...').prop('disabled', true);
                  } else {
                        $loadingOverlay.removeClass('hidden').addClass('flex');
                  }
                  
                  // Check if AJAX is available
                  if (typeof nds_ajax === 'undefined') {
                        console.error('nds_ajax object not found');
                        resetLoadingState();
                        return;
                  }
                  
                  // AJAX request
                  $.ajax({
                        url: nds_ajax.ajax_url,
                        type: 'POST',
                        data: {
                              action: 'filter_articles_archive',
                              nonce: nds_ajax.articles_nonce,
                              category: currentCategory,
                              search: currentSearch,
                              page: currentPage,
                              posts_per_page: postsPerPage,
                              load_more: loadMore
                        },
                        success: function(response) {
                              if (response.success) {
                                    if (loadMore) {
                                          // Append new posts
                                          $grid.append(response.data.html);
                                    } else {
                                          // Replace all posts
                                          $grid.html(response.data.html);
                                    }
                                    
                                    // Update load more button visibility
                                    if (response.data.has_more) {
                                          $loadMoreBtn.parent().show();
                                    } else {
                                          $loadMoreBtn.parent().hide();
                                    }
                              } else {
                                    console.error('Articles filter error:', response.data);
                              }
                              
                              resetLoadingState();
                        },
                        error: function(xhr, status, error) {
                              console.error('Articles filter AJAX error:', error);
                              resetLoadingState();
                        }
                  });
            }
            
            function resetLoadingState() {
                  isLoading = false;
                  $loadingOverlay.removeClass('flex').addClass('hidden');
                  $loadMoreBtn.text('Load More +').prop('disabled', false);
            }
      });
};

// Simple Google Map Display
window.ndsSimpleGoogleMap = function() {
      const $maps = $('.nds-google-map-simple');
      
      $maps.each(function() {
            const $mapContainer = $(this);
            const blockId = $mapContainer.data('block-id');
            
            let map = null;
            let markers = [];
            let geocoder = null;
            let infoWindow = null;
            let allLocations = [];
            
            // Get locations data from the map container
            try {
                  allLocations = JSON.parse($mapContainer.attr('data-locations') || '[]');
            } catch (e) {
                  console.error('Error parsing locations data:', e);
                  allLocations = [];
            }
            
            // Initialize Google Map
            function initMap() {
                  if (!window.google || !window.google.maps) {
                        console.error('Google Maps not loaded');
                        return;
                  }
                  
                  const mapOptions = {
                        zoom: 6,
                        center: { lat: 52.3676, lng: 4.9041 }, // Netherlands center
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        styles: [
                              {
                                    "featureType": "water",
                                    "elementType": "geometry",
                                    "stylers": [{"color": "#e9e9e9"}, {"lightness": 17}]
                              },
                              {
                                    "featureType": "landscape",
                                    "elementType": "geometry",
                                    "stylers": [{"color": "#f5f5f5"}, {"lightness": 20}]
                              }
                        ]
                  };
                  
                  map = new google.maps.Map($mapContainer[0], mapOptions);
                  geocoder = new google.maps.Geocoder();
                  infoWindow = new google.maps.InfoWindow();
                  
                  // Add markers for all locations
                  addLocationMarkers(allLocations);
            }
            
            // Add markers to the map
            function addLocationMarkers(locations) {
                  clearMarkers();
                  
                  if (locations.length === 0) return;
                  
                  let markersAdded = 0;
                  const totalLocations = locations.length;
                  
                  locations.forEach((location, index) => {
                        geocodeAddress(location.full_address, location, index, () => {
                              markersAdded++;
                              // When all markers are added, fit the bounds
                              if (markersAdded === totalLocations) {
                                    fitMapBounds();
                              }
                        });
                  });
            }
            
            // Geocode address and add marker
            function geocodeAddress(address, locationData, index, callback) {
                  if (!geocoder) {
                        if (callback) callback();
                        return;
                  }
                  
                  geocoder.geocode({ address: address }, (results, status) => {
                        if (status === 'OK' && results[0]) {
                              const position = results[0].geometry.location;
                              
                              // Determine marker size based on is_hq field
                              const markerScale = locationData.is_hq ? 1.25 : 0.75;
                              
                              const marker = new google.maps.Marker({
                                    position: position,
                                    map: map,
                                    title: locationData.title,
                                    animation: google.maps.Animation.DROP,
                                    icon: {
                                          url: '/wp-content/uploads/2025/11/icon-pin-4.png',
                                          scaledSize: new google.maps.Size(32 * markerScale, 32 * markerScale),
                                          anchor: new google.maps.Point(16 * markerScale, 32 * markerScale)
                                    }
                              });
                              
                              // Create info window content
                              const infoContent = `
                                    <div class="nds-map-info-window">
                                          <p class="text-sm font-normal">${locationData.name}</p>
                                          <p class="text-sm">${locationData.address}</p>
                                          <p class="text-sm">${locationData.postcode}</p>
                                          ${locationData.phone_number ? `<p class="text-sm">Phone: ${locationData.phone_number}</p>` : ''}
                                    </div>
                              `;
                              
                              // Add click listener to marker
                              marker.addListener('click', () => {
                                    infoWindow.setContent(infoContent);
                                    infoWindow.open(map, marker);
                              });
                              
                              markers.push(marker);
                              
                              // Store location data with marker
                              marker.locationData = locationData;
                        } else {
                              console.error('Geocoding failed for address:', address, status);
                        }
                        
                        // Always call callback, even if geocoding failed
                        if (callback) callback();
                  });
            }
            
            // Fit map bounds to show all markers
            function fitMapBounds() {
                  if (!map || markers.length === 0) return;
                  
                  if (markers.length === 1) {
                        // If only one marker, center on it and set appropriate zoom
                        map.setCenter(markers[0].getPosition());
                        map.setZoom(12);
                  } else {
                        // Multiple markers - fit bounds with padding
                        const bounds = new google.maps.LatLngBounds();
                        markers.forEach(marker => bounds.extend(marker.getPosition()));
                        
                        // Fit bounds with padding
                        map.fitBounds(bounds, {
                              top: 50,
                              right: 50,
                              bottom: 50,
                              left: 50
                        });
                        
                        // Ensure minimum zoom level (avoid zooming in too much)
                        google.maps.event.addListenerOnce(map, 'bounds_changed', () => {
                              if (map.getZoom() > 15) {
                                    map.setZoom(15);
                              }
                        });
                  }
            }
            
            // Clear all markers
            function clearMarkers() {
                  markers.forEach(marker => {
                        marker.setMap(null);
                  });
                  markers = [];
            }
            
            // Initialize map when Google Maps is loaded
            function waitForGoogleMaps() {
                  if (window.google && window.google.maps) {
                        initMap();
                  } else {
                        setTimeout(waitForGoogleMaps, 100);
                  }
            }
            
            // Start initialization
            waitForGoogleMaps();
      });
};

// Locations Search with Google Maps
window.ndsLocationsSearch = function() {
      const $locators = $('.nds-locations-search');
      
      $locators.each(function() {
            const $wrapper = $(this);
            const $searchForm = $wrapper.find('.nds-postcode-search-form');
            const $searchInput = $wrapper.find('.nds-postcode-input');
            const $clearBtn = $wrapper.find('.nds-clear-search-btn');
            const $locationsList = $wrapper.find('.nds-locations-container');
            const $resultsCount = $wrapper.find('.nds-results-count');
            const $resultsText = $wrapper.find('.nds-results-text');
            const $loadingOverlay = $wrapper.find('.nds-loading-overlay');
            const $mapContainer = $wrapper.find('.nds-google-map');
            
            let map = null;
            let markers = [];
            let geocoder = null;
            let infoWindow = null;
            let allLocations = [];
            let filteredLocations = [];
            let radiusKm = null;
            let allLocationsGeocoded = false;
            
            // Get locations data and radius from the map container
            try {
                  allLocations = JSON.parse($mapContainer.attr('data-locations') || '[]');
                  filteredLocations = [...allLocations];
                  radiusKm = parseInt($mapContainer.attr('data-radius')) || null;
            } catch (e) {
                  console.error('Error parsing locations data:', e);
                  allLocations = [];
                  filteredLocations = [];
            }
            
            // Initialize Google Map
            function initMap() {
                  if (!window.google || !window.google.maps) {
                        console.error('Google Maps not loaded');
                        return;
                  }
                  
                  const mapOptions = {
                        zoom: 6,
                        center: { lat: 52.3676, lng: 4.9041 }, // Netherlands center
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        styles: [
                              {
                                    "featureType": "water",
                                    "elementType": "geometry",
                                    "stylers": [{"color": "#e9e9e9"}, {"lightness": 17}]
                              },
                              {
                                    "featureType": "landscape",
                                    "elementType": "geometry",
                                    "stylers": [{"color": "#f5f5f5"}, {"lightness": 20}]
                              }
                        ]
                  };
                  
                  map = new google.maps.Map($mapContainer[0], mapOptions);
                  geocoder = new google.maps.Geocoder();
                  infoWindow = new google.maps.InfoWindow();
                  
                  // Add markers for all locations
                  addLocationMarkers(filteredLocations);
            }
            
            // Add markers to the map
            function addLocationMarkers(locations) {
                  clearMarkers();
                  
                  if (locations.length === 0) return;
                  
                  let markersAdded = 0;
                  const totalLocations = locations.length;
                  
                  locations.forEach((location, index) => {
                        geocodeAddress(location.full_address, location, index, () => {
                              markersAdded++;
                              // When all markers are added, fit the bounds
                              if (markersAdded === totalLocations) {
                                    fitMapBounds();
                                    allLocationsGeocoded = true;
                                    console.log('All locations have been geocoded:', allLocations.length);
                              }
                        });
                  });
            }
            
            // Geocode address and add marker
            function geocodeAddress(address, locationData, index, callback) {
                  if (!geocoder) {
                        if (callback) callback();
                        return;
                  }
                  
                  geocoder.geocode({ address: address }, (results, status) => {
                        if (status === 'OK' && results[0]) {
                              const position = results[0].geometry.location;
                              
                              // Store coordinates in the original location data for distance calculations
                              // Find the matching location in allLocations array and update it
                              const originalLocation = allLocations.find(loc => 
                                    loc.id === locationData.id && 
                                    loc.full_address === locationData.full_address
                              );
                              
                              if (originalLocation) {
                                    originalLocation.coordinates = {
                                          lat: position.lat(),
                                          lng: position.lng()
                                    };
                              }
                              
                              // Also store in current locationData
                              locationData.coordinates = {
                                    lat: position.lat(),
                                    lng: position.lng()
                              };
                              
                              const marker = new google.maps.Marker({
                                    position: position,
                                    map: map,
                                    title: locationData.title,
                                    animation: google.maps.Animation.DROP
                              });
                              
                              // Create info window content
                              const infoContent = `
                                    <div class="nds-map-info-window">
                                          <p class="text-sm font-normal">${locationData.title}</p>
                                          <p class="text-sm">${locationData.address}</p>
                                          <p class="text-sm">${locationData.postcode}</p>
                                          ${locationData.distance ? `<p class="hidden">${locationData.distance}km away</p>` : ''}
                                    </div>
                              `;
                              
                              // Add click listener to marker
                              marker.addListener('click', () => {
                                    infoWindow.setContent(infoContent);
                                    infoWindow.open(map, marker);
                                    
                                    // Highlight corresponding list item using unique ID
                                    highlightLocationItem(locationData.id + '_' + index);
                              });
                              
                              markers.push(marker);
                              
                              // Store location data with marker
                              marker.locationData = locationData;
                              marker.locationIndex = index;
                              marker.uniqueLocationId = locationData.id + '_' + index;
                        } else {
                              console.error('Geocoding failed for address:', address, status);
                        }
                        
                        // Always call callback, even if geocoding failed
                        if (callback) callback();
                  });
            }
            
            // Fit map bounds to show all markers
            function fitMapBounds() {
                  if (!map || markers.length === 0) return;
                  
                  if (markers.length === 1) {
                        // If only one marker, center on it and set appropriate zoom
                        map.setCenter(markers[0].getPosition());
                        map.setZoom(12);
                  } else {
                        // Multiple markers - fit bounds with padding
                        const bounds = new google.maps.LatLngBounds();
                        markers.forEach(marker => bounds.extend(marker.getPosition()));
                        
                        // Fit bounds with padding
                        map.fitBounds(bounds, {
                              top: 50,
                              right: 50,
                              bottom: 50,
                              left: 50
                        });
                        
                        // Ensure minimum zoom level (avoid zooming in too much)
                        google.maps.event.addListenerOnce(map, 'bounds_changed', () => {
                              if (map.getZoom() > 15) {
                                    map.setZoom(15);
                              }
                        });
                  }
            }
            
            // Clear all markers
            function clearMarkers() {
                  markers.forEach(marker => {
                        marker.setMap(null);
                  });
                  markers = [];
            }
            
            // Calculate distance between two coordinates using Haversine formula
            function calculateDistance(lat1, lng1, lat2, lng2) {
                  const R = 6371; // Earth's radius in kilometers
                  const dLat = (lat2 - lat1) * Math.PI / 180;
                  const dLng = (lng2 - lng1) * Math.PI / 180;
                  const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                            Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                            Math.sin(dLng / 2) * Math.sin(dLng / 2);
                  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                  return R * c; // Distance in kilometers
            }
            
            // Filter locations by radius from search coordinates
            function filterLocationsByRadius(searchLat, searchLng, locations) {
                  if (!radiusKm || !searchLat || !searchLng) {
                        console.log('Radius filtering skipped - radiusKm:', radiusKm, 'searchLat:', searchLat, 'searchLng:', searchLng);
                        return locations;
                  }
                  
                  console.log(`Filtering locations within ${radiusKm}km of`, searchLat, searchLng);
                  console.log('Total locations to check:', locations.length);
                  
                  const filteredResults = locations.filter(location => {
                        if (!location.coordinates) {
                              console.log(`Location ${location.title} has no coordinates, skipping`);
                              return false;
                        }
                        
                        const distance = calculateDistance(
                              searchLat, 
                              searchLng, 
                              location.coordinates.lat, 
                              location.coordinates.lng
                        );
                        
                        location.distance = Math.round(distance * 10) / 10; // Round to 1 decimal place
                        const withinRadius = distance <= radiusKm;
                        
                        console.log(`${location.title}: ${distance.toFixed(1)}km away - ${withinRadius ? 'INCLUDED' : 'EXCLUDED'}`);
                        
                        return withinRadius;
                  });
                  
                  console.log(`Radius filtering complete: ${filteredResults.length} locations within ${radiusKm}km`);
                  return filteredResults;
            }
            
            // Highlight location item in the list
            function highlightLocationItem(locationId) {
                  $locationsList.find('.nds-location-item').removeClass('active');
                  $locationsList.find(`[data-location-id="${locationId}"]`).addClass('active');
            }
            
            // Filter locations by postcode
            function filterLocationsByPostcode(searchPostcode) {
                  if (!searchPostcode) {
                        return allLocations;
                  }
                  
                  const search = searchPostcode.toLowerCase().replace(/\s+/g, '');
                  
                  return allLocations.filter(location => {
                        const locationPostcode = location.postcode.toLowerCase().replace(/\s+/g, '');
                        const locationAddress = location.address.toLowerCase();
                        
                        // Match postcode or address
                        return locationPostcode.includes(search) || 
                               locationAddress.includes(searchPostcode.toLowerCase());
                  });
            }
            
            // Update locations display
            function updateLocationsDisplay(locations, searchContext = null) {
                  filteredLocations = locations;
                  
                  // Update results count and text based on search context
                  $resultsCount.text(locations.length);
                  $resultsCount.removeClass('hidden');
                  
                  if (searchContext && searchContext.postcode) {
                        $resultsText.text('Offices near');
                        $resultsCount.text(`${searchContext.cityTown ? searchContext.cityTown + ', ' : ''}${searchContext.postcode}`);
                  } else {
                        $resultsText.text('Offices');
                        $resultsCount.addClass('hidden');
                  }
                  
                  // Update locations list
                  if (locations.length === 0) {
                        $locationsList.html(`
                              <div class="nds-no-locations py-8">
                                    <p class="">Please try a different postcode or clear your search.</p>
                              </div>
                        `);
                  } else {
                        let listHtml = '';
                        locations.forEach((location, index) => {
                              listHtml += `
                                    <div class="nds-location-item border-t border-solid border-primary cursor-pointer pt-[2.1875rem] max-lg:first:pt-0 max-lg:first:border-t-0"
                                         data-location-id="${location.id}_${index}"
                                         data-address="${location.full_address}"
                                         data-postcode="${location.postcode}"
                                         data-index="${index}">

                                          <p class="!mb-[3.375rem] font-normal max-lg:!mb-7">${location.title}</p>
                                          <div class="mb-[4.5rem] flex flex-col gap-[1.375rem] max-lg:mb-[2.125rem]">
                                                ${location.full_address ? `
                                                      <div class="flex gap-2 max-w-[18.75rem]">
                                                            <span class="shrink-0 transform translate-y-[.3125rem] max-md:translate-y-[-.375rem]">
                                                                  <svg xmlns="http://www.w3.org/2000/svg" width="16.383" height="22.44" viewBox="0 0 16.383 22.44">
                                                                        <g id="Group_80" data-name="Group 80" transform="translate(-968 -1322)">
                                                                              <path id="Path_53" data-name="Path 53" d="M8.192,0a8.192,8.192,0,0,1,8.192,8.192c0,4.524-7.479,14.108-8.192,14.247S0,12.716,0,8.192A8.192,8.192,0,0,1,8.192,0Z" transform="translate(968 1322)" fill="#eba380"/>
                                                                              <circle id="Ellipse_56" data-name="Ellipse 56" cx="3.5" cy="3.5" r="3.5" transform="translate(972.692 1327.469)" fill="#fff"/>
                                                                        </g>
                                                                  </svg>
                                                            </span>
                                                            <span>${location.full_address}</span>
                                                      </div>
                                                ` : ''}
                                                ${location.phone_number ? `
                                                      <div class="flex gap-[1.125rem]">
                                                            <span class="shrink-0 transform translate-y-2 max-md:translate-y-[-.375rem]">
                                                                  <svg xmlns="http://www.w3.org/2000/svg" width="16.508" height="16.469" viewBox="0 0 16.508 16.469">
                                                                        <path id="Path_47" data-name="Path 47" d="M22.258,18.514a3.782,3.782,0,0,1-3.817,3.724A12.693,12.693,0,0,1,5.75,9.56,3.8,3.8,0,0,1,9.54,5.77a3.331,3.331,0,0,1,.634.053,3.134,3.134,0,0,1,.607.145.839.839,0,0,1,.528.634l1.123,4.939a.809.809,0,0,1-.211.753,8.307,8.307,0,0,1-1.123.647,8.137,8.137,0,0,0,4,4.028c.528-1.03.541-1.043.66-1.136a.809.809,0,0,1,.753-.211l4.939,1.123a.873.873,0,0,1,.607.528,4.553,4.553,0,0,1,.158.607A5.106,5.106,0,0,1,22.258,18.514Z" transform="translate(-5.75 -5.77)" fill="#eba380"/>
                                                                  </svg>
                                                            </span>
                                                            <span class="[&_a]:!no-underline">${location.phone_number}</span>
                                                      </div>
                                                ` : ''}
                                                ${location.distance ? `
                                                      <div class="flex gap-2 hidden">
                                                            <span class="shrink-0">📍</span>
                                                            <span>${location.distance}km away</span>
                                                      </div>
                                                ` : ''}
                                          </div>
                                          <div class="flex gap-[6.125rem] max-md:gap-5 max-md:justify-between max-xxs:flex-col max-xxs:gap-5">
                                                <a href="${location.permalink}" class=" nds-btn-plain">Office Details</a>
                                                ${location.booking_link && location.booking_link.url ? `
                                                      <a href="${location.booking_link.url}" class="nds-btn-plain">${location.booking_link.title || 'Book Now'}</a>
                                                ` : ''}
                                          </div>
                                    </div>
                              `;
                        });
                        $locationsList.html(listHtml);
                  }
                  
                  // Update map markers
                  if (map) {
                        addLocationMarkers(locations);
                  }
            }
            
            // Search by postcode
            function searchByPostcode(postcode) {
                  $loadingOverlay.removeClass('hidden');
                  
                  if (!postcode.trim()) {
                        // If empty search, show all locations
                        updateLocationsDisplay(allLocations);
                        $loadingOverlay.addClass('hidden');
                        return;
                  }
                  
                  // Simulate search delay for better UX
                  setTimeout(() => {
                        const results = filterLocationsByPostcode(postcode);
                        
                        // If geocoder is available, try to get city/town name
                        if (geocoder) {
                              geocoder.geocode({ address: postcode }, (geocodeResults, status) => {
                                    let searchContext = { postcode: postcode };
                                    
                                    if (status === 'OK' && geocodeResults[0]) {
                                          // Extract city/town from address components
                                          const addressComponents = geocodeResults[0].address_components;
                                          let cityTown = '';
                                          
                                          // Look for locality, postal_town, or administrative_area_level_2
                                          for (let component of addressComponents) {
                                                if (component.types.includes('locality') || 
                                                    component.types.includes('postal_town') ||
                                                    component.types.includes('administrative_area_level_2')) {
                                                      cityTown = component.long_name;
                                                      break;
                                                }
                                          }
                                          
                                          searchContext.cityTown = cityTown;
                                          
                                          // Apply radius filtering if radius is set
                                          let finalResults = results;
                                          if (radiusKm) {
                                                console.log('Applying radius filtering...');
                                                
                                                // Wait for all locations to be geocoded
                                                const waitForGeocoding = () => {
                                                      if (allLocationsGeocoded) {
                                                            console.log('All locations geocoded, proceeding with radius filtering');
                                                            const searchPosition = geocodeResults[0].geometry.location;
                                                            // Apply radius filtering to ALL locations, not just postcode matches
                                                            finalResults = filterLocationsByRadius(
                                                                  searchPosition.lat(), 
                                                                  searchPosition.lng(), 
                                                                  allLocations // Use ALL locations for radius filtering
                                                            );
                                                            
                                                            updateLocationsDisplay(finalResults, searchContext);
                                                            $loadingOverlay.addClass('hidden');
                                                      } else {
                                                            console.log('Waiting for geocoding to complete...');
                                                            setTimeout(waitForGeocoding, 500);
                                                      }
                                                };
                                                
                                                waitForGeocoding();
                                                return; // Don't execute the rest of the function
                                          }                                          // Center map on searched area if results found
                                          if (finalResults.length > 0 && map) {
                                                map.setCenter(geocodeResults[0].geometry.location);
                                                map.setZoom(10);
                                          }
                                    
                                          updateLocationsDisplay(finalResults, searchContext);
                                    } else {
                                          // If geocoding failed, just show postcode results without radius filtering
                                          updateLocationsDisplay(results, searchContext);
                                    }
                                    
                                    $loadingOverlay.addClass('hidden');
                              });
                        } else {
                              // Fallback if no geocoder
                              updateLocationsDisplay(results, { postcode: postcode });
                              $loadingOverlay.addClass('hidden');
                        }
                  }, 300);
            }
            
            // Event Handlers
            
            // Handle form submission
            $searchForm.on('submit', function(e) {
                  e.preventDefault();
                  const postcode = $searchInput.val().trim();
                  searchByPostcode(postcode);
            });
            
            // Handle clear search
            $clearBtn.on('click', function() {
                  $searchInput.val('');
                  updateLocationsDisplay(allLocations);
            });
            
            // Handle location item click
            $wrapper.on('click', '.nds-location-item', function() {
                  const $item = $(this);
                  const locationId = $item.data('location-id');
                  const address = $item.data('address');
                  
                  // Highlight clicked item
                  highlightLocationItem(locationId);
                  
                  // Find and focus corresponding marker
                  const marker = markers.find(m => m.uniqueLocationId === locationId);
                  if (marker && map) {
                        map.setCenter(marker.getPosition());
                        map.setZoom(12);
                        
                        // Trigger marker click to show info window
                        google.maps.event.trigger(marker, 'click');
                  }
            });
            
            // Real-time search (optional)
            let searchTimeout;
            $searchInput.on('input', function() {
                  const value = $(this).val().trim();
                  
                  clearTimeout(searchTimeout);
                  searchTimeout = setTimeout(() => {
                        if (value.length >= 2 || value.length === 0) {
                              searchByPostcode(value);
                        }
                  }, 500);
            });
            
            // Initialize map when Google Maps is loaded
            function waitForGoogleMaps() {
                  if (window.google && window.google.maps) {
                        initMap();
                  } else {
                        // Wait for Google Maps to load
                        setTimeout(waitForGoogleMaps, 100);
                  }
            }
            
            // Start initialization
            waitForGoogleMaps();
      });
};

      $(document).ready(function () {
            ndsSiteMenu();
            ndsBlockSection();
            ndsYoutubeEmbed();
            ndsFooterDisclaimer();
            ndsTeamMembers();
            ndsTestimonials();
            ndsTimelineSlider();
            ndsFaqAccordion();
            ndsTeamGrid();
            ndsArticlesArchive();
            ndsSimpleGoogleMap();
            ndsLocationsSearch();
      });


})(window.jQuery || window.$);


// Backend editor support
if (typeof wp !== 'undefined' && wp.domReady) {
	const observer = new MutationObserver(() => {
            ndsBlockSection();
            ndsYoutubeEmbed();
            ndsTeamMembers();
            ndsTestimonials();
            ndsTimelineSlider();
            ndsFaqAccordion();
            ndsTeamGrid();
            ndsArticlesArchive();
            ndsSimpleGoogleMap();
            ndsLocationsSearch();
	});
	observer.observe(document.body, { childList: true, subtree: true });
}
