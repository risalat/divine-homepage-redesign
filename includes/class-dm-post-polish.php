<?php
if (!defined('ABSPATH')) {
    exit;
}

class DM_Post_Polish {
    public function __construct() {
        if (!DM_Utils::post_polish_enabled()) {
            return;
        }

        add_filter('body_class', [$this, 'add_body_class']);
        add_action('wp_body_open', [$this, 'render_post_progress_bar'], 7);
        add_action('wp_body_open', [$this, 'render_single_post_hero'], 12);
        add_filter('the_content', [$this, 'filter_single_post_content'], 30);
    }

    private function is_single_post_polish(): bool {
        return !is_admin() && is_singular('post') && get_post_type() === 'post';
    }

    public function add_body_class(array $classes): array {
        if ($this->is_single_post_polish()) {
            $classes[] = 'dm-single-post-polish';
        }
        return $classes;
    }

    public function render_post_progress_bar(): void {
        if (!$this->is_single_post_polish()) {
            return;
        }
        echo '<div class="dm-reading-progress" aria-hidden="true"><span></span></div>';
    }

    public function render_single_post_hero(): void {
        if (!$this->is_single_post_polish() || !is_main_query()) {
            return;
        }

        $post_id = get_queried_object_id();
        if (!$post_id) {
            return;
        }

        $categories = get_the_category($post_id);
        $category_name = !empty($categories) ? $categories[0]->name : 'Divine Guide';
        $title = get_the_title($post_id);
        $author_id = (int) get_post_field('post_author', $post_id);
        $author_name = get_the_author_meta('display_name', $author_id) ?: 'Serena Willow';
        $updated = get_the_modified_date('F j, Y', $post_id);
        $raw_content = wp_strip_all_tags(strip_shortcodes((string) get_post_field('post_content', $post_id)));
        $word_count = str_word_count($raw_content);
        $reading_time = max(1, (int) ceil($word_count / 220));
        $avatar = get_avatar($author_id, 42, '', $author_name, ['class' => 'dm-post-hero__avatar']);
        ?>
        <section class="dm-post-hero" aria-labelledby="dm-post-hero-title">
            <div class="dm-post-hero__stars" aria-hidden="true"></div>
            <div class="dm-post-hero__inner">
                <p class="dm-post-hero__kicker"><?php echo esc_html($category_name); ?></p>
                <h1 id="dm-post-hero-title"><?php echo esc_html($title); ?></h1>
                <div class="dm-post-hero__meta">
                    <?php echo $avatar; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                    <span>By <?php echo esc_html($author_name); ?></span>
                    <span aria-hidden="true">•</span>
                    <span>Updated on <?php echo esc_html($updated); ?></span>
                    <span aria-hidden="true">•</span>
                    <span><?php echo esc_html($reading_time); ?> min read</span>
                </div>
            </div>
        </section>
        <?php
    }

