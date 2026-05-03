<?php
if (!defined('ABSPATH')) {
    exit;
}

class DM_Tools {
    public function __construct() {
        add_shortcode('divine_zodiac_compatibility', [$this, 'render_zodiac_compatibility']);
        add_shortcode('divine_life_path_calculator', [$this, 'render_life_path_calculator']);
        add_shortcode('divine_daily_horoscope', [$this, 'render_daily_horoscope']);
        add_filter('body_class', [$this, 'add_body_class']);
    }

    private function current_page_has_shortcode(string $tag): bool {
        global $post;
        return is_a($post, 'WP_Post') && has_shortcode((string) $post->post_content, $tag);
    }

    public function add_body_class(array $classes): array {
        if ($this->current_page_has_shortcode('divine_zodiac_compatibility')) {
            $classes[] = 'dm-zodiac-tool-page';
        }
        if ($this->current_page_has_shortcode('divine_life_path_calculator')) {
            $classes[] = 'dm-life-path-tool-page';
        }
        if ($this->current_page_has_shortcode('divine_daily_horoscope')) {
            $classes[] = 'dm-daily-horoscope-page';
        }
        return $classes;
    }

    public function render_zodiac_compatibility(): string {
        $urls = DM_Utils::get_urls();
        $signs = [
            'Aries' => '♈ Aries',
            'Taurus' => '♉ Taurus',
            'Gemini' => '♊ Gemini',
            'Cancer' => '♋ Cancer',
            'Leo' => '♌ Leo',
            'Virgo' => '♍ Virgo',
            'Libra' => '♎ Libra',
            'Scorpio' => '♏ Scorpio',
            'Sagittarius' => '♐ Sagittarius',
            'Capricorn' => '♑ Capricorn',
            'Aquarius' => '♒ Aquarius',
            'Pisces' => '♓ Pisces',
        ];

        ob_start();
        ?>
        <div class="dm-zodiac-tool" data-dm-zodiac-tool>
            <section class="dm-zc-hero" aria-labelledby="dm-zc-title">
                <div class="dm-zc-stars" aria-hidden="true"></div>
                <div class="dm-zc-orbit dm-zc-orbit--one" aria-hidden="true"></div>
                <div class="dm-zc-orbit dm-zc-orbit--two" aria-hidden="true"></div>
                <div class="dm-zc-wrap dm-zc-hero__grid">
                    <div class="dm-zc-hero__copy">
                        <p class="dm-zc-kicker">♡ Zodiac Compatibility Checker</p>
                        <h1 id="dm-zc-title">See how two zodiac signs actually connect.</h1>
                        <p class="dm-zc-lead">Discover how your zodiac signs align in love, friendship, emotional rhythm, and everyday chemistry. Choose two signs and get an instant reading with a compatibility score, strengths, and growth tips.</p>
                        <div class="dm-zc-hero__actions" aria-label="Popular next steps">
                            <a href="<?php echo esc_url($urls['daily_horoscope']); ?>">Read today’s horoscope</a>
                            <a href="<?php echo esc_url($urls['life_path']); ?>">Try the life path calculator</a>
                            <a href="<?php echo esc_url($urls['zodiac']); ?>">Explore zodiac guides</a>
                        </div>
                    </div>

                    <form class="dm-zc-card dm-zc-form" data-zc-form>
                        <div class="dm-zc-card__halo" aria-hidden="true"></div>
                        <div class="dm-zc-form__head">
                            <span>✦</span>
                            <div>
                                <h2>Check your match</h2>
                                <p>Pick two signs. The stars can handle the gossip.</p>
                            </div>
                        </div>

                        <div class="dm-zc-select-grid">
                            <label class="dm-zc-field">
                                <span>Your sign</span>
                                <select id="dm-zc-sign-one" data-zc-sign-one>
                                    <?php foreach ($signs as $value => $label) : ?>
                                        <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </label>

                            <label class="dm-zc-field">
                                <span>Their sign</span>
                                <select id="dm-zc-sign-two" data-zc-sign-two>
                                    <?php foreach ($signs as $value => $label) : ?>
                                        <option value="<?php echo esc_attr($value); ?>" <?php selected($value, 'Leo'); ?>><?php echo esc_html($label); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </label>
                        </div>

                        <div class="dm-zc-preview-row" aria-live="polite">
                            <div class="dm-zc-sign-preview" data-zc-preview-one>
                                <span class="dm-zc-sign-preview__glyph">♈</span>
                                <strong>Aries</strong>
                                <em>Fire • Cardinal</em>
                            </div>
                            <span class="dm-zc-plus" aria-hidden="true">+</span>
                            <div class="dm-zc-sign-preview" data-zc-preview-two>
                                <span class="dm-zc-sign-preview__glyph">♌</span>
                                <strong>Leo</strong>
                                <em>Fire • Fixed</em>
                            </div>
                        </div>

                        <button class="dm-zc-submit" type="submit">Reveal Compatibility <span aria-hidden="true">→</span></button>
                        <p class="dm-zc-note">For insight, reflection, and a little cosmic fun, not a life sentence from the planets.</p>
                    </form>
                </div>
            </section>

            <section class="dm-zc-loading" data-zc-loading hidden aria-live="polite">
                <div class="dm-zc-wrap">
                    <div class="dm-zc-loading__box">
                        <span aria-hidden="true"></span>
                        <div>
                            <strong>Reading the zodiac map…</strong>
                            <p>Comparing sign elements, emotional rhythm, attraction style, and growth lessons.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="dm-zc-results" data-zc-result-section aria-labelledby="dm-zc-result-title" hidden>
                <div class="dm-zc-wrap dm-zc-results__grid">
                    <div class="dm-zc-score-card">
                        <div class="dm-zc-score-ring" data-zc-score-ring style="--score: 86;">
                            <span data-zc-score>86%</span>
                        </div>
                        <p>Compatibility score</p>
                        <div class="dm-zc-score-tags" data-zc-score-tags>
                            <span>Fire</span><span>Passion</span><span>Momentum</span>
                        </div>
                    </div>

                    <article class="dm-zc-reading-card">
                        <p class="dm-zc-kicker">Your cosmic reading</p>
                        <h2 id="dm-zc-result-title" data-zc-title>Aries + Leo</h2>
                        <p class="dm-zc-result-summary" data-zc-summary>A match full of excitement and adventure, but both need to avoid power struggles.</p>

                        <div class="dm-zc-insight-grid">
                            <div>
                                <span>♡</span>
                                <h3>Natural Strength</h3>
                                <p data-zc-strength>High energy, quick attraction, and shared enthusiasm make this pairing feel alive.</p>
                            </div>
                            <div>
                                <span>☿</span>
                                <h3>Communication Style</h3>
                                <p data-zc-communication>Direct, expressive, and fast-moving. Best when both people leave room to be heard.</p>
                            </div>
                            <div>
                                <span>✦</span>
                                <h3>Growth Edge</h3>
                                <p data-zc-growth>Practice patience before reacting. The spark is strong, so the ego needs a softer seatbelt.</p>
                            </div>
                        </div>

                        <div class="dm-zc-reading-actions">
                            <button type="button" class="dm-zc-secondary" data-zc-random>Try a random pairing</button>
                            <a href="<?php echo esc_url($urls['daily_horoscope']); ?>">Read today’s horoscope <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                </div>
            </section>

            <section class="dm-zc-explore" aria-labelledby="dm-zc-popular-title">
                <div class="dm-zc-wrap">
                    <div class="dm-zc-section-head">
                        <p class="dm-zc-kicker">Keep exploring</p>
                        <h2 id="dm-zc-popular-title">Popular pairings visitors love to test.</h2>
                        <p>One click changes the signs above and reveals a new mini-reading.</p>
                    </div>
                    <div class="dm-zc-pair-grid" data-zc-pairs>
                        <button type="button" data-pair-one="Aries" data-pair-two="Sagittarius">♈ Aries + ♐ Sagittarius</button>
                        <button type="button" data-pair-one="Taurus" data-pair-two="Cancer">♉ Taurus + ♋ Cancer</button>
                        <button type="button" data-pair-one="Gemini" data-pair-two="Libra">♊ Gemini + ♎ Libra</button>
                        <button type="button" data-pair-one="Cancer" data-pair-two="Pisces">♋ Cancer + ♓ Pisces</button>
                        <button type="button" data-pair-one="Scorpio" data-pair-two="Capricorn">♏ Scorpio + ♑ Capricorn</button>
                        <button type="button" data-pair-one="Aquarius" data-pair-two="Pisces">♒ Aquarius + ♓ Pisces</button>
                    </div>
                </div>
            </section>

            <section class="dm-zc-next" aria-labelledby="dm-zc-next-title">
                <div class="dm-zc-wrap">
                    <div class="dm-zc-section-head dm-zc-section-head--center">
                        <p class="dm-zc-kicker">More ways to stay on the path</p>
                        <h2 id="dm-zc-next-title">Turn one reading into a journey.</h2>
                    </div>
                    <div class="dm-zc-next-grid">
                        <a href="<?php echo esc_url($urls['daily_horoscope']); ?>">
                            <span>☾</span>
                            <strong>Daily Horoscope</strong>
                            <em>See what today’s zodiac weather brings.</em>
                        </a>
                        <a href="<?php echo esc_url($urls['life_path']); ?>">
                            <span>7</span>
                            <strong>Life Path Calculator</strong>
                            <em>Pair star sign chemistry with numerology insight.</em>
                        </a>
                        <a href="<?php echo esc_url($urls['tarot_card']); ?>">
                            <span>☼</span>
                            <strong>Tarot Card of the Day</strong>
                            <em>Pull a daily card for reflection and guidance.</em>
                        </a>
                        <a href="<?php echo esc_url($urls['angel_numbers']); ?>">
                            <span>111</span>
                            <strong>Angel Numbers</strong>
                            <em>Decode repeating numbers you keep noticing.</em>
                        </a>
                    </div>
                </div>
            </section>
        </div>
        <?php
        return (string) ob_get_clean();
    }

