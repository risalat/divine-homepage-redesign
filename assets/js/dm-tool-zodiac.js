(function () {
  const tool = document.querySelector('[data-dm-zodiac-tool]');
  if (!tool) return;

  const compatibility = {
      Aries: {
        Aries: "Two Aries can be passionate and dynamic, but sometimes too impulsive.",
        Taurus: "Aries and Taurus have different paces, but can find common ground in their determination.",
        Gemini: "This duo can be fun and adventurous, but might struggle with consistency.",
        Cancer: "While Aries is fiery, Cancer is more sensitive, leading to potential conflicts in emotional needs.",
        Leo: "A match full of excitement and adventure, but both need to avoid power struggles.",
        Virgo: "This can be a challenging relationship as Aries is spontaneous and Virgo is practical.",
        Libra: "A natural balance, where Aries' assertiveness complements Libra's diplomacy.",
        Scorpio: "Highly passionate, but Aries' impulsiveness can clash with Scorpio's intensity.",
        Sagittarius: "A great match full of excitement, both share a love for adventure and freedom.",
        Capricorn: "Aries' quickness may frustrate Capricorn's more cautious approach, but they can learn from each other.",
        Aquarius: "Both are independent thinkers, making this relationship full of intellectual stimulation.",
        Pisces: "A dynamic match where Aries' energy can help Pisces get out of their shell, but they may have different emotional needs."
      },
      Taurus: {
        Aries: "Aries and Taurus have different paces, but can find common ground in their determination.",
        Taurus: "Two Taurus individuals share a deep understanding of each other's desire for stability and comfort.",
        Gemini: "Taurus may find Gemini's unpredictability hard to handle, but Gemini can help Taurus loosen up.",
        Cancer: "Taurus and Cancer make a great pair, both value emotional connection and security.",
        Leo: "This relationship may require some compromise, as Leo is more attention-seeking while Taurus is more reserved.",
        Virgo: "Both signs appreciate stability, which makes for a harmonious and grounded relationship.",
        Libra: "Taurus and Libra share an appreciation for beauty and harmony, but may have differing approaches to life.",
        Scorpio: "A powerful match where both partners are deeply committed, but their intensity can lead to conflict.",
        Sagittarius: "Taurus prefers stability while Sagittarius craves adventure, leading to potential friction.",
        Capricorn: "A well-matched couple, both value hard work and determination, leading to shared goals.",
        Aquarius: "Aquarius' intellectualism can sometimes feel detached for Taurus, who prefers a more grounded connection.",
        Pisces: "A gentle and harmonious pairing, where Taurus can provide stability and Pisces can offer emotional depth."
      },
      Gemini: {
    Aries: "This duo can be fun and adventurous, but might struggle with consistency.",
    Taurus: "Taurus may find Gemini's unpredictability hard to handle, but Gemini can help Taurus loosen up.",
    Gemini: "Two Geminis will find endless excitement together, though they may lack consistency.",
    Cancer: "Cancer may struggle with Gemini's flighty nature, but both can learn to balance each other.",
    Leo: "Leo's need for attention clashes with Gemini's desire for freedom, but they can have a fun dynamic.",
    Virgo: "Virgo may find Gemini's spontaneity chaotic, but Gemini can bring joy and flexibility to Virgo's life.",
    Libra: "Gemini and Libra are both intellectual and social, making for an easy, communicative relationship.",
    Scorpio: "Gemini's lighthearted nature may not match Scorpio's intensity, but both can enjoy stimulating conversations.",
    Sagittarius: "Gemini and Sagittarius make a perfect pair for adventure and intellectual pursuits.",
    Capricorn: "Capricorn may find Gemini's carefree attitude frustrating, but Gemini brings excitement to Capricorn's life.",
    Aquarius: "Both are intellectually driven, and this pairing can lead to a great balance of deep conversations and freedom.",
    Pisces: "Pisces may struggle with Gemini's lack of emotional depth, but Gemini can help Pisces get out of their shell."
  },
  Cancer: {
    Aries: "While Aries is fiery, Cancer is more sensitive, leading to potential conflicts in emotional needs.",
    Taurus: "Taurus and Cancer make a great pair, both value emotional connection and security.",
    Gemini: "Cancer may struggle with Gemini's flighty nature, but both can learn to balance each other.",
    Cancer: "Two Cancerians can create a nurturing, loving home, though they may need to guard against emotional over-sensitivity.",
    Leo: "Leo's need for attention can clash with Cancer's need for security, but Cancer offers emotional support to Leo.",
    Virgo: "Cancer and Virgo share a love for family and stability, making for a caring and grounded pairing.",
    Libra: "Cancer's emotional depth complements Libra's need for peace and harmony, creating a loving dynamic.",
    Scorpio: "This is a passionate and deep connection, where both signs can bond over shared emotional intensity.",
    Sagittarius: "Sagittarius' need for freedom may clash with Cancer's need for security, but they can create balance with effort.",
    Capricorn: "Cancer and Capricorn make a strong pairing, as Cancer nurtures and Capricorn brings structure and stability.",
    Aquarius: "Aquarius and Cancer may struggle with differing emotional needs, but can create mutual understanding through compassion.",
    Pisces: "Cancer and Pisces form an intuitive and harmonious connection, both understanding each other's emotional world."
  },
  Leo: {
    Aries: "A match full of excitement and adventure, but both need to avoid power struggles.",
    Taurus: "This relationship may require some compromise, as Leo is more attention-seeking while Taurus is more reserved.",
    Gemini: "Leo's need for attention clashes with Gemini's desire for freedom, but they can have a fun dynamic.",
    Cancer: "Leo's need for attention can clash with Cancer's need for security, but Cancer offers emotional support to Leo.",
    Leo: "Two Leos together are a powerful and vibrant match, but both need to avoid fighting for dominance.",
    Virgo: "Leo's boldness can clash with Virgo's practicality, but they can balance each other with effort.",
    Libra: "Leo and Libra share a love for beauty and romance, making them a harmonious match.",
    Scorpio: "Leo and Scorpio can be a passionate pair, but they need to avoid ego clashes and power struggles.",
    Sagittarius: "A fun, adventurous pairing where both partners bring excitement to each other's lives.",
    Capricorn: "Leo's need for attention may clash with Capricorn's reserved nature, but they can balance each other well.",
    Aquarius: "Leo and Aquarius may be opposites, but their differences can make them a strong and stimulating match.",
    Pisces: "Leo and Pisces can complement each other, with Leo bringing strength and Pisces offering emotional depth."
  },
  Virgo: {
    Aries: "This can be a challenging relationship as Aries is spontaneous and Virgo is practical.",
    Taurus: "Both signs appreciate stability, which makes for a harmonious and grounded relationship.",
    Gemini: "Virgo may find Gemini's unpredictability chaotic, but Gemini can bring joy and flexibility to Virgo's life.",
    Cancer: "Cancer and Virgo share a love for family and stability, making for a caring and grounded pairing.",
    Leo: "Leo's boldness can clash with Virgo's practicality, but they can balance each other with effort.",
    Virgo: "Two Virgos together create a practical and organized partnership, though they need to avoid being too critical.",
    Libra: "Virgo may find Libra's social nature a bit too free-spirited, but they can create balance through mutual understanding.",
    Scorpio: "Virgo and Scorpio form a grounded, intense connection, but both must avoid emotional standoffs.",
    Sagittarius: "Virgo's practicality may clash with Sagittarius' love for freedom, but they can learn from each other.",
    Capricorn: "A solid pairing, with Virgo's attention to detail complementing Capricorn's ambition and determination.",
    Aquarius: "Virgo may find Aquarius too eccentric, but Aquarius brings fresh perspective to Virgo's structured life.",
    Pisces: "Virgo and Pisces complement each other, with Virgo offering practicality and Pisces offering emotional depth."
  },
  Libra: {
    Aries: "A natural balance, where Aries' assertiveness complements Libra's diplomacy.",
    Taurus: "Taurus and Libra share an appreciation for beauty and harmony, but may have differing approaches to life.",
    Gemini: "Gemini and Libra are both intellectual and social, making for an easy, communicative relationship.",
    Cancer: "Cancer's emotional depth complements Libra's need for peace and harmony, creating a loving dynamic.",
    Leo: "Leo and Libra share a love for beauty and romance, making them a harmonious match.",
    Libra: "Two Libras together can create a peaceful, loving relationship, where both value balance and harmony.",
    Scorpio: "Libra and Scorpio can create an intriguing dynamic, with Libra bringing charm and Scorpio offering depth.",
    Sagittarius: "Libra and Sagittarius share an adventurous spirit, but they may need to find common ground in emotional needs.",
    Capricorn: "Libra's social nature may contrast with Capricorn's focus on work, but they can support each other well.",
    Aquarius: "Libra and Aquarius form an intellectual and free-spirited connection, offering mutual understanding.",
    Pisces: "Libra and Pisces form a compassionate pairing, where Libra provides harmony and Pisces offers emotional depth."
  },
  Scorpio: {
    Aries: "Highly passionate, but Aries' impulsiveness can clash with Scorpio's intensity.",
    Taurus: "A powerful match where both partners are deeply committed, but their intensity can lead to conflict.",
    Gemini: "Gemini's lighthearted nature may not match Scorpio's intensity, but both can enjoy stimulating conversations.",
    Cancer: "This is a passionate and deep connection, where both signs can bond over shared emotional intensity.",
    Leo: "Leo and Scorpio can be a passionate pair, but they need to avoid ego clashes and power struggles.",
    Virgo: "Virgo and Scorpio form a grounded, intense connection, but both must avoid emotional standoffs.",
    Libra: "Libra and Scorpio can create an intriguing dynamic, with Libra bringing charm and Scorpio offering depth.",
    Sagittarius: "Scorpio's intensity may clash with Sagittarius' carefree nature, but they can complement each other well.",
    Capricorn: "Scorpio and Capricorn form a powerful, grounded partnership, both seeking success and loyalty.",
    Aquarius: "Scorpio and Aquarius can be a challenging pairing, as Aquarius' intellectualism may conflict with Scorpio's emotional depth.",
    Pisces: "Scorpio and Pisces form a deeply spiritual and emotional connection, understanding each other's inner world."
  },
  Sagittarius: {
    Aries: "A great match full of excitement, both share a love for adventure and freedom.",
    Taurus: "Taurus prefers stability while Sagittarius craves adventure, leading to potential friction.",
    Gemini: "Gemini and Sagittarius make a perfect pair for adventure and intellectual pursuits.",
    Cancer: "Sagittarius' need for freedom may clash with Cancer's need for security, but they can create balance with effort.",
    Leo: "A fun, adventurous pairing where both partners bring excitement to each other's lives.",
    Virgo: "Sagittarius' love for freedom can conflict with Virgo's practical nature, but they can learn from each other.",
    Libra: "Libra and Sagittarius share an adventurous spirit, but they may need to find common ground in emotional needs.",
    Scorpio: "Scorpio's intensity may clash with Sagittarius' carefree nature, but they can complement each other well.",
    Capricorn: "Sagittarius' desire for freedom may cause friction with Capricorn's focus on work, but they can balance each other.",
    Aquarius: "Sagittarius and Aquarius share a love for exploration and intellectual stimulation, making for a great pairing.",
    Pisces: "Sagittarius and Pisces can have a fun, adventurous connection, but they may need to work on emotional depth."
  },
  Capricorn: {
    Aries: "Aries' quickness may frustrate Capricorn's more cautious approach, but they can learn from each other.",
    Taurus: "A well-matched couple, both value hard work and determination, leading to shared goals.",
    Gemini: "Capricorn may find Gemini's carefree attitude frustrating, but Gemini brings excitement to Capricorn's life.",
    Cancer: "Cancer and Capricorn make a strong pairing, as Cancer nurtures and Capricorn brings structure and stability.",
    Leo: "Leo's need for attention may clash with Capricorn's reserved nature, but they can balance each other well.",
    Virgo: "A solid pairing, with Virgo's attention to detail complementing Capricorn's ambition and determination.",
    Libra: "Capricorn's reserved nature may contrast with Libra's social nature, but they can support each other well.",
    Scorpio: "Scorpio and Capricorn form a powerful, grounded partnership, both seeking success and loyalty.",
    Sagittarius: "Sagittarius' desire for freedom may cause friction with Capricorn's focus on work, but they can balance each other.",
    Aquarius: "Capricorn and Aquarius may clash at first, as Capricorn is more traditional and Aquarius is more progressive.",
    Pisces: "Capricorn and Pisces can balance each other, with Capricorn providing structure and Pisces offering creativity and empathy."
  },
  Aquarius: {
    Aries: "Both are independent thinkers, making this relationship full of intellectual stimulation.",
    Taurus: "Aquarius' intellectualism can sometimes feel detached for Taurus, who prefers a more grounded connection.",
    Gemini: "Both are intellectually driven, and this pairing can lead to a great balance of deep conversations and freedom.",
    Cancer: "Aquarius and Cancer may struggle with differing emotional needs, but can create mutual understanding through compassion.",
    Leo: "Leo and Aquarius may be opposites, but their differences can make them a strong and stimulating match.",
    Virgo: "Virgo may find Aquarius too eccentric, but Aquarius brings fresh perspective to Virgo's structured life.",
    Libra: "Libra and Aquarius form an intellectual and free-spirited connection, offering mutual understanding.",
    Scorpio: "Scorpio and Aquarius can be a challenging pairing, as Aquarius' intellectualism may conflict with Scorpio's emotional depth.",
    Sagittarius: "Sagittarius and Aquarius share a love for exploration and intellectual stimulation, making for a great pairing.",
    Capricorn: "Capricorn and Aquarius may clash at first, as Capricorn is more traditional and Aquarius is more progressive.",
    Pisces: "Aquarius and Pisces are a dynamic duo where Aquarius provides ideas and Pisces offers emotional depth."
  },
  Pisces: {
    Aries: "A dynamic match where Aries' energy can help Pisces get out of their shell, but they may have different emotional needs.",
    Taurus: "A gentle and harmonious pairing, where Taurus can provide stability and Pisces can offer emotional depth.",
    Gemini: "Pisces may struggle with Gemini's lack of emotional depth, but Gemini can help Pisces get out of their shell.",
    Cancer: "Cancer and Pisces form an intuitive and harmonious connection, both understanding each other's emotional world.",
    Leo: "Leo and Pisces can complement each other, with Leo bringing strength and Pisces offering emotional depth.",
    Virgo: "Virgo and Pisces complement each other, with Virgo offering practicality and Pisces offering emotional depth.",
    Libra: "Libra and Pisces form a compassionate pairing, where Libra provides harmony and Pisces offers emotional depth.",
    Scorpio: "Scorpio and Pisces form a deeply spiritual and emotional connection, understanding each other's inner world.",
    Sagittarius: "Sagittarius and Pisces can have a fun, adventurous connection, but they may need to work on emotional depth.",
    Capricorn: "Capricorn and Pisces can balance each other, with Capricorn providing structure and Pisces offering creativity and empathy.",
    Aquarius: "Aquarius and Pisces are a dynamic duo where Aquarius provides ideas and Pisces offers emotional depth."
  }
    };

  const signs = {
    Aries: { glyph: '♈', element: 'Fire', mode: 'Cardinal', trait: 'Bold spark' },
    Taurus: { glyph: '♉', element: 'Earth', mode: 'Fixed', trait: 'Grounded devotion' },
    Gemini: { glyph: '♊', element: 'Air', mode: 'Mutable', trait: 'Curious connection' },
    Cancer: { glyph: '♋', element: 'Water', mode: 'Cardinal', trait: 'Tender loyalty' },
    Leo: { glyph: '♌', element: 'Fire', mode: 'Fixed', trait: 'Radiant romance' },
    Virgo: { glyph: '♍', element: 'Earth', mode: 'Mutable', trait: 'Practical care' },
    Libra: { glyph: '♎', element: 'Air', mode: 'Cardinal', trait: 'Balanced harmony' },
    Scorpio: { glyph: '♏', element: 'Water', mode: 'Fixed', trait: 'Deep intensity' },
    Sagittarius: { glyph: '♐', element: 'Fire', mode: 'Mutable', trait: 'Adventurous spirit' },
    Capricorn: { glyph: '♑', element: 'Earth', mode: 'Cardinal', trait: 'Steady ambition' },
    Aquarius: { glyph: '♒', element: 'Air', mode: 'Fixed', trait: 'Independent mind' },
    Pisces: { glyph: '♓', element: 'Water', mode: 'Mutable', trait: 'Dreamy empathy' }
  };

  const order = Object.keys(signs);
  const opposites = { Aries: 'Libra', Taurus: 'Scorpio', Gemini: 'Sagittarius', Cancer: 'Capricorn', Leo: 'Aquarius', Virgo: 'Pisces', Libra: 'Aries', Scorpio: 'Taurus', Sagittarius: 'Gemini', Capricorn: 'Cancer', Aquarius: 'Leo', Pisces: 'Virgo' };
  const scoreOverrides = {
    'Aries|Leo': 88, 'Aries|Sagittarius': 92, 'Aries|Libra': 82, 'Aries|Cancer': 58, 'Aries|Capricorn': 61,
    'Taurus|Cancer': 90, 'Taurus|Virgo': 88, 'Taurus|Capricorn': 91, 'Taurus|Scorpio': 84, 'Taurus|Aquarius': 54,
    'Gemini|Libra': 91, 'Gemini|Aquarius': 89, 'Gemini|Sagittarius': 86, 'Gemini|Capricorn': 55, 'Gemini|Pisces': 58,
    'Cancer|Pisces': 93, 'Cancer|Scorpio': 91, 'Cancer|Capricorn': 83, 'Cancer|Aquarius': 55,
    'Leo|Libra': 87, 'Leo|Sagittarius': 90, 'Leo|Aquarius': 82, 'Leo|Scorpio': 66,
    'Virgo|Capricorn': 90, 'Virgo|Taurus': 88, 'Virgo|Pisces': 80, 'Virgo|Sagittarius': 57,
    'Libra|Aquarius': 89, 'Libra|Sagittarius': 83, 'Libra|Scorpio': 69,
    'Scorpio|Pisces': 92, 'Scorpio|Capricorn': 88, 'Scorpio|Aquarius': 56,
    'Sagittarius|Aquarius': 90, 'Sagittarius|Pisces': 66,
    'Capricorn|Pisces': 84, 'Capricorn|Aquarius': 60,
    'Aquarius|Pisces': 70
  };

  function pairKey(a, b) {
    return order.indexOf(a) <= order.indexOf(b) ? a + '|' + b : b + '|' + a;
  }

  function compatibleElements(a, b) {
    return (a === 'Fire' && b === 'Air') || (a === 'Air' && b === 'Fire') || (a === 'Earth' && b === 'Water') || (a === 'Water' && b === 'Earth');
  }

  function computeScore(a, b) {
    const key = pairKey(a, b);
    if (scoreOverrides[key]) return scoreOverrides[key];

    const metaA = signs[a];
    const metaB = signs[b];
    let score = 64;

    if (a === b) score += 12;
    if (metaA.element === metaB.element) score += 18;
    if (compatibleElements(metaA.element, metaB.element)) score += 12;
    if (opposites[a] === b) score += 10;
    if (metaA.mode === metaB.mode && a !== b) score -= 4;
    if ((metaA.element === 'Fire' && metaB.element === 'Water') || (metaA.element === 'Water' && metaB.element === 'Fire')) score -= 7;
    if ((metaA.element === 'Air' && metaB.element === 'Earth') || (metaA.element === 'Earth' && metaB.element === 'Air')) score -= 5;

    return Math.max(48, Math.min(95, score));
  }

  function summaryFor(a, b) {
    if (a === b) {
      return (compatibility[a] && compatibility[a][a]) || `Two ${a} signs understand each other's rhythm quickly, but the shared strengths can become shared blind spots too.`;
    }
    return (compatibility[a] && compatibility[a][b]) || (compatibility[b] && compatibility[b][a]) || `${a} and ${b} can create an interesting match when both people stay curious, honest, and willing to learn each other's rhythm.`;
  }

  function chemistryLabel(score) {
    if (score >= 88) return 'Power Match';
    if (score >= 78) return 'Strong Flow';
    if (score >= 66) return 'Interesting Chemistry';
    return 'Growth Match';
  }

  function strengthFor(a, b, score) {
    const ea = signs[a].element;
    const eb = signs[b].element;
    if (a === b) return `Shared ${signs[a].trait.toLowerCase()} creates instant recognition, similar priorities, and a familiar emotional language.`;
    if (ea === eb) return `Both signs move through the world with the same elemental rhythm, so attraction and mutual understanding can feel natural.`;
    if (compatibleElements(ea, eb)) return `${ea} and ${eb} often support each other beautifully, creating a bond that can feel both energizing and emotionally useful.`;
    if (score >= 78) return `The differences are noticeable, but they add fascination, momentum, and a sense that each person brings something the other needs.`;
    return `This pairing can be memorable because it asks both people to slow down, listen closely, and grow past first impressions.`;
  }

  function communicationFor(a, b) {
    const ma = signs[a].mode;
    const mb = signs[b].mode;
    if (ma === mb) return `Both signs tend to initiate, hold, or adapt energy in a similar way, which can make conversations intense but familiar.`;
    if (signs[a].element === 'Air' || signs[b].element === 'Air') return `Words matter here. Clear explanations, humor, and honest curiosity help the connection stay light instead of tangled.`;
    if (signs[a].element === 'Water' || signs[b].element === 'Water') return `Tone matters as much as words. Emotional reassurance keeps the connection open and safe.`;
    return `Practical follow-through matters. This match grows stronger when promises are clear and actions match the conversation.`;
  }

  function growthFor(a, b, score) {
    if (a === b) return `Avoid assuming the other person should react exactly like you. Similarity is comforting, but individuality still needs room.`;
    if (opposites[a] === b) return `Opposite signs can be magnetic, but the lesson is balance. Do not try to win the relationship like a debate.`;
    if (score >= 85) return `The chemistry is strong, so the biggest growth edge is staying grounded when the spark gets dramatic.`;
    if (score >= 70) return `This match improves when both people name expectations early instead of expecting the other to magically read the sky map.`;
    return `Patience is the secret ingredient. Move slowly, ask better questions, and do not treat different needs as rejection.`;
  }

  function updatePreview(preview, sign) {
    const meta = signs[sign];
    preview.querySelector('.dm-zc-sign-preview__glyph').textContent = meta.glyph;
    preview.querySelector('strong').textContent = sign;
    preview.querySelector('em').textContent = `${meta.element} • ${meta.mode}`;
  }

  function renderResult(scrollToResult) {
    const signOne = tool.querySelector('[data-zc-sign-one]').value;
    const signTwo = tool.querySelector('[data-zc-sign-two]').value;
    const score = computeScore(signOne, signTwo);
    const resultSection = tool.querySelector('[data-zc-result-section]');
    const scoreRing = tool.querySelector('[data-zc-score-ring]');
    const scoreText = tool.querySelector('[data-zc-score]');
    const title = tool.querySelector('[data-zc-title]');
    const summary = tool.querySelector('[data-zc-summary]');
    const tags = tool.querySelector('[data-zc-score-tags]');

    updatePreview(tool.querySelector('[data-zc-preview-one]'), signOne);
    updatePreview(tool.querySelector('[data-zc-preview-two]'), signTwo);

    scoreRing.style.setProperty('--score', score);
    scoreText.textContent = score + '%';
    title.textContent = `${signOne} + ${signTwo}`;
    summary.textContent = summaryFor(signOne, signTwo);
    tool.querySelector('[data-zc-strength]').textContent = strengthFor(signOne, signTwo, score);
    tool.querySelector('[data-zc-communication]').textContent = communicationFor(signOne, signTwo);
    tool.querySelector('[data-zc-growth]').textContent = growthFor(signOne, signTwo, score);

    const tagValues = [chemistryLabel(score), signs[signOne].element, signs[signTwo].element].filter((value, index, arr) => arr.indexOf(value) === index);
    tags.innerHTML = '';
    tagValues.forEach(function (tag) {
      const span = document.createElement('span');
      span.textContent = tag;
      tags.appendChild(span);
    });

    resultSection.hidden = false;
    resultSection.classList.add('is-active');

    if (scrollToResult) {
      resultSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  }

  const form = tool.querySelector('[data-zc-form]');
  const signOne = tool.querySelector('[data-zc-sign-one]');
  const signTwo = tool.querySelector('[data-zc-sign-two]');
  const loading = tool.querySelector('[data-zc-loading]');
  const resultSection = tool.querySelector('[data-zc-result-section]');
  const submitButton = tool.querySelector('.dm-zc-submit');
  let zodiacTimer = null;

  function revealWithDelay(scrollToResult) {
    if (zodiacTimer) window.clearTimeout(zodiacTimer);

    if (loading) loading.hidden = false;
    if (resultSection) {
      resultSection.hidden = true;
      resultSection.classList.remove('is-active');
    }

    if (submitButton) {
      submitButton.disabled = true;
      submitButton.dataset.originalText = submitButton.dataset.originalText || submitButton.innerHTML;
      submitButton.innerHTML = 'Reading the stars… <span aria-hidden="true">✦</span>';
    }

    if (loading && scrollToResult) {
      loading.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    const delay = 4200 + Math.floor(Math.random() * 800);
    zodiacTimer = window.setTimeout(function () {
      if (loading) loading.hidden = true;
      renderResult(scrollToResult);
      if (submitButton) {
        submitButton.disabled = false;
        submitButton.innerHTML = submitButton.dataset.originalText || 'Reveal Compatibility <span aria-hidden="true">→</span>';
      }
    }, delay);
  }

  form.addEventListener('submit', function (event) {
    event.preventDefault();
    revealWithDelay(true);
  });

  [signOne, signTwo].forEach(function (select) {
    select.addEventListener('change', function () {
      updatePreview(tool.querySelector('[data-zc-preview-one]'), signOne.value);
      updatePreview(tool.querySelector('[data-zc-preview-two]'), signTwo.value);
    });
  });

  tool.querySelector('[data-zc-random]').addEventListener('click', function () {
    let first = order[Math.floor(Math.random() * order.length)];
    let second = order[Math.floor(Math.random() * order.length)];
    signOne.value = first;
    signTwo.value = second;
    updatePreview(tool.querySelector('[data-zc-preview-one]'), signOne.value);
    updatePreview(tool.querySelector('[data-zc-preview-two]'), signTwo.value);
    revealWithDelay(true);
  });

  tool.querySelectorAll('[data-zc-pairs] button').forEach(function (button) {
    button.addEventListener('click', function () {
      signOne.value = button.getAttribute('data-pair-one');
      signTwo.value = button.getAttribute('data-pair-two');
      updatePreview(tool.querySelector('[data-zc-preview-one]'), signOne.value);
      updatePreview(tool.querySelector('[data-zc-preview-two]'), signTwo.value);
      revealWithDelay(true);
    });
  });

  updatePreview(tool.querySelector('[data-zc-preview-one]'), signOne.value);
  updatePreview(tool.querySelector('[data-zc-preview-two]'), signTwo.value);
})();
