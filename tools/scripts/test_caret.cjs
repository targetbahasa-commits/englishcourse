const { test, chromium } = require('@playwright/test');

(async () => {
  const browser = await chromium.launch({ headless: true });
  const context = await browser.newContext();
  const page = await context.newPage();

  await page.goto('http://localhost:8888/TargetBahasaCourse/public/assignments/ielts-academic/reading/material/1');
  await page.waitForTimeout(2000);

  // Inject a logger
  await page.evaluate(() => {
    window.lastWord = null;
    const panel = document.getElementById('questions-panel');
    panel.addEventListener('click', (e) => {
      let word = '';
      if (document.caretRangeFromPoint) {
        const range = document.caretRangeFromPoint(e.clientX, e.clientY);
        if (range && range.startContainer.nodeType === Node.TEXT_NODE) {
          word = range.startContainer.textContent.substring(
            Math.max(0, range.startOffset - 10),
            Math.min(range.startContainer.textContent.length, range.startOffset + 10)
          );
          window.lastWord = word;
          window.lastParams = { text: range.startContainer.textContent, offset: range.startOffset };
        }
      }
    });
  });

  // Click on "renovated" in Question 1 (x=1287, y=448 based on subagent log)
  await page.mouse.click(1287, 448);
  await page.waitForTimeout(500);

  const res = await page.evaluate(() => {
    return {
      word: window.lastWord,
      params: window.lastParams
    };
  });
  console.log("Result:", res);

  // also fetch normal console logs to see if my listener fired
  const logs = await page.evaluate(() => {
    // test whether the questions-panel listener exists by returning what we have
    return document.getElementById('questions-panel') ? 'exists' : 'missing';
  });
  console.log("Panel:", logs);

  await browser.close();
})();
