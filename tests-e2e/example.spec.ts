import { test, expect } from '@playwright/test';

test('has title', async ({ page }) => {
  // Buka halaman utama aplikasi
  await page.goto('/');

  // Pastikan aplikasi terbuka dengan sukses dengan memeriksa title atau elemen utama
  // Sesuaikan title dengan spesifik aplikasi TargetBahasaCourse Anda
  await expect(page).toHaveTitle(/Laravel|Target Bahasa|IELTS/i); 
});

test('login page is accessible', async ({ page }) => {
  await page.goto('/login');
  
  // Pastikan tombol login terlihat
  await expect(page.locator('button[type="submit"]')).toBeVisible();
});
