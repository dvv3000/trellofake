# Cài đặt và sử dụng project
1. Cài đặt 1 web server: Apache2 hoặc Nginx
2. Cài đặt mySQL, composer, npm
3. Clone repo này về
4. Tạo file .env dc copy từ .env.example
5. Chỉnh sửa các phần: ***DB_DATABASE***, ***DB_USERNAME***, ***DB_PASSWORD***
6. Mở terminal và chạy các lệnh:
    ```
    npm install
    composer install

    php artisan key:generate
    php artisan migrate
    php artisan storage:link
    php artisan serve
    ```