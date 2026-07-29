# Issue 2: Buat Model dan Migration untuk Category & Transaction

## Deskripsi
Dalam pembuatan aplikasi keuangan ini, kita membutuhkan arsitektur database untuk mencatat **Kategori** (seperti Makan & Minum, Tagihan Listrik) dan **Transaksi** itu sendiri. Kita juga harus memastikan setiap kategori dan transaksi saling berelasi, serta terhubung dengan `User` yang login.

## Struktur Tabel & Arsitektur

### 1. Model dan Tabel `Category`
Tabel ini menyimpan daftar sub-kategori yang digolongkan dalam beberapa tipe besar.
- **Buat Model dan Migrasi:**
  ```bash
  php artisan make:model Category -m
  ```
- **Definisi Kolom Migrasi (`database/migrations/..._create_categories_table.php`):**
  - `$table->id();`
  - `$table->foreignId('user_id')->constrained()->cascadeOnDelete();` (Tiap user punya kategori sendiri)
  - `$table->string('type');` (Isi: 'pengeluaran', 'penghasilan', 'tagihan', 'hutang', 'tabungan', 'investasi')
  - `$table->string('name');` (Nama spesifik: 'Makan & Minum')
  - `$table->timestamps();`

### 2. Model dan Tabel `Transaction`
Tabel ini menyimpan riwayat pencatatan pengguna.
- **Buat Model dan Migrasi:**
  ```bash
  php artisan make:model Transaction -m
  ```
- **Definisi Kolom Migrasi (`database/migrations/..._create_transactions_table.php`):**
  - `$table->id();`
  - `$table->foreignId('user_id')->constrained()->cascadeOnDelete();`
  - `$table->foreignId('category_id')->constrained()->cascadeOnDelete();`
  - `$table->string('type');` (Sama dengan type di category, untuk kemudahan filtering)
  - `$table->decimal('amount', 15, 2);` (Gunakan decimal untuk presisi uang)
  - `$table->date('transaction_date');`
  - `$table->text('notes')->nullable();`
  - `$table->timestamps();`

## Langkah-langkah Implementasi Model (Eloquent Relationships)

1. **Model `User` (`app/Models/User.php`):**
   - Tambahkan relasi `hasMany`:
     ```php
     public function categories() { return $this->hasMany(Category::class); }
     public function transactions() { return $this->hasMany(Transaction::class); }
     ```

2. **Model `Category` (`app/Models/Category.php`):**
   - Tambahkan `$fillable = ['user_id', 'type', 'name'];`
   - Tambahkan relasi ke user dan transactions:
     ```php
     public function user() { return $this->belongsTo(User::class); }
     public function transactions() { return $this->hasMany(Transaction::class); }
     ```

3. **Model `Transaction` (`app/Models/Transaction.php`):**
   - Tambahkan `$fillable = ['user_id', 'category_id', 'type', 'amount', 'transaction_date', 'notes'];`
   - Tambahkan relasi:
     ```php
     public function user() { return $this->belongsTo(User::class); }
     public function category() { return $this->belongsTo(Category::class); }
     ```

4. **Eksekusi Migrasi:**
   - Setelah file migration selesai diedit, jalankan: `php artisan migrate`.

## Kriteria Penerimaan (Acceptance Criteria)
- [x] Tabel `categories` dan `transactions` terbuat di database SQLite tanpa error.
- [x] File Model memiliki relasi Eloquent yang benar.
- [x] File Model memiliki `$fillable` yang di-setup agar terhindar dari error Mass Assignment.
