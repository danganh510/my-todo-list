# my-todo-list

README for Task Manager Program

This is a task manager program with the following features:

Add, Edit, Delete Work:
To add a new work, click on the "Add" button and fill in the required information including "Work Name", "Starting Date", "Ending Date", and "Status" (Planning, Doing, or Complete).
To edit a work, click on the work that you want to edit and modify the information in the fields. Click on the "Save" button to save the changes.
To delete a work, click on the work that you want to delete and click on the "Delete" button.
Calendar View:
The calendar view shows the works in a monthly, weekly, or daily calendar format.
To switch between monthly, weekly, and daily view, click on the corresponding tab.
The calendar view uses a third-party library to display the works on the calendar.
To run the program, simply open the index.html file in a web browser.

For developers who want to contribute to the code, the program is written in JavaScript and HTML/CSS. The code is organized into different files for different functionalities. The "js" folder contains the JavaScript files, and the "css" folder contains the CSS files.

Unit tests are included for the search functionality, add/edit/delete works, and calendar view. To run the unit tests, open the "test.html" file in a web browser.

Upload to server:
-change file default.conf
-open port 8080, import mydb.sql
-run: port 80

---

-account login:
link deploy: http://13.228.170.225
user email: example@gmail.com
password: 123456

---

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
***note: I write UNIT TEST at file unitTest.txt