    private function get_inline_tool_cta_html(int $post_id): string {
        $urls = DM_Utils::get_urls();
        $categories = get_the_category($post_id);
        $category_slugs = [];
        foreach ($categories as $cat) {
            if ($cat instanceof WP_Term) {
                $category_slugs[] = $cat->slug;
            }
        }
        $title = strtolower((string) get_the_title($post_id));
        $content_snippet = strtolower(wp_strip_all_tags((string) get_post_field('post_content', $post_id)));
        $context = implode(' ', $category_slugs) . ' ' . $title . ' ' . $content_snippet;

        $tool = [
            'url' => $urls['tarot_card'],
            'icon' => '☼',
            'kicker' => 'Try a free spiritual tool',
            'title' => 'Pull a card before you continue',
            'text' => 'Get a quick daily reading and keep the insight flowing.',
            'button' => 'Reveal today’s card',
        ];

        if (str_contains($context, 'tarot')) {
            $tool = [
                'url' => $urls['tarot_card'],
                'icon' => '☼',
                'kicker' => 'Try a free tarot tool',
                'title' => 'Pull your card for today',
                'text' => 'Get a quick daily tarot reading before you continue exploring the meaning.',
                'button' => 'Reveal today’s card',
            ];
        } elseif (
            str_contains($context, 'zodiac')
            || str_contains($context, 'horoscope')
            || str_contains($context, 'astrology')
            || str_contains($context, 'birth sign')
        ) {
            $tool = [
                'url' => $urls['daily_horoscope'],
                'icon' => '☾',
                'kicker' => 'Try a free zodiac tool',
                'title' => 'Read today’s message for your sign',
                'text' => 'Get a fresh zodiac forecast for timing, relationships, and reflection.',
                'button' => 'Read today’s horoscope',
            ];
        } elseif (
            str_contains($context, 'numerology')
            || str_contains($context, 'angel number')
            || str_contains($context, 'life path')
            || str_contains($context, ' number ')
        ) {
            $tool = [
                'url' => $urls['life_path'],
                'icon' => '7',
                'kicker' => 'Try a free numerology tool',
                'title' => 'Find the number behind your birthday',
                'text' => 'Use your birthdate to reveal your life path number and its meaning.',
                'button' => 'Calculate my life path',
            ];
        } elseif (
            str_contains($context, 'dream')
            || str_contains($context, 'relationship')
            || str_contains($context, 'love')
            || str_contains($context, 'compatibility')
        ) {
            $tool = [
                'url' => $urls['zodiac_compatibility'],
                'icon' => '♡',
                'kicker' => 'Try a free compatibility tool',
                'title' => 'Check your zodiac compatibility',
                'text' => 'Compare two signs and see where the connection feels easy, intense, or surprising.',
                'button' => 'Check compatibility',
            ];
        }

        return '<section class="dm-post-inline-tool-cta" aria-label="Try a related tool">'
            . '<div class="dm-post-inline-tool-cta__icon">' . esc_html($tool['icon']) . '</div>'
            . '<div class="dm-post-inline-tool-cta__copy">'
            . '<p class="dm-post-side-kicker">' . esc_html($tool['kicker']) . '</p>'
            . '<h2>' . esc_html($tool['title']) . '</h2>'
            . '<p>' . esc_html($tool['text']) . '</p>'
            . '</div>'
            . '<a class="dm-post-inline-tool-cta__button" href="' . esc_url($tool['url']) . '">' . esc_html($tool['button']) . '</a>'
            . '</section>';
    }

    private function inject_inline_tool_cta(string $content, int $post_id): string {
        $cta = $this->get_inline_tool_cta_html($post_id);
        if (strpos($content, 'dm-post-inline-tool-cta') !== false) {
            return $content;
        }

        $paragraphs = explode('</p>', $content);
        $count = count($paragraphs);

        if ($count > 5) {
            array_splice($paragraphs, 5, 0, [$cta]);
        } elseif ($count > 3) {
            array_splice($paragraphs, 3, 0, [$cta]);
        } else {
            return $content . $cta;
        }

        return implode('</p>', $paragraphs);
    }

    private function get_post_sidebar_html(): string {
        $urls = DM_Utils::get_urls();
        ob_start();
        ?>
        <aside class="dm-post-reading-sidebar" aria-label="Article navigation and related tools">
            <div class="dm-post-sidebar-stack" data-dm-post-sidebar-stack>
                <section class="dm-post-side-card dm-post-toc-card" data-dm-post-toc-card hidden>
                    <p class="dm-post-side-kicker">In this guide</p>
                    <h3>Jump to a section</h3>
                    <nav class="dm-post-toc" data-dm-post-toc aria-label="Table of contents"></nav>
                </section>

                <section class="dm-post-side-card dm-post-tools-card">
                    <p class="dm-post-side-kicker">Try a free tool</p>
                    <h3>Keep exploring</h3>
                    <a href="<?php echo esc_url($urls['tarot_card']); ?>"><span>☼</span><strong>Tarot Card of the Day</strong></a>
                    <a href="<?php echo esc_url($urls['life_path']); ?>"><span>7</span><strong>Life Path Calculator</strong></a>
                    <a href="<?php echo esc_url($urls['zodiac_compatibility']); ?>"><span>♡</span><strong>Zodiac Compatibility</strong></a>
                    <a href="<?php echo esc_url($urls['daily_horoscope']); ?>"><span>☾</span><strong>Daily Horoscope</strong></a>
                </section>

                <section class="dm-post-side-card dm-post-category-card">
                    <p class="dm-post-side-kicker">Popular paths</p>
                    <h3>Browse meanings</h3>
                    <a href="<?php echo esc_url($urls['spiritual_meanings']); ?>">Spiritual Meanings <span>→</span></a>
                    <a href="<?php echo esc_url($urls['angel_numbers']); ?>">Angel Numbers <span>→</span></a>
                    <a href="<?php echo esc_url($urls['biblical_meanings']); ?>">Biblical Meanings <span>→</span></a>
                    <a href="<?php echo esc_url($urls['numerology']); ?>">Numerology <span>→</span></a>
                </section>
            </div>
        </aside>
        <?php
        return (string) ob_get_clean();
    }

