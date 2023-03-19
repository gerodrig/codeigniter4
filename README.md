# Running the custom CodeIgniter and MariaDB containers

This guide assumes that you have already pulled the custom CodeIgniter container (`gerodrig/codeigniter:latest`) and have the `docker-compose.yml` file in your repository.

## Prerequisites

- Docker installed on your system
- Docker Compose installed on your system

## Steps

1. Clone the repository containing the `docker-compose.yml` file:


git clone <https://github.com/gerodrig/codeigniter4>


Replace `https://github.com/gerodrig/codeigniter4` with the URL of your repository containing the `docker-compose.yml` file.

2. Navigate to the directory containing the `docker-compose.yml` file:

cd  <repository_directory>


Replace `<repository_directory>` with the name of the directory where your repository was cloned.

3. Make sure your `docker-compose.yml` file has the correct image names:

```dotnetcli
version: '2'

services:
mariadb:
image: docker.io/bitnami/mariadb:10.6
# ...
phpmyadmin:
image: phpmyadmin/phpmyadmin
# ...
restful:
image: gerodrig/codeigniter:latest
# ...
```


4. Run the containers using Docker Compose:

```docker-compose up -d```


This command will start the containers in detached mode, running in the background.

5. Access the CodeIgniter application by navigating to `http://localhost:8000` in your web browser.

6. To stop and remove the containers, run:

```docker-compose down```

This command will stop the containers and remove them.
