# my-todo-list
UNIT TEST:
+UNIT TEST for job search function:

Check 4 tabs all, today, week, month:
--all: check if all jobs are displayed properly.
--today: check if tasks with deadlines for the day are displayed correctly.
--week: check if the tasks with deadlines for the week are displayed correctly.
--month: check if jobs with deadlines for the month are displayed correctly.
Check out the search by content:
--ID, name, content: check if jobs searched by ID, job name or content are displayed correctly.
Check the search by start and end time:
--Check that jobs searched by start and end time are displayed correctly.
Check the search by status:
--Check that jobs searched by status (scheduled, in progress or completed) are displayed correctly.

+UNIT TEST for adding, editing and deleting jobs:
--Check if the number of jobs before and after adding new is correct.
Check the editing of the job's information:
--Check that the job information before and after editing is correct.
Check for job deletion:
--Check if the number of jobs before and after deletion is correct.
Check valid fields in Javascript and PHP:
--Check if the input fields are valid.
Check for error messages when creating, updating, deleting jobs:
--Check that error messages are displayed correctly with the corresponding status (create, update or delete job).

+UNIT TEST for the function of displaying tasks on the calendar:
--Check if the job is displayed correctly by day, week and month.
-Check if the jobs are displayed in the correct status (planning, in progress or completed).
-Check if the display of tasks on the calendar uses a third-party library as requested.
-In the process of writing UNIT TEST, we need to make sure the test cases are complete, accurate and robust enough to ensure the accuracy and completeness of the system.



UNIT TEST:
+UNIT TEST cho chức năng tìm kiếm công việc:

Kiểm tra 4 tab all, today, week, month:
--all: kiểm tra xem tất cả các công việc có được hiển thị đúng không.
--today: kiểm tra xem các công việc có deadline trong ngày có được hiển thị đúng không.
--week: kiểm tra xem các công việc có deadline trong tuần có được hiển thị đúng không.
--month: kiểm tra xem các công việc có deadline trong tháng có được hiển thị đúng không.
Kiểm tra việc tìm kiếm theo nội dung:
--ID, name, content: kiểm tra xem các công việc được tìm kiếm theo ID, tên công việc hoặc nội dung có được hiển thị đúng không.
Kiểm tra việc tìm kiếm theo thời gian bắt đầu và kết thúc:
--Kiểm tra xem các công việc được tìm kiếm theo thời gian bắt đầu và kết thúc có được hiển thị đúng không.
Kiểm tra việc tìm kiếm theo trạng thái:
--Kiểm tra xem các công việc được tìm kiếm theo trạng thái (lên kế hoạch, đang thực hiện hoặc đã hoàn thành) có được hiển thị đúng không.
+UNIT TEST cho chức năng thêm mới, chỉnh sửa và xóa công việc:

Kiểm tra việc thêm mới công việc:
--Kiểm tra xem số lượng công việc trước và sau khi thêm mới có chính xác không.
Kiểm tra việc chỉnh sửa thông tin của công việc:
--Kiểm tra xem thông tin công việc trước và sau khi chỉnh sửa có chính xác không.
Kiểm tra việc xóa công việc:
--Kiểm tra xem số lượng công việc trước và sau khi xóa có chính xác không.
Kiểm tra valid field trong Javascript và PHP:
--Kiểm tra xem các trường thông tin được nhập vào có hợp lệ không.
Kiểm tra thông báo lỗi khi tạo, cập nhật, xóa công việc:
--Kiểm tra xem các thông báo lỗi được hiển thị đúng với trạng thái tương ứng (tạo, cập nhật hoặc xóa công việc).
+UNIT TEST cho chức năng hiển thị công việc trên lịch:

Kiểm tra việc hiển thị công việc trên lịch:
--Kiểm tra xem công việc có được hiển thị đúng theo ngày, tuần và tháng không.
-Kiểm tra xem các công việc có được hiển thị đúng trạng thái (đang lên kế hoạch, đang thực hiện hoặc đã hoàn thành) không.
-Kiểm tra xem việc hiển thị công việc trên lịch có sử dụng thư viện bên thứ ba như đã yêu cầu không.
-Trong quá trình viết UNIT TEST, ta cần đảm bảo các ca kiểm thử đầy đủ, chính xác và đủ mạnh để đảm bảo tính chính xác và đầy đủ của hệ thống.

Upload to server:
-change file default.conf
-open port 8080, import mydb.sql
-run: port 80
----
-account login: 
user email: example@gmail.com 
password: 123456
----

//file default.conf
server {
    listen 80;
    listen [::]:80;
    server_name 13.228.170.225;

    root /var/www/html;
    index index.php index.html index.htm;

       location / {
        try_files $uri $uri/ /index.php?$args;
    }

       location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass php:9000;
    }

 location ~ /\.ht {
        deny all;
    }
}