    private function get_related_posts_html(int $post_id): string {
        $categories = wp_get_post_categories($post_id);
        $args = [
            'post_type' => 'post',
            'posts_per_page' => 5,
            'post__not_in' => [$post_id],
            'ignore_sticky_posts' => true,
            'no_found_rows' => true,
            'fields' => 'ids',
        ];

        if (!empty($categories)) {
            $args['category__in'] = $categories;
        }

        $related_ids = get_posts($args);
        if (empty($related_ids)) {
            return '';
        }

        ob_start();
        ?>
        <section class="dm-post-related" aria-labelledby="dm-post-related-title">
            <div class="dm-post-section-head">
                <p>Continue exploring</p>
                <h2 id="dm-post-related-title">Related guides for curious souls</h2>
            </div>
            <div class="dm-post-related-grid">
                <?php foreach ($related_ids as $related_id) : ?>
                    <?php
                    $cat = get_the_category($related_id);
                    $cat_name = !empty($cat) ? $cat[0]->name : 'Guide';
                    $raw_excerpt = (string) get_post_field('post_excerpt', $related_id);
                    $raw_content = (string) get_post_field('post_content', $related_id);
                    $excerpt_source = trim($raw_excerpt) !== '' ? $raw_excerpt : $raw_content;
                    $excerpt = wp_trim_words(wp_strip_all_tags(strip_shortcodes($excerpt_source)), 14);
                    ?>
                    <a class="dm-post-related-card" href="<?php echo esc_url(get_permalink($related_id)); ?>">
                        <span class="dm-post-related-art" aria-hidden="true"></span>
                        <span class="dm-post-related-meta"><?php echo esc_html($cat_name); ?></span>
                        <strong><?php echo esc_html(get_the_title($related_id)); ?></strong>
                        <em><?php echo esc_html($excerpt); ?></em>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
        <?php
        return (string) ob_get_clean();
    }

    private function get_soul_quiz_card_html(int $post_id): string {
        $variant_index = ((int) $post_id % 3) + 1;
        $variants = [
            1 => 'portal',
            2 => 'path',
            3 => 'message',
        ];
        $variant = $variants[$variant_index] ?? 'portal';

        $visuals = [
            'portal' => '<div class="dm-soul-portal-ring"></div><div class="dm-soul-portal-moon"></div><div class="dm-soul-portal-stars"></div>',
            'path'   => '<div class="dm-soul-path-map"><div class="dm-soul-path-node" data-label="Clarity">☾</div><div class="dm-soul-path-node" data-label="Love">♡</div><div class="dm-soul-path-node" data-label="Purpose">⚿</div><div class="dm-soul-path-node" data-label="Protection">◈</div><div class="dm-soul-path-node" data-label="Transformation">✦</div></div>',
            'message' => '<div class="dm-soul-envelope"><div class="dm-soul-envelope-flap"></div><div class="dm-soul-cards-stack"><span></span><span></span><span></span></div><div class="dm-soul-wax-seal">☾</div></div>',
        ];

        return '<section class="dm-soul-quiz-card dm-soul-quiz-card--' . esc_attr($variant) . '" data-dm-soul-quiz-card>'
            . '<div class="dm-soul-quiz-card__inner">'
            . '<div class="dm-soul-quiz-card__copy">'
            . '<p class="dm-soul-quiz-card__eyebrow">Soul Signal Quiz</p>'
            . '<h2>What Message Is the Universe Sending You Right Now?</h2>'
            . '<p>Take the 60-second Soul Signal Quiz and reveal whether this sign points to clarity, love, purpose, protection, or transformation.</p>'
            . '<button type="button" class="dm-soul-quiz-card__button" data-dm-soul-quiz-open>'
            . 'Start the Quiz <span aria-hidden="true">→</span>'
            . '</button>'
            . '<div class="dm-soul-quiz-card__trust">'
            . '<span>No sign-up</span>'
            . '<span>5 quick questions</span>'
            . '<span>Stay on this page</span>'
            . '</div>'
            . '</div>'
            . '<div class="dm-soul-quiz-card__visual" aria-hidden="true">'
            . $visuals[$variant]
            . '</div>'
            . '</div>'
            . '<div class="dm-soul-quiz-card__chips" aria-hidden="true">'
            . '<span>Clarity</span><span>Love</span><span>Purpose</span><span>Protection</span><span>Transformation</span>'
            . '</div>'
            . '</section>';
    }

