# PANDUAN CLONE & SETUP PROJECT ICAREMU APP
**Target Branch**: `laravel`  
**Repository**: `https://github.com/AryaaaRpl/ICareMu-Health-Assistance-App.git`

Panduan ini berisi langkah-langkah lengkap untuk anggota tim yang ingin mengunduh (*clone/pull*) dan menjalankan project **ICareMu** di laptop masing-masing.

---

## 🛠 Prerequisites (Kebutuhan Awal)
Sebelum memulai, pastikan laptop sudah terinstall software berikut:
1. **PHP >= 8.2**
2. **Composer** ([https://getcomposer.org](https://getcomposer.org))
3. **Node.js & NPM** ([https://nodejs.org](https://nodejs.org))
4. **Git** ([https://git-scm.com](https://git-scm.com))
5. **Database Server**: MySQL / XAMPP / Laragon

---

## 🚀 Langkah-Langkah Setup (Pertama Kali)

### 1. Clone Repository & Checkout Branch `laravel`
Buka terminal (Git Bash, Command Prompt, atau Terminal VSCode), lalu jalankan:

```bash
git clone -b laravel https://github.com/AryaaaRpl/ICareMu-Health-Assistance-App.git ICareMu-App
cd ICareMu-App
```

*(Jika sudah pernah clone repository sebelumnya, cukup jalankan `git checkout laravel` dan `git pull origin laravel`)*

---

### 2. Install Dependensi PHP (Composer)
Jalankan perintah berikut untuk mengunduh semua paket dependensi Laravel:

```bash
composer install
```

---

### 3. Setup File Environment (`.env`)
Salin file `.env.example` menjadi `.env`:

**Windows (PowerShell / CMD)**:
```powershell
copy .env.example .env
```
**Linux / macOS / Git Bash**:
```bash
cp .env.example .env
```

---

### 4. Generate Application Key
Jalankan perintah untuk membuat `APP_KEY` Laravel baru:

```bash
php artisan key:generate
```

---

### 5. Konfigurasi Database (MySQL)
1. Buka XAMPP / Laragon / MySQL Workbench.
2. Buat database baru bernama: `icaremu_db` (atau sesuaikan dengan file `.env` Anda).
3. Buka file `.env` dan pastikan kredensial database sudah sesuai:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=icaremu_db
DB_USERNAME=root
DB_PASSWORD=
```

---

### 6. Jalankan Migrasi & Seeder Database
Jalankan migrasi untuk membuat tabel-tabel database:

```bash
php artisan migrate --seed
```

---

### 7. Install Dependensi Node.js & Jalankan Server Frontend
Jalankan perintah berikut untuk mengunduh paket JavaScript / Tailwind CSS:

```bash
npm install
npm run dev
```

---

### 8. Jalankan Server Lokal Laravel
Buka terminal baru di folder proyek, lalu jalankan:

```bash
php artisan serve
```

Aplikasi sekarang dapat diakses melalui browser di:  
👉 `http://127.0.0.1:8000`

---

## 🔄 Cara Pull Update Terbaru (Jika Ada Perubahan Kode Baru)

Jika di kemudian hari ada pembaruan kode yang di-push ke GitHub, anggota tim cukup menjalankan perintah ini di laptop mereka:

```bash
git pull origin laravel
composer install
php artisan migrate
npm run build
```

---

## 📌 Halaman & URL Utama untuk Dicoba
- **Landing Page Investor**: `http://127.0.0.1:8000/`
- **Dashboard UKS**: `http://127.0.0.1:8000/app/dashboard-uks`
- **Dashboard Siswa**: `http://127.0.0.1:8000/app/dashboard-siswa`
- **Smart Health Record**: `http://127.0.0.1:8000/app/health-record`
- **AI Health Assistant**: `http://127.0.0.1:8000/app/ai-assistant`
- **Edukasi & Fikih ISMUBA**: `http://127.0.0.1:8000/app/edukasi-ismuba`
- **Menstrual Health Monitoring**: `http://127.0.0.1:8000/app/menstrual-health`
- **UKS Inventory**: `http://127.0.0.1:8000/app/uks-inventory`
- **Login & Registrasi Flow**: `http://127.0.0.1:8000/login` & `http://127.0.0.1:8000/register`
