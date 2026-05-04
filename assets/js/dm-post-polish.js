(function () {
  if (!document.body.classList.contains('dm-single-post-polish')) return;

  const progress = document.querySelector('.dm-reading-progress span');
  function updateProgress() {
    if (!progress) return;
    const doc = document.documentElement;
    const scrollTop = window.scrollY || doc.scrollTop || 0;
    const height = Math.max(1, doc.scrollHeight - window.innerHeight);
    progress.style.width = Math.min(100, Math.max(0, (scrollTop / height) * 100)) + '%';
  }
  window.addEventListener('scroll', updateProgress, { passive: true });
  window.addEventListener('resize', updateProgress);
  updateProgress();

  const content = document.querySelector('.dm-post-reading-main, .entry-content, .post-content, article .content, main article');
  if (!content) return;

  content.querySelectorAll('p, div').forEach(function (el) {
    const txt = (el.textContent || '').trim().toLowerCase();
    if (txt.startsWith('key takeaway:') || txt.includes('key takeaway:')) {
      el.classList.add('dm-key-takeaway-box');
    }
  });

  const headings = Array.from(content.querySelectorAll('h2, h3')).filter(function (h) {
    return h.textContent.trim().length > 0 && !h.closest('.dm-post-continue, .dm-post-related, .dm-soul-quiz-card');
  }).slice(0, 18);

  const tocCard = document.querySelector('[data-dm-post-toc-card]');
  const toc = document.querySelector('[data-dm-post-toc]');

  if (toc && headings.length >= 3) {
    headings.forEach(function (heading, index) {
      if (!heading.id) heading.id = 'dm-section-' + (index + 1) + '-' + heading.textContent.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
      const a = document.createElement('a');
      a.href = '#' + heading.id;
      a.textContent = heading.textContent.trim();
      if (heading.tagName.toLowerCase() === 'h3') a.className = 'dm-post-toc-h3';
      toc.appendChild(a);
    });
    if (tocCard) tocCard.hidden = false;
  }

  /* ========== Soul Signal Quiz ========== */
  const card = document.querySelector('[data-dm-soul-quiz-card]');
  const modal = document.querySelector('[data-dm-soul-quiz-modal]');
  const stage = document.querySelector('[data-dm-soul-quiz-stage]');
  if (!card || !modal || !stage) return;

  const urls = window.DMPostPolishData && window.DMPostPolishData.urls ? window.DMPostPolishData.urls : {};
  const analytics = window.DMPostPolishData && window.DMPostPolishData.analytics ? window.DMPostPolishData.analytics : {};

  function trackSoulQuizEvent(eventName) {
    if (!analytics.enabled || !analytics.ajaxUrl || !analytics.nonce || !eventName) return;
    try {
      var formData = new FormData();
      formData.append('action', 'dmhr_track_soul_quiz');
      formData.append('nonce', analytics.nonce);
      formData.append('event', eventName);
      if (navigator.sendBeacon) {
        navigator.sendBeacon(analytics.ajaxUrl, formData);
      } else {
        fetch(analytics.ajaxUrl, { method: 'POST', body: formData, keepalive: true });
      }
    } catch (e) {
      // Silent failure
    }
  }

  var cardSeenTracked = false;
  if (card && typeof IntersectionObserver !== 'undefined') {
    var cardObserver = new IntersectionObserver(function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting && !cardSeenTracked) {
          cardSeenTracked = true;
          trackSoulQuizEvent('quiz_card_seen');
          cardObserver.disconnect();
        }
      });
    }, { threshold: 0.35 });
    cardObserver.observe(card);
  } else if (card) {
    setTimeout(function () {
      if (!cardSeenTracked) {
        cardSeenTracked = true;
        trackSoulQuizEvent('quiz_card_seen');
      }
    }, 1200);
  }

  const quizData = {
    title: 'What Message Is the Universe Sending You Right Now?',
    subtitle: 'Answer five quick questions to reveal the kind of guidance this sign, dream, number, or symbol may be pointing you toward.',
    questions: [
      {
        text: 'What brought you here today?',
        answers: [
          { text: 'I noticed a sign, symbol, color, animal, or repeated image', result: 'clarity' },
          { text: 'I had a dream that felt meaningful', result: 'transformation' },
          { text: 'I keep seeing a number or pattern', result: 'purpose' },
          { text: 'I\u2019m thinking about love, connection, or someone specific', result: 'love' },
          { text: 'I felt warned, uneasy, or spiritually alert', result: 'protection' },
        ],
      },
      {
        text: 'What feeling is strongest right now?',
        answers: [
          { text: 'Curious, like something is trying to get my attention', result: 'clarity' },
          { text: 'Emotional, tender, or nostalgic', result: 'love' },
          { text: 'Restless, like I\u2019m supposed to make a change', result: 'transformation' },
          { text: 'Focused on my future, direction, or calling', result: 'purpose' },
          { text: 'Cautious, like I need to be careful with my next step', result: 'protection' },
        ],
      },
      {
        text: 'Where do you most want guidance?',
        answers: [
          { text: 'Understanding the meaning behind a sign', result: 'clarity' },
          { text: 'Love, friendship, attraction, or compatibility', result: 'love' },
          { text: 'My life direction or personal growth', result: 'purpose' },
          { text: 'Letting go of something old', result: 'transformation' },
          { text: 'Knowing whether something is safe or aligned', result: 'protection' },
        ],
      },
      {
        text: 'Which message feels closest to what you need to hear?',
        answers: [
          { text: 'Look deeper. There is more meaning here.', result: 'clarity' },
          { text: 'Your heart already knows more than you think.', result: 'love' },
          { text: 'Your path is forming, even if it feels unclear.', result: 'purpose' },
          { text: 'Something is ending so something better can begin.', result: 'transformation' },
          { text: 'Pause. Protect your peace before moving forward.', result: 'protection' },
        ],
      },
      {
        text: 'What kind of next step would feel most helpful?',
        answers: [
          { text: 'A quick spiritual reading', result: 'clarity' },
          { text: 'A relationship insight', result: 'love' },
          { text: 'A personal number or life-path reading', result: 'purpose' },
          { text: 'More meanings connected to dreams, symbols, or signs', result: 'transformation' },
          { text: 'A daily forecast or gentle warning for today', result: 'protection' },
        ],
      },
    ],
    results: {
      clarity: {
        title: 'You\u2019re Receiving a Message of Clarity',
        text: 'This sign may be asking you to slow down and notice what is already in front of you. Something that felt random may actually be pointing toward a deeper truth, a repeated theme, or an answer you have been circling for a while.',
        primaryCta: 'Reveal Today\u2019s Card',
        primaryUrl: urls.tarot_card || '#',
        secondaryCta: 'Explore Spiritual Meanings',
        secondaryUrl: urls.spiritual_meanings || '#',
      },
      love: {
        title: 'You\u2019re Receiving a Message About Love or Connection',
        text: 'This message may be connected to how you relate, trust, attract, or open your heart. It does not always mean romance. Sometimes it points to emotional patterns, friendship, forgiveness, or the kind of bond your soul is ready to understand more clearly.',
        primaryCta: 'Check Compatibility',
        primaryUrl: urls.zodiac_compatibility || '#',
        secondaryCta: 'Read Today\u2019s Horoscope',
        secondaryUrl: urls.daily_horoscope || '#',
      },
      purpose: {
        title: 'You\u2019re Receiving a Message About Purpose',
        text: 'The pattern you noticed may be pointing toward direction, timing, or personal growth. This is the kind of message that often appears when you are being nudged to trust your path, make a decision, or understand the deeper rhythm of your life.',
        primaryCta: 'Calculate My Life Path',
        primaryUrl: urls.life_path || '#',
        secondaryCta: 'Explore Angel Numbers',
        secondaryUrl: urls.angel_numbers || '#',
      },
      transformation: {
        title: 'You\u2019re Receiving a Message of Transformation',
        text: 'This message may be appearing because something in your life is shifting. It could point to release, renewal, healing, or a moment where you are being asked to move from an old version of yourself into something more honest and aligned.',
        primaryCta: 'Explore Spiritual Meanings',
        primaryUrl: urls.spiritual_meanings || '#',
        secondaryCta: 'Pull a Tarot Card',
        secondaryUrl: urls.tarot_card || '#',
      },
      protection: {
        title: 'You\u2019re Receiving a Message of Protection',
        text: 'This message may be asking you to pause, protect your energy, and pay attention to what feels off. It does not have to mean fear. Sometimes protection is simply your intuition asking for clearer boundaries, better timing, or a wiser next step.',
        primaryCta: 'Read Today\u2019s Horoscope',
        primaryUrl: urls.daily_horoscope || '#',
        secondaryCta: 'Explore Biblical Meanings',
        secondaryUrl: urls.biblical_meanings || '#',
      },
    },
  };

  const resultMeta = {
    clarity:       { icon: '✦', chip: 'Clarity' },
    love:          { icon: '♡', chip: 'Love' },
    purpose:       { icon: '☼', chip: 'Purpose' },
    protection:    { icon: '◈', chip: 'Protection' },
    transformation:{ icon: '✧', chip: 'Transformation' },
  };

  let currentQuestion = 0;
  let answers = [];
  let lastFocused = null;

  function openModal() {
    lastFocused = document.activeElement;
    modal.hidden = false;
    document.body.classList.add('dm-soul-quiz-open');
    renderIntro();
    setTimeout(function () {
      const focusTarget = modal.querySelector('button, a');
      if (focusTarget) focusTarget.focus();
    }, 10);
  }

  function closeModal() {
    modal.hidden = true;
    document.body.classList.remove('dm-soul-quiz-open');
    if (lastFocused) lastFocused.focus();
  }

  function resetQuiz() {
    currentQuestion = 0;
    answers = [];
  }

  function calculateResult() {
    const counts = {};
    answers.forEach(function (a) {
      counts[a] = (counts[a] || 0) + 1;
    });
    let max = 0;
    let winners = [];
    Object.keys(counts).forEach(function (k) {
      if (counts[k] > max) {
        max = counts[k];
        winners = [k];
      } else if (counts[k] === max) {
        winners.push(k);
      }
    });
    if (winners.length === 1) return winners[0];
    const tieBreaker = answers[answers.length - 1];
    if (winners.indexOf(tieBreaker) !== -1) return tieBreaker;
    return winners[0];
  }

  function renderIntro() {
    stage.innerHTML = '<div class="dm-soul-quiz-intro">'
      + '<h2 id="dm-soul-quiz-title">' + quizData.title + '</h2>'
      + '<p>' + quizData.subtitle + '</p>'
      + '<button type="button" class="dm-soul-quiz-card__button" data-dm-soul-quiz-start>Start the Quiz <span aria-hidden="true">→</span></button>'
      + '</div>';
    stage.querySelector('[data-dm-soul-quiz-start]').addEventListener('click', function () {
      trackSoulQuizEvent('quiz_started');
      resetQuiz();
      renderQuestion();
    });
  }

  function renderQuestion() {
    const q = quizData.questions[currentQuestion];
    const pct = Math.round(((currentQuestion) / quizData.questions.length) * 100);
    let html = '<div class="dm-soul-quiz-question">'
      + '<div class="dm-soul-quiz-progress"><span style="width:' + pct + '%"></span></div>'
      + '<div class="dm-soul-quiz-question-meta">'
      + '<span>Question ' + (currentQuestion + 1) + ' of ' + quizData.questions.length + '</span>'
      + '</div>'
      + '<h3>' + q.text + '</h3>'
      + '<div class="dm-soul-quiz-answers">';
    q.answers.forEach(function (a, i) {
      html += '<button type="button" class="dm-soul-quiz-answer" data-index="' + i + '" data-result="' + a.result + '">' + a.text + '</button>';
    });
    html += '</div>'
      + '<div class="dm-soul-quiz-nav">'
      + '<button type="button" class="dm-soul-quiz-back" data-dm-soul-quiz-back ' + (currentQuestion === 0 ? 'disabled' : '') + '>← Back</button>'
      + '</div>'
      + '</div>';
    stage.innerHTML = html;

    const answerButtons = stage.querySelectorAll('.dm-soul-quiz-answer');
    const questionEl = stage.querySelector('.dm-soul-quiz-question');
    answerButtons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        if (btn.disabled) return;
        answerButtons.forEach(function (b) {
          b.disabled = true;
          b.classList.remove('is-selected');
        });
        btn.classList.add('is-selected');
        if (questionEl) questionEl.classList.add('is-advancing');
        const result = btn.getAttribute('data-result');
        answers[currentQuestion] = result;
        setTimeout(function () {
          currentQuestion++;
          if (currentQuestion < quizData.questions.length) {
            renderQuestion();
          } else {
            renderResult();
          }
        }, 650);
      });
    });

    stage.querySelector('[data-dm-soul-quiz-back]').addEventListener('click', function () {
      if (currentQuestion > 0) {
        currentQuestion--;
        renderQuestion();
      }
    });
  }

  function renderResult() {
    const key = calculateResult();
    const r = quizData.results[key];
    const meta = resultMeta[key] || { icon: '✦', chip: 'Clarity' };

    trackSoulQuizEvent('quiz_completed');
    trackSoulQuizEvent('result_' + key);

    const html = '<div class="dm-soul-quiz-result dm-soul-quiz-result--' + key + '">'
      + '<div class="dm-soul-quiz-result-orb" aria-hidden="true"><span>' + meta.icon + '</span></div>'
      + '<span class="dm-soul-quiz-result-label">Your Soul Signal</span>'
      + '<span class="dm-soul-quiz-result-chip">' + meta.chip + '</span>'
      + '<h2>' + r.title + '</h2>'
      + '<p>' + r.text + '</p>'
      + '<p class="dm-soul-quiz-result-next">Recommended next step</p>'
      + '<div class="dm-soul-quiz-result-actions">'
      + '<a class="dm-soul-quiz-result-primary" href="' + r.primaryUrl + '">' + r.primaryCta + '</a>'
      + '<a class="dm-soul-quiz-result-secondary" href="' + r.secondaryUrl + '">' + r.secondaryCta + '</a>'
      + '</div>'
      + '<div class="dm-soul-quiz-result-buttons">'
      + '<button type="button" data-dm-soul-quiz-retake="1">Retake Quiz</button>'
      + '<button type="button" data-dm-soul-quiz-continue="1">Continue Reading</button>'
      + '</div>'
      + '</div>';
    stage.innerHTML = html;

    var primaryCta = stage.querySelector('.dm-soul-quiz-result-primary');
    if (primaryCta) {
      primaryCta.addEventListener('click', function () {
        trackSoulQuizEvent('primary_cta_clicked');
      });
    }
    var secondaryCta = stage.querySelector('.dm-soul-quiz-result-secondary');
    if (secondaryCta) {
      secondaryCta.addEventListener('click', function () {
        trackSoulQuizEvent('secondary_cta_clicked');
      });
    }
    stage.querySelector('[data-dm-soul-quiz-retake]').addEventListener('click', function () {
      trackSoulQuizEvent('retake_clicked');
      resetQuiz();
      renderIntro();
    });
    stage.querySelector('[data-dm-soul-quiz-continue]').addEventListener('click', function () {
      trackSoulQuizEvent('continue_reading_clicked');
      closeModal();
    });
  }

  card.querySelector('[data-dm-soul-quiz-open]').addEventListener('click', openModal);

  modal.querySelectorAll('[data-dm-soul-quiz-close]').forEach(function (el) {
    el.addEventListener('click', closeModal);
  });

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && !modal.hidden) {
      closeModal();
    }
  });
})();