    public function render_life_path_calculator(): string {
        $urls = DM_Utils::get_urls();

        ob_start();
        ?>
        <div class="dm-life-tool" data-dm-life-tool>
            <section class="dm-lp-hero" aria-labelledby="dm-lp-title">
                <div class="dm-lp-stars" aria-hidden="true"></div>
                <div class="dm-lp-orbit dm-lp-orbit--one" aria-hidden="true"></div>
                <div class="dm-lp-orbit dm-lp-orbit--two" aria-hidden="true"></div>
                <div class="dm-lp-wrap dm-lp-hero__grid">
                    <div class="dm-lp-hero__copy">
                        <p class="dm-lp-kicker">✦ Free Life Path Number Calculator</p>
                        <h1 id="dm-lp-title">Find out what your birthday says about you.</h1>
                        <p class="dm-lp-lead">Enter your birthdate and discover the numerology number linked with your personality, natural gifts, life lessons, and deeper purpose.</p>
                        <div class="dm-lp-hero__actions" aria-label="Popular next steps">
                            <a href="<?php echo esc_url($urls['numerology']); ?>">Explore numerology</a>
                            <a href="<?php echo esc_url($urls['angel_numbers']); ?>">Decode angel numbers</a>
                            <a href="<?php echo esc_url($urls['tarot_card']); ?>">Pull today’s tarot card</a>
                        </div>
                    </div>

                    <form class="dm-lp-card dm-lp-form" data-lp-form>
                        <div class="dm-lp-card__halo" aria-hidden="true"></div>
                        <div class="dm-lp-form__head">
                            <span>7</span>
                            <div>
                                <h2>Calculate your number</h2>
                                <p>Your birthdate becomes a simple number with a surprisingly sticky meaning.</p>
                            </div>
                        </div>

                        <label class="dm-lp-field" for="dm-lp-birthdate">
                            <span>Your birthdate</span>
                            <input type="date" id="dm-lp-birthdate" data-lp-birthdate required>
                        </label>

                        <div class="dm-lp-preview" aria-hidden="true">
                            <div>
                                <strong>Month</strong>
                                <span data-lp-preview-month>--</span>
                            </div>
                            <div>
                                <strong>Day</strong>
                                <span data-lp-preview-day>--</span>
                            </div>
                            <div>
                                <strong>Year</strong>
                                <span data-lp-preview-year>----</span>
                            </div>
                        </div>

                        <button class="dm-lp-submit" type="submit">Reveal My Life Path <span aria-hidden="true">→</span></button>
                        <p class="dm-lp-note">For reflection and self-discovery. Your choices still get the final vote.</p>
                    </form>
                </div>
            </section>

            <section class="dm-lp-loading" data-lp-loading hidden aria-live="polite">
                <div class="dm-lp-wrap">
                    <div class="dm-lp-loading__box">
                        <span aria-hidden="true"></span>
                        <div>
                            <strong>Calculating your numerology blueprint…</strong>
                            <p>Reducing your birth month, day, and year into your core Life Path Number.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="dm-lp-results" data-lp-result-section aria-labelledby="dm-lp-result-title" hidden>
                <div class="dm-lp-wrap dm-lp-results__grid">
                    <div class="dm-lp-number-card">
                        <p class="dm-lp-kicker">Your number</p>
                        <div class="dm-lp-number-orb" data-lp-number>7</div>
                        <h2 data-lp-archetype>The Seeker</h2>
                        <p data-lp-tagline>Spiritual, analytical, and introspective.</p>
                        <div class="dm-lp-mini-tags" data-lp-tags>
                            <span>intuition</span><span>wisdom</span><span>inner truth</span>
                        </div>
                    </div>

                    <article class="dm-lp-reading-card">
                        <p class="dm-lp-kicker">Your birthday reading</p>
                        <h2 id="dm-lp-result-title" data-lp-title>Life Path 7</h2>
                        <p class="dm-lp-result-summary" data-lp-summary>Life Path 7 carries the energy of the seeker, drawn to meaning, reflection, and quiet wisdom.</p>

                        <div class="dm-lp-breakdown" aria-label="Calculation breakdown">
                            <div><span>Month</span><strong data-lp-month-reduced>--</strong></div>
                            <div><span>Day</span><strong data-lp-day-reduced>--</strong></div>
                            <div><span>Year</span><strong data-lp-year-reduced>--</strong></div>
                            <div><span>Total</span><strong data-lp-total>--</strong></div>
                        </div>

                        <div class="dm-lp-insight-grid">
                            <div>
                                <span>✦</span>
                                <h3>Natural Gift</h3>
                                <p data-lp-gift>You notice patterns other people miss and often need meaning before momentum.</p>
                            </div>
                            <div>
                                <span>☾</span>
                                <h3>Growth Lesson</h3>
                                <p data-lp-lesson>Do not hide in analysis forever. Your insight becomes powerful when it touches real life.</p>
                            </div>
                            <div>
                                <span>☼</span>
                                <h3>Best Next Step</h3>
                                <p data-lp-step>Give yourself quiet space, then choose one grounded action that supports your purpose.</p>
                            </div>
                        </div>

                        <div class="dm-lp-reading-actions">
                            <button type="button" class="dm-lp-secondary" data-lp-random>Try a sample birthday</button>
                            <a href="<?php echo esc_url($urls['numerology']); ?>">Explore numerology guides <span aria-hidden="true">→</span></a>
                            <a href="" data-lp-master-link hidden>Read the full master number guide <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                </div>
            </section>

            <section class="dm-lp-explore" aria-labelledby="dm-lp-explore-title">
                <div class="dm-lp-wrap">
                    <div class="dm-lp-section-head">
                        <p class="dm-lp-kicker">Keep exploring</p>
                        <h2 id="dm-lp-explore-title">Numerology rabbit holes worth opening.</h2>
                        <p>Give visitors a next step instead of a dead end after the calculator does its little birthday magic.</p>
                    </div>
                    <div class="dm-lp-next-grid">
                        <a href="https://divinemarkings.com/master-numbers-in-numerology/">
                            <span>11</span>
                            <strong>Master Numbers</strong>
                            <em>Learn why 11, 22, and 33 feel more intense in numerology.</em>
                        </a>
                        <a href="<?php echo esc_url($urls['angel_numbers']); ?>">
                            <span>111</span>
                            <strong>Angel Numbers</strong>
                            <em>Decode repeating numbers and spiritual nudges.</em>
                        </a>
                        <a href="<?php echo esc_url($urls['zodiac_compatibility']); ?>">
                            <span>♡</span>
                            <strong>Zodiac Compatibility</strong>
                            <em>Compare birthday insight with star sign chemistry.</em>
                        </a>
                        <a href="<?php echo esc_url($urls['tarot_card']); ?>">
                            <span>☼</span>
                            <strong>Tarot Card of the Day</strong>
                            <em>Pull a daily card to add intuitive guidance.</em>
                        </a>
                    </div>
                </div>
            </section>
        </div>
        <?php

        return (string) ob_get_clean();
    }

