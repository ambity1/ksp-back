db-on:
	docker run --name myphpksp -e MYSQL_DATABASE=ksp -e MYSQL_PASSWORD=password -e MYSQL_USER=green -e MYSQL_ROOT_PASSWORD=password -p "3306":"3306"  mysql/mysql-server:8.0
