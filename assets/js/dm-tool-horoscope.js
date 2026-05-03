(function () {
  const tool = document.querySelector('[data-dm-horo-tool]');
  if (!tool) return;

  const signData = {
    aries: { name: 'Aries', glyph: '♈', trait: 'Bold, fiery, and ready to move.', tags: ['courage', 'momentum', 'spark'], focus: 'Take one clear step instead of waiting for perfect certainty.', relationship: 'Direct honesty lands best when paired with warmth.', step: 'Act on the thing you already know needs your attention.' },
    taurus: { name: 'Taurus', glyph: '♉', trait: 'Grounded, steady, and beautifully persistent.', tags: ['stability', 'comfort', 'growth'], focus: 'Choose steady progress over dramatic reinvention.', relationship: 'Reliability speaks louder than big promises today.', step: 'Make one small improvement to your space, routine, or plan.' },
    gemini: { name: 'Gemini', glyph: '♊', trait: 'Curious, quick, and ready for conversation.', tags: ['ideas', 'connection', 'movement'], focus: 'A useful conversation may open a better option.', relationship: 'Ask the extra question instead of guessing the answer.', step: 'Write down the idea before it flies away wearing sunglasses.' },
    cancer: { name: 'Cancer', glyph: '♋', trait: 'Intuitive, caring, and emotionally wise.', tags: ['home', 'intuition', 'care'], focus: 'Protect your peace without closing your heart.', relationship: 'A soft check-in can repair more than a grand speech.', step: 'Listen to your body before agreeing to more emotional labor.' },
    leo: { name: 'Leo', glyph: '♌', trait: 'Radiant, expressive, and generous-hearted.', tags: ['confidence', 'joy', 'creation'], focus: 'Let yourself be seen where your light is actually useful.', relationship: 'Warmth works better than performance today.', step: 'Share one creative thing, even if it is not perfectly polished.' },
    virgo: { name: 'Virgo', glyph: '♍', trait: 'Practical, observant, and quietly powerful.', tags: ['clarity', 'routine', 'detail'], focus: 'A small fix may bring a surprisingly big relief.', relationship: 'Helpful is lovely. Over-managing is less lovely. Tiny distinction, big magic.', step: 'Choose one messy thing and give it a simple structure.' },
    libra: { name: 'Libra', glyph: '♎', trait: 'Balanced, diplomatic, and beauty-seeking.', tags: ['harmony', 'choice', 'beauty'], focus: 'Make the decision that brings real balance, not just temporary peace.', relationship: 'Kind clarity beats elegant avoidance today.', step: 'Name what you want before negotiating around everyone else.' },
    scorpio: { name: 'Scorpio', glyph: '♏', trait: 'Deep, focused, and transformational.', tags: ['depth', 'truth', 'power'], focus: 'Trust what is revealed, especially if it confirms a pattern.', relationship: 'Intensity softens when honesty arrives early.', step: 'Release one control loop and keep the lesson.' },
    sagittarius: { name: 'Sagittarius', glyph: '♐', trait: 'Adventurous, optimistic, and truth-seeking.', tags: ['freedom', 'truth', 'adventure'], focus: 'A wider perspective helps you stop wrestling with a tiny corner of the map.', relationship: 'Say the truth kindly, not like a flaming arrow at brunch.', step: 'Do one thing that expands your view: read, walk, ask, plan, explore.' },
    capricorn: { name: 'Capricorn', glyph: '♑', trait: 'Disciplined, grounded, and quietly ambitious.', tags: ['structure', 'ambition', 'patience'], focus: 'Long-term progress wins over short-term pressure.', relationship: 'Support is stronger when you do not turn every feeling into a task list.', step: 'Choose the practical move that future-you will thank you for.' },
    aquarius: { name: 'Aquarius', glyph: '♒', trait: 'Independent, inventive, and future-minded.', tags: ['ideas', 'freedom', 'vision'], focus: 'Your odd idea may be the useful one. Give it a test, not a TED Talk.', relationship: 'Connection grows when you explain the thought behind the distance.', step: 'Turn one bright concept into a tiny experiment.' },
    pisces: { name: 'Pisces', glyph: '♓', trait: 'Dreamy, compassionate, and spiritually sensitive.', tags: ['intuition', 'dreams', 'compassion'], focus: 'Your intuition needs grounding so it does not float into fog.', relationship: 'Gentleness is good. Clarity keeps it from becoming confusion.', step: 'Write down the feeling, then choose one practical response.' }
  };

  const messages = {
    aries: ['your passion ignites new beginnings today.', 'your courage fuels bold adventures ahead.', 'let your dynamic spirit overcome a lingering challenge.', 'your determination leads you to a useful opportunity.', 'your inner fire knows the first move.'],
    taurus: ['your calm determination sets the tone for a productive day.', 'stability helps you see which choice is worth keeping.', 'your patience turns pressure into progress.', 'trust the steady approach and enjoy small wins.', 'comfort and discipline can work together today.'],
    gemini: ['your curious mind opens doors to new ideas today.', 'a conversation may shift the whole mood.', 'your adaptable energy helps you move around a blockage.', 'communication brings the clue you need.', 'your quick thinking turns a small spark into a path.'],
    cancer: ['trust your intuition and let your caring nature guide you today.', 'your inner world has useful information. Listen gently.', 'nurture what matters without carrying everything.', 'emotional honesty can create real relief.', 'home, heart, and intuition ask for your attention.'],
    leo: ['your radiant energy lights up the room today.', 'confidence grows when you create instead of compare.', 'your warm heart can turn a tense moment softer.', 'lead with generosity and your light travels farther.', 'a creative spark wants the spotlight.'],
    virgo: ['your careful eye finds the detail that matters today.', 'order brings calm, but perfection can wait.', 'a simple routine may unlock a better mood.', 'your practical wisdom helps untangle confusion.', 'focus on one useful fix rather than the whole mountain.'],
    libra: ['balance returns when you stop negotiating against yourself.', 'beauty, fairness, and clarity guide the day.', 'a kind conversation can reset the tone.', 'choose harmony with honesty, not harmony with silence.', 'your graceful approach opens a smoother path.'],
    scorpio: ['your deep focus reveals what is really going on today.', 'transformation begins with one honest admission.', 'your intuition sees beneath the surface.', 'power returns when you stop chasing what refuses to be clear.', 'a hidden pattern becomes easier to name.'],
    sagittarius: ['your adventurous spirit wants more room today.', 'optimism grows when you look beyond the immediate problem.', 'a new idea, place, or plan refreshes your energy.', 'truth feels freeing when spoken with care.', 'your path expands when curiosity leads.'],
    capricorn: ['your disciplined nature lays the groundwork for a useful day.', 'steady effort brings more peace than rushing.', 'structure turns ambition into something real.', 'focus on the next practical step, not the entire staircase.', 'your patience is doing more work than you think.'],
    aquarius: ['your innovative mind sees an option others miss.', 'independence feels better when it includes honest connection.', 'your future-focused thinking brings a fresh solution.', 'a strange idea may be exactly the right one to test.', 'give your originality a small practical outlet.'],
    pisces: ['your compassionate heart guides you toward a gentler choice.', 'dreams, feelings, and subtle signs carry useful clues.', 'your creativity softens a hard edge today.', 'intuition speaks clearly when you give it quiet space.', 'empathy is a gift, but boundaries keep it sustainable.']
  };

  const form = tool.querySelector('[data-horo-form]');
  const select = tool.querySelector('[data-horo-sign]');
  const loading = tool.querySelector('[data-horo-loading]');
  const result = tool.querySelector('[data-horo-result-section]');
  const submit = tool.querySelector('.dm-horo-submit');
  let timer = null;

  function getMessage(sign) {
    const dayIndex = (new Date().getDate() - 1) % messages[sign].length;
    const data = signData[sign];
    return data.name + ', ' + messages[sign][dayIndex];
  }

  function render(sign) {
    const data = signData[sign] || signData.aries;
    tool.querySelector('[data-horo-glyph]').textContent = data.glyph;
    tool.querySelector('[data-horo-sign-name]').textContent = data.name;
    tool.querySelector('[data-horo-sign-trait]').textContent = data.trait;
    tool.querySelector('[data-horo-title]').textContent = data.name + ' Daily Horoscope';
    tool.querySelector('[data-horo-message]').textContent = getMessage(sign);
    tool.querySelector('[data-horo-focus]').textContent = data.focus;
    tool.querySelector('[data-horo-relationship]').textContent = data.relationship;
    tool.querySelector('[data-horo-step]').textContent = data.step;
    const tags = tool.querySelector('[data-horo-tags]');
    tags.innerHTML = '';
    data.tags.forEach(function (tag) {
      const span = document.createElement('span');
      span.textContent = tag;
      tags.appendChild(span);
    });
    result.hidden = false;
    result.classList.add('is-active');
    result.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  function reveal(sign) {
    if (!sign) {
      select.focus();
      return;
    }
    if (timer) window.clearTimeout(timer);
    loading.hidden = false;
    result.hidden = true;
    loading.scrollIntoView({ behavior: 'smooth', block: 'center' });
    submit.disabled = true;
    submit.dataset.originalText = submit.dataset.originalText || submit.innerHTML;
    submit.innerHTML = 'Reading today\'s sky… <span aria-hidden="true">✦</span>';
    const delay = 4200 + Math.floor(Math.random() * 800);
    timer = window.setTimeout(function () {
      loading.hidden = true;
      submit.disabled = false;
      submit.innerHTML = submit.dataset.originalText;
      render(sign);
    }, delay);
  }

  form.addEventListener('submit', function (event) {
    event.preventDefault();
    reveal(select.value);
  });
  tool.querySelector('[data-horo-random]').addEventListener('click', function () {
    const keys = Object.keys(signData);
    select.value = keys[Math.floor(Math.random() * keys.length)];
    reveal(select.value);
  });
})();