    public function render_daily_horoscope(): string {
        $urls = DM_Utils::get_urls();
        $signs = [
            'aries' => '♈ Aries',
            'taurus' => '♉ Taurus',
            'gemini' => '♊ Gemini',
            'cancer' => '♋ Cancer',
            'leo' => '♌ Leo',
            'virgo' => '♍ Virgo',
            'libra' => '♎ Libra',
            'scorpio' => '♏ Scorpio',
            'sagittarius' => '♐ Sagittarius',
            'capricorn' => '♑ Capricorn',
            'aquarius' => '♒ Aquarius',
            'pisces' => '♓ Pisces',
        ];

        ob_start();
        ?>
        <div class="dm-horo-tool" data-dm-horo-tool>
            <section class="dm-horo-hero" aria-labelledby="dm-horo-title">
                <div class="dm-horo-stars" aria-hidden="true"></div>
                <div class="dm-horo-wrap dm-horo-hero__grid">
                    <div class="dm-horo-hero__copy">
                        <p class="dm-horo-kicker">✦ Free Daily Horoscope & Zodiac Forecast</p>
                        <h1 id="dm-horo-title">Read today’s message for your zodiac sign.</h1>
                        <p class="dm-horo-lead">Choose your sign and receive a fresh daily forecast for timing, relationships, energy, and the next step worth noticing.</p>
                        <div class="dm-horo-hero__actions">
                            <a href="<?php echo esc_url($urls['zodiac_compatibility']); ?>">Check compatibility</a>
                            <a href="<?php echo esc_url($urls['life_path']); ?>">Calculate life path</a>
                            <a href="<?php echo esc_url($urls['tarot_card']); ?>">Pull a tarot card</a>
                        </div>
                    </div>

                    <form class="dm-horo-card dm-horo-form" data-horo-form>
                        <div class="dm-horo-card__halo" aria-hidden="true"></div>
                        <div class="dm-horo-form__head">
                            <span>☾</span>
                            <div>
                                <h2>Choose your sign</h2>
                                <p>The sky has twelve moods. Pick yours.</p>
                            </div>
                        </div>
                        <label class="dm-horo-field" for="dm-horo-sign">
                            <span>Your zodiac sign</span>
                            <select id="dm-horo-sign" data-horo-sign required>
                                <option value="" disabled selected>Select your Zodiac Sign</option>
                                <?php foreach ($signs as $value => $label) : ?>
                                    <option value="<?php echo esc_attr($value); ?>"><?php echo esc_html($label); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </label>
                        <button class="dm-horo-submit" type="submit">Reveal Today’s Horoscope <span aria-hidden="true">→</span></button>
                        <p class="dm-horo-note">Updated by the day of the month for a fresh daily-style reading.</p>
                    </form>
                </div>
            </section>

            <section class="dm-horo-loading" data-horo-loading hidden aria-live="polite">
                <div class="dm-horo-wrap">
                    <div class="dm-horo-loading__box"><span aria-hidden="true"></span><div><strong>Reading today’s zodiac weather…</strong><p>Checking your sign’s tone, timing, relationship rhythm, and best next step.</p></div></div>
                </div>
            </section>

            <section class="dm-horo-results" data-horo-result-section hidden aria-labelledby="dm-horo-result-title">
                <div class="dm-horo-wrap dm-horo-results__grid">
                    <div class="dm-horo-sign-card">
                        <p class="dm-horo-kicker">Your sign</p>
                        <div class="dm-horo-glyph" data-horo-glyph>♈</div>
                        <h2 data-horo-sign-name>Aries</h2>
                        <p data-horo-sign-trait>Bold, fiery, and ready to move.</p>
                        <div class="dm-horo-mini-tags" data-horo-tags><span>energy</span><span>timing</span><span>focus</span></div>
                    </div>
                    <article class="dm-horo-reading-card">
                        <p class="dm-horo-kicker">Today’s forecast</p>
                        <h2 id="dm-horo-result-title" data-horo-title>Aries Horoscope</h2>
                        <p class="dm-horo-result-summary" data-horo-message>Today brings a nudge toward brave action and clear choices.</p>
                        <div class="dm-horo-insight-grid">
                            <div><span>✦</span><h3>Today’s Focus</h3><p data-horo-focus>Take one clear step instead of waiting for perfect certainty.</p></div>
                            <div><span>♡</span><h3>Relationship Tone</h3><p data-horo-relationship>Direct honesty lands best when paired with warmth.</p></div>
                            <div><span>☼</span><h3>Best Next Step</h3><p data-horo-step>Choose the choice that gives your future self more peace.</p></div>
                        </div>
                        <div class="dm-horo-reading-actions">
                            <button type="button" data-horo-random>Try another sign</button>
                            <a href="<?php echo esc_url($urls['zodiac_compatibility']); ?>">Check compatibility <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                </div>
            </section>

            <section class="dm-horo-explore" aria-labelledby="dm-horo-explore-title">
                <div class="dm-horo-wrap"><div class="dm-horo-section-head"><p class="dm-horo-kicker">Keep exploring</p><h2 id="dm-horo-explore-title">More ways to follow the signs.</h2></div>
                <div class="dm-horo-next-grid">
                    <a href="<?php echo esc_url($urls['zodiac_compatibility']); ?>"><span>♡</span><strong>Zodiac Compatibility</strong><em>See how two signs connect.</em></a>
                    <a href="<?php echo esc_url($urls['life_path']); ?>"><span>7</span><strong>Life Path Calculator</strong><em>Pair star sign insight with numerology.</em></a>
                    <a href="<?php echo esc_url($urls['tarot_card']); ?>"><span>☼</span><strong>Tarot Card of the Day</strong><em>Pull a daily card for reflection.</em></a>
                    <a href="<?php echo esc_url($urls['daily_horoscope']); ?>"><span>☾</span><strong>Daily Horoscope</strong><em>Read today’s zodiac forecast.</em></a>
                </div>
                </div>
            </section>
        </div>
        <?php
        return (string) ob_get_clean();
    }
}
