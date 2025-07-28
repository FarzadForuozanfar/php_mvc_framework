# PHP MVC Framework

یک فریم‌ورک MVC ساده و قدرتمند برای PHP با قابلیت ریت لیمیتر پیشرفته.

## ویژگی‌ها

- ✅ **MVC Architecture**: ساختار Model-View-Controller
- ✅ **Rate Limiting**: سیستم محدودیت درخواست با سه استراتژی مختلف
- ✅ **Session Management**: مدیریت جلسه کاربران
- ✅ **Database Integration**: اتصال به پایگاه داده
- ✅ **Routing**: سیستم مسیریابی
- ✅ **Validation**: اعتبارسنجی داده‌ها
- ✅ **Logging**: سیستم ثبت لاگ
- ✅ **Middleware Support**: پشتیبانی از middleware

## نصب و راه‌اندازی

### پیش‌نیازها

- PHP 7.4 یا بالاتر
- Composer
- MySQL/MariaDB
- Redis (اختیاری)
- APCu (اختیاری)

### نصب

```bash
# کلون کردن پروژه
git clone <repository-url>
cd php_mvc_framework

# نصب dependencies
composer install

# کپی فایل پیکربندی
cp config/app.example.php config/app.php
cp config/database.example.php config/database.php

# تنظیم مجوزها
chmod -R 755 logs/
chmod -R 755 public/
```

### پیکربندی

#### 1. پایگاه داده

فایل `config/database.php`:

```php
<?php
return [
    'host' => 'localhost',
    'dbname' => 'your_database',
    'username' => 'your_username',
    'password' => 'your_password',
    'charset' => 'utf8mb4'
];
```

#### 2. ریت لیمیتر

فایل `config/ratelimiter.php`:

```php
<?php
return [
    'driver' => 'apcu',        // session, redis, apcu
    'max_attempts' => 5,       // حداکثر تعداد تلاش
    'decay_minutes' => 1,      // زمان انقضا (دقیقه)
];
```

## سیستم ریت لیمیتر

### استراتژی‌های موجود

1. **Session Strategy**: ذخیره‌سازی در session (پیش‌فرض)
2. **Redis Strategy**: ذخیره‌سازی در Redis (برای عملکرد بهتر)
3. **APCu Strategy**: ذخیره‌سازی در APCu (برای کش)

### استفاده

#### روش 1: Middleware

```php
use Core\RateLimiterMiddleware;

public function handleLogin(Request $request)
{
    // اعمال ریت لیمیتر برای لاگین
    $rateLimitMiddleware = RateLimiterMiddleware::forLogin();
    if (!$rateLimitMiddleware->handle()) {
        return false;
    }

    // ادامه منطق لاگین
}
```

#### روش 2: Helper Function

```php
public function handleContact(Request $request)
{
    // اعمال ریت لیمیتر
    if (!rate_limit('contact:' . $_SERVER['REMOTE_ADDR'], 3, 2)) {
        echo "زیادی تلاش کردی، بعداً دوباره امتحان کن.";
        exit;
    }

    // ادامه منطق
}
```

#### روش 3: مستقیم

```php
use Core\RateLimiter;

public function handleApi(Request $request)
{
    $rateLimiter = RateLimiter::getInstance();
    if (!$rateLimiter->attempt('api:' . $_SERVER['REMOTE_ADDR'], 10, 1)) {
        http_response_code(429);
        echo json_encode(['error' => 'Too Many Requests']);
        exit;
    }

    // ادامه منطق API
}
```

### Middleware های آماده

```php
// برای لاگین: 3 تلاش در 1 دقیقه
RateLimiterMiddleware::forLogin();

// برای ثبت‌نام: 2 تلاش در 1 دقیقه
RateLimiterMiddleware::forRegister();

// برای فرم تماس: 3 تلاش در 2 دقیقه
RateLimiterMiddleware::forContact();

// برای API: 10 تلاش در 1 دقیقه
RateLimiterMiddleware::forApi();
```

## ساختار پروژه

```
php_mvc_framework/
├── app/
│   ├── controllers/          # کنترلرها
│   ├── models/              # مدل‌ها
│   ├── requests/            # کلاس‌های اعتبارسنجی
│   ├── Strategies/          # استراتژی‌های ریت لیمیتر
│   └── interfaces/          # رابط‌ها
├── config/                  # فایل‌های پیکربندی
├── core/                    # کلاس‌های اصلی فریم‌ورک
├── logs/                    # فایل‌های لاگ
├── public/                  # فایل‌های عمومی
├── views/                   # قالب‌ها
├── tests/                   # تست‌ها
├── examples/                # مثال‌ها
└── docs/                    # مستندات
```

## تست

### اجرای تست‌های ریت لیمیتر

```bash
php tests/RateLimiterTest.php
```

### اجرای مثال‌ها

```bash
php examples/rate_limiter_example.php
```

## لاگ‌ها

تمام عملیات در فایل‌های لاگ ثبت می‌شوند:

- `logs/info.log`: اطلاعات عمومی
- `logs/error.log`: خطاها
- `logs/warning.log`: هشدارها

## نکات مهم

- در صورت عدم دسترسی به Redis، سیستم به صورت خودکار به Session fallback می‌کند
- کلیدهای ریت لیمیتر به صورت خودکار منقضی می‌شوند
- IP کاربر به صورت خودکار به کلید اضافه می‌شود
- تمام خطاها در لاگ ثبت می‌شوند

## مشارکت

برای مشارکت در پروژه:

1. Fork کنید
2. Branch جدید ایجاد کنید
3. تغییرات را commit کنید
4. Pull Request ارسال کنید

## لایسنس

این پروژه تحت لایسنس MIT منتشر شده است.

## پشتیبانی

برای سوالات و مشکلات:

- Issue در GitHub ایجاد کنید
- مستندات کامل در `docs/` مطالعه کنید
- مثال‌ها در `examples/` بررسی کنید
