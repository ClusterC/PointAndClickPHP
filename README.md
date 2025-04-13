# PointAndClickPHP
968-240 WEB DEVELOPMENT AND PROGRAMMING 2/2024

## วิธีใช้งาน (Usage)

### ข้อกำหนดเบื้องต้น (Prerequisites)

*   **XAMPP:** ติดตั้ง XAMPP เวอร์ชั่นล่าสุด (ซึ่งจะมาพร้อมกับ Apache, PHP, และ MariaDB/MySQL) ดาวน์โหลดได้ที่ [https://www.apachefriends.org/](https://www.apachefriends.org/)
*   [เครื่องมืออื่นๆ ที่จำเป็น เช่น Git สำหรับ clone repository]

### การติดตั้ง (Installation/Setup)

1.  **เปิด XAMPP Control Panel:** ตรวจสอบให้แน่ใจว่า Apache และ MySQL ทำงานอยู่ (กด Start ที่โมดูล Apache และ MySQL)

2.  **Clone a repository:**
    *   เปิด Command Prompt หรือ Terminal
    *   เข้าไปที่โฟลเดอร์ `htdocs` ของ XAMPP (ปกติจะอยู่ที่ `C:\xampp\htdocs` บน Windows)
    ```bash
    cd C:\xampp\htdocs
    ```
    *   Clone โปรเจกต์ของคุณลงในโฟลเดอร์นี้:
    ```bash
    git clone <your-repository-url> PointAndClickPHP
    ```
    *(ถ้าไม่ได้ใช้ Git ก็สามารถดาวน์โหลดไฟล์โปรเจกต์เป็น ZIP แล้วแตกไฟล์ไว้ใน `C:\xampp\htdocs\PointAndClickPHP` ได้เลย)*
    
### การรันโปรเจกต์ (Running the Application)

*   เปิดเว็บเบราว์เซอร์แล้วไปที่:
    ```
    http://localhost/PointAndClickPHP/main.php
    ```
