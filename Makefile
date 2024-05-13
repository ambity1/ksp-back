db-run:
	docker run --name myphpksp -e MYSQL_DATABASE=ksp -e MYSQL_PASSWORD=password -e MYSQL_USER=green -e MYSQL_ROOT_PASSWORD=password -p "3306":"3306"  mysql/mysql-server:8.0

db-start:
	docker start myphpksp

ngrok:
	docker run --net=host -it -e NGROK_AUTHTOKEN=2XZgy42xK29HehxrpocLFDuvG4x_86DkgEMQ6eFbdfZnzyKjJ ngrok/ngrok:latest http --domain=evolving-plainly-drake.ngrok-free.app 8000
