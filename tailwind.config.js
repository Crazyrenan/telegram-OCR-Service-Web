import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans], // Ganti Figtree dengan Inter (lebih formal) jika mau
            },
            colors: {
                // Warna Netral yang Bersih & Formal
                gray: {
                    50: '#f9fafb',
                    100: '#f3f4f6',
                    200: '#e5e7eb',
                    300: '#d1d5db',
                    400: '#9ca3af',
                    500: '#6b7280',
                    600: '#4b5563',
                    700: '#374151',
                    800: '#1f2937',
                    900: '#111827',
                },
                // Warna Utama: IMIP Corporate Green
                primary: {
                    50: '#f0fdf4',
                    100: '#dcfce7',
                    200: '#bbf7d0',
                    300: '#86efac',
                    400: '#4ade80',
                    500: '#22c55e',
                    600: '#16a34a', // Hijau tombol aktif
                    700: '#15803d', // Hijau IMIP Utama
                    800: '#166534', // Hijau Sidebar/Header Gelap
                    900: '#14532d', // Hijau Text Sangat Gelap
                },
                // Warna Aksen: Industrial Gold/Yellow (Pelengkap Hijau)
                accent: {
                    500: '#eab308', // Kuning Emas
                    600: '#ca8a04',
                }
            }
        },
    },

    plugins: [forms],
};