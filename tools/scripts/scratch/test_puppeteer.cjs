const puppeteer = require('puppeteer');

(async () => {
    const browser = await puppeteer.launch({
        ignoreHTTPSErrors: true,
        headless: "new"
    });
    const page = await browser.newPage();
    
    page.on('console', msg => console.log('BROWSER CONSOLE:', msg.type(), msg.text()));
    page.on('pageerror', err => console.log('BROWSER ERROR:', err.toString()));
    
    await page.goto('https://targetbahasacourse.test/promo/test/writing/343', { waitUntil: 'networkidle2' });
    
    const formHTML = await page.evaluate(() => {
        const form = document.querySelector('form');
        return form ? form.outerHTML : 'No form found';
    });
    
    console.log('--- FORM HTML ---');
    console.log(formHTML);
    
    await browser.close();
})();
