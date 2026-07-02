import { chromium } from 'playwright';
const BASE = process.env.BASE_URL || 'https://new-ecommerce.test';
const browser = await chromium.launch();
const ctx = await browser.newContext({ ignoreHTTPSErrors: true });
const page = await ctx.newPage();
async function login() {
  await page.goto(`${BASE}/login`, { waitUntil: 'domcontentloaded' });
  await page.fill('input[type="email"]', 'admin@sheffieldafrica.com');
  await page.fill('input[type="password"]', 'password');
  await page.click('button[type="submit"]');
  await page.waitForLoadState('domcontentloaded');
  await page.waitForTimeout(800);
}
try {
  await login();
  for (const w of [390, 600]) {
    await page.setViewportSize({ width: w, height: 900 });
    await page.goto(`${BASE}/admin/pages/create`, { waitUntil: 'domcontentloaded' });
    await page.waitForTimeout(800);
    await page.screenshot({ path: (process.env.DIR || '.') + `/pg-${w}.png`, clip: { x: 0, y: 0, width: w, height: 260 } });
    console.log('shot', w);
  }
} catch (e) { console.error('ERROR:', e.message); } finally { await browser.close(); }
