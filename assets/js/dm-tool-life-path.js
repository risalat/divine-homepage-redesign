(function () {
  const tool = document.querySelector('[data-dm-life-tool]');
  if (!tool) return;

  const paths = {
    1: {
      archetype: 'The Leader',
      tagline: 'Independent, ambitious, and innovative.',
      summary: 'Life Path 1 carries the energy of initiative, originality, and self-direction. You are here to build confidence, act with courage, and create a path that feels genuinely your own.',
      gift: 'You can start things before everyone else feels ready. Your natural gift is bold movement, decisive action, and the courage to go first.',
      lesson: 'The lesson is learning independence without isolation. Leadership works best when confidence stays open to collaboration.',
      step: 'Choose one idea you keep postponing and give it a simple first step today.',
      tags: ['leadership', 'independence', 'courage']
    },
    2: {
      archetype: 'The Diplomat',
      tagline: 'Cooperative, sensitive, and intuitive.',
      summary: 'Life Path 2 is connected with harmony, emotional intelligence, partnership, and quiet influence. Your strength often appears in the spaces between people.',
      gift: 'You sense tone, timing, and emotional undercurrents quickly. This makes you a natural peace-maker and thoughtful supporter.',
      lesson: 'Do not shrink your own needs to keep the room calm. Harmony should include you too.',
      step: 'Name one boundary kindly and clearly instead of hoping someone notices it.',
      tags: ['harmony', 'intuition', 'partnership']
    },
    3: {
      archetype: 'The Creative',
      tagline: 'Artistic, social, and expressive.',
      summary: 'Life Path 3 carries creative expression, humor, storytelling, beauty, and emotional brightness. You are here to translate feeling into something others can enjoy or understand.',
      gift: 'You bring color to ordinary moments. Words, art, charm, humor, and social warmth can become your tools.',
      lesson: 'The growth edge is consistency. Inspiration is wonderful, but finishing gives your creativity a home.',
      step: 'Capture one idea and turn it into something visible, even if it is small.',
      tags: ['creativity', 'expression', 'joy']
    },
    4: {
      archetype: 'The Builder',
      tagline: 'Practical, organized, and disciplined.',
      summary: 'Life Path 4 is the path of structure, patience, craft, and reliability. You are here to build something strong enough to last.',
      gift: 'You can turn scattered ideas into systems, plans, routines, and dependable results.',
      lesson: 'Avoid becoming so focused on control that life loses softness. Flexibility is not failure.',
      step: 'Improve one routine, workspace, or plan so your future self has less friction.',
      tags: ['structure', 'discipline', 'stability']
    },
    5: {
      archetype: 'The Adventurer',
      tagline: 'Dynamic, curious, and versatile.',
      summary: 'Life Path 5 carries movement, curiosity, freedom, and experience. You learn through life itself, not just by reading the map.',
      gift: 'You adapt quickly, notice possibilities, and bring fresh energy when things feel stuck.',
      lesson: 'Freedom becomes stronger when it has direction. Too many open doors can become their own little maze.',
      step: 'Pick one exciting option and give it a container: a date, a limit, or a clear next move.',
      tags: ['freedom', 'change', 'curiosity']
    },
    6: {
      archetype: 'The Nurturer',
      tagline: 'Caring, responsible, and community-oriented.',
      summary: 'Life Path 6 is connected with love, care, responsibility, beauty, home, and healing. You often feel called to protect and improve what matters.',
      gift: 'You notice what people need and can create comfort, beauty, and emotional safety around you.',
      lesson: 'Care is powerful, but over-responsibility can become a trap. You are not the unpaid manager of everyone\'s karma.',
      step: 'Do one generous thing, then do one thing that restores your own energy.',
      tags: ['care', 'home', 'healing']
    },
    7: {
      archetype: 'The Seeker',
      tagline: 'Spiritual, analytical, and introspective.',
      summary: 'Life Path 7 carries the energy of the seeker, drawn to meaning, reflection, study, and quiet wisdom. You often need depth before direction.',
      gift: 'You notice patterns other people miss and often understand what is unsaid beneath the obvious.',
      lesson: 'Do not hide in analysis forever. Your insight becomes powerful when it touches real life.',
      step: 'Give yourself quiet space, then choose one grounded action that supports your purpose.',
      tags: ['wisdom', 'intuition', 'truth']
    },
    8: {
      archetype: 'The Powerhouse',
      tagline: 'Ambitious, authoritative, and goal-driven.',
      summary: 'Life Path 8 is linked with power, achievement, money, leadership, and material mastery. You are here to learn how to use influence wisely.',
      gift: 'You can organize resources, make strategic decisions, and turn ambition into measurable progress.',
      lesson: 'Power without purpose feels empty. Let your goals serve something deeper than proving yourself.',
      step: 'Choose one practical financial, career, or leadership action that supports long-term stability.',
      tags: ['power', 'success', 'strategy']
    },
    9: {
      archetype: 'The Humanitarian',
      tagline: 'Compassionate, idealistic, and generous.',
      summary: 'Life Path 9 carries compassion, completion, wisdom, and service. You often feel life through a wide emotional lens.',
      gift: 'You can see the bigger picture and bring empathy to places where people feel unseen.',
      lesson: 'Compassion needs boundaries. You can love the world without carrying the whole thing in your backpack.',
      step: 'Release one old emotional loop and put energy toward a cause, creation, or person that truly matters.',
      tags: ['compassion', 'service', 'completion']
    },
    11: {
      archetype: 'The Inspired Intuitive',
      tagline: 'Visionary, sensitive, and spiritually electric.',
      summary: 'Master Number 11 carries heightened intuition, inspiration, and spiritual sensitivity. It can feel intense because the inner antenna is always picking something up.',
      gift: 'You can inspire people through insight, creativity, empathy, and a strong sense of what wants to emerge next.',
      lesson: 'Ground the lightning. Without rest, structure, and self-trust, inspiration can turn into nervous overload.',
      step: 'Write down one intuitive message, then support it with one grounded action.',
      tags: ['intuition', 'vision', 'inspiration'],
      link: 'https://divinemarkings.com/master-number-11-meaning/'
    },
    22: {
      archetype: 'The Master Builder',
      tagline: 'Visionary, practical, and capable of big impact.',
      summary: 'Master Number 22 blends spiritual vision with real-world construction. It is the number of building something meaningful, useful, and lasting.',
      gift: 'You can hold a large vision while still understanding systems, steps, timing, and practical execution.',
      lesson: 'Big purpose can create big pressure. Build steadily instead of trying to lift the whole temple in one afternoon.',
      step: 'Turn one large dream into three practical milestones you can actually track.',
      tags: ['vision', 'building', 'legacy'],
      link: 'https://divinemarkings.com/master-number-22-meaning/'
    },
    33: {
      archetype: 'The Master Teacher',
      tagline: 'Nurturing, wise, and devoted to uplift others.',
      summary: 'Master Number 33 is associated with compassionate teaching, healing, service, and heart-led leadership. It asks for love with wisdom, not self-sacrifice.',
      gift: 'You can encourage, guide, and uplift others in a way that feels deeply human and spiritually generous.',
      lesson: 'Do not confuse service with saving everyone. Your light works better when your own lamp has oil.',
      step: 'Share one useful lesson or kindness, then protect time for your own restoration.',
      tags: ['teaching', 'healing', 'compassion'],
      link: 'https://divinemarkings.com/master-number-33-meaning/'
    }
  };

  const form = tool.querySelector('[data-lp-form]');
  const input = tool.querySelector('[data-lp-birthdate]');
  const loading = tool.querySelector('[data-lp-loading]');
  const resultSection = tool.querySelector('[data-lp-result-section]');
  const submitButton = tool.querySelector('.dm-lp-submit');
  const masterLink = tool.querySelector('[data-lp-master-link]');
  let timer = null;

  function reduceNumber(num) {
    while (num > 9 && num !== 11 && num !== 22 && num !== 33) {
      num = String(num).split('').reduce(function (sum, digit) { return sum + Number(digit); }, 0);
    }
    return num;
  }

  function calculate(dateValue) {
    const parts = dateValue.split('-').map(Number);
    const year = parts[0];
    const month = parts[1];
    const day = parts[2];
    const monthReduced = reduceNumber(month);
    const dayReduced = reduceNumber(day);
    const yearReduced = reduceNumber(year);
    const rawTotal = monthReduced + dayReduced + yearReduced;
    const lifePath = reduceNumber(rawTotal);
    return { year, month, day, monthReduced, dayReduced, yearReduced, rawTotal, lifePath };
  }

  function updatePreview() {
    const value = input.value;
    const monthEl = tool.querySelector('[data-lp-preview-month]');
    const dayEl = tool.querySelector('[data-lp-preview-day]');
    const yearEl = tool.querySelector('[data-lp-preview-year]');
    if (!value) {
      monthEl.textContent = '--';
      dayEl.textContent = '--';
      yearEl.textContent = '----';
      return;
    }
    const parts = value.split('-');
    yearEl.textContent = parts[0];
    monthEl.textContent = parts[1];
    dayEl.textContent = parts[2];
  }

  function render(calc) {
    const data = paths[calc.lifePath] || paths[7];
    tool.querySelector('[data-lp-number]').textContent = calc.lifePath;
    tool.querySelector('[data-lp-archetype]').textContent = data.archetype;
    tool.querySelector('[data-lp-tagline]').textContent = data.tagline;
    tool.querySelector('[data-lp-title]').textContent = (calc.lifePath === 11 || calc.lifePath === 22 || calc.lifePath === 33 ? 'Master Number ' : 'Life Path ') + calc.lifePath;
    tool.querySelector('[data-lp-summary]').textContent = data.summary;
    tool.querySelector('[data-lp-month-reduced]').textContent = calc.monthReduced;
    tool.querySelector('[data-lp-day-reduced]').textContent = calc.dayReduced;
    tool.querySelector('[data-lp-year-reduced]').textContent = calc.yearReduced;
    tool.querySelector('[data-lp-total]').textContent = calc.rawTotal + ' → ' + calc.lifePath;
    tool.querySelector('[data-lp-gift]').textContent = data.gift;
    tool.querySelector('[data-lp-lesson]').textContent = data.lesson;
    tool.querySelector('[data-lp-step]').textContent = data.step;

    const tags = tool.querySelector('[data-lp-tags]');
    tags.innerHTML = '';
    data.tags.forEach(function (tag) {
      const span = document.createElement('span');
      span.textContent = tag;
      tags.appendChild(span);
    });

    if (data.link) {
      masterLink.href = data.link;
      masterLink.hidden = false;
    } else {
      masterLink.hidden = true;
    }

    resultSection.hidden = false;
    resultSection.classList.add('is-active');
    resultSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  function reveal() {
    if (!input.value) {
      input.focus();
      input.setAttribute('aria-invalid', 'true');
      return;
    }
    input.setAttribute('aria-invalid', 'false');

    if (timer) window.clearTimeout(timer);
    const calc = calculate(input.value);
    loading.hidden = false;
    resultSection.hidden = true;
    resultSection.classList.remove('is-active');
    loading.scrollIntoView({ behavior: 'smooth', block: 'center' });

    submitButton.disabled = true;
    submitButton.dataset.originalText = submitButton.dataset.originalText || submitButton.innerHTML;
    submitButton.innerHTML = 'Reading your numbers… <span aria-hidden="true">✦</span>';

    const delay = 4200 + Math.floor(Math.random() * 800);
    timer = window.setTimeout(function () {
      loading.hidden = true;
      submitButton.disabled = false;
      submitButton.innerHTML = submitButton.dataset.originalText || 'Reveal My Life Path <span aria-hidden="true">→</span>';
      render(calc);
    }, delay);
  }

  form.addEventListener('submit', function (event) {
    event.preventDefault();
    reveal();
  });

  input.addEventListener('input', updatePreview);

  tool.querySelector('[data-lp-random]').addEventListener('click', function () {
    const samples = ['1991-11-29', '1988-04-22', '1977-07-16', '2000-02-03', '1995-09-09', '1984-12-21'];
    input.value = samples[Math.floor(Math.random() * samples.length)];
    updatePreview();
    reveal();
  });

  updatePreview();
})();