    private function get_soul_quiz_modal_html(): string {
        if (strpos($GLOBALS['dm_soul_quiz_modal_rendered'] ?? '', 'yes') !== false) {
            return '';
        }
        $GLOBALS['dm_soul_quiz_modal_rendered'] = 'yes';

        return '<div class="dm-soul-quiz-modal" data-dm-soul-quiz-modal hidden>'
            . '<div class="dm-soul-quiz-modal__backdrop" data-dm-soul-quiz-close></div>'
            . '<div class="dm-soul-quiz-dialog" role="dialog" aria-modal="true" aria-labelledby="dm-soul-quiz-title">'
            . '<button type="button" class="dm-soul-quiz-close" data-dm-soul-quiz-close aria-label="Close quiz">×</button>'
            . '<div class="dm-soul-quiz-stage" data-dm-soul-quiz-stage></div>'
            . '</div>'
            . '</div>';
    }

    private function inject_soul_quiz_card(string $content, int $post_id): string {
        if (!DM_Utils::soul_quiz_enabled()) {
            return $content;
        }
        if (strpos($content, 'dm-soul-quiz-card') !== false) {
            return $content;
        }

        $card = $this->get_soul_quiz_card_html($post_id);

        $h2s = preg_split('/(<\/h2>)/i', $content, -1, PREG_SPLIT_DELIM_CAPTURE);
        if (count($h2s) >= 7) {
            array_splice($h2s, 6, 0, [$card]);
            return implode('', $h2s);
        }
        if (count($h2s) >= 5) {
            array_splice($h2s, 4, 0, [$card]);
            return implode('', $h2s);
        }

        $paragraphs = explode('</p>', $content);
        $count = count($paragraphs);
        if ($count > 6) {
            array_splice($paragraphs, 6, 0, [$card]);
        } elseif ($count > 4) {
            array_splice($paragraphs, 4, 0, [$card]);
        } else {
            return $content . $card;
        }
        return implode('</p>', $paragraphs);
    }

    public function filter_single_post_content(string $content): string {
        static $is_filtering = false;

        if ($is_filtering || !$this->is_single_post_polish() || !in_the_loop() || !is_main_query()) {
            return $content;
        }

        $is_filtering = true;
        $urls = DM_Utils::get_urls();
        $post_id = get_the_ID();

        $content_with_inline_cta = $this->inject_inline_tool_cta($content, (int) $post_id);
        $content_with_quiz = $this->inject_soul_quiz_card($content_with_inline_cta, (int) $post_id);

        $continue = '<section class="dm-post-continue" aria-labelledby="dm-post-continue-title">'
            . '<div><p class="dm-post-side-kicker">Your reading does not have to end here</p>'
            . '<h2 id="dm-post-continue-title">Keep exploring your path</h2>'
            . '<p>Try a free tool or continue into related meanings while the curiosity is still warm.</p></div>'
            . '<div class="dm-post-continue-grid">'
            . '<a href="' . esc_url($urls['tarot_card']) . '"><span>☼</span><strong>Tarot Card of the Day</strong><em>Pull a daily card for quick guidance.</em></a>'
            . '<a href="' . esc_url($urls['life_path']) . '"><span>7</span><strong>Life Path Calculator</strong><em>Find the number behind your birthday.</em></a>'
            . '<a href="' . esc_url($urls['zodiac_compatibility']) . '"><span>♡</span><strong>Zodiac Compatibility</strong><em>Check two signs in love or friendship.</em></a>'
            . '<a href="' . esc_url($urls['daily_horoscope']) . '"><span>☾</span><strong>Daily Horoscope</strong><em>Read today’s zodiac forecast.</em></a>'
            . '</div></section>';

        $main_content = $content_with_quiz . $continue . $this->get_related_posts_html((int) $post_id);
        $enhanced_content = '<div class="dm-post-reading-shell">'
            . '<div class="dm-post-reading-main">' . $main_content . '</div>'
            . $this->get_post_sidebar_html()
            . '</div>'
            . $this->get_soul_quiz_modal_html();
        $is_filtering = false;

        return $enhanced_content;
    }
}
