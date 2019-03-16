# Restoring the DB from the old site

## Running MySQL with Docker

```bash
$ docker run --user 1000:1000 --name slbr-mysql -p3306:3306 -v ~/Development/databases/slbr:/var/lib/mysql -e MYSQL_ROOT_HOST=% -e MYSQL_ROOT_PASSWORD=slbr -e MYSQL_DATABASE=slbr -d mysql:5.5.62
Unable to find image 'mysql:5.5.62' locally
5.5.62: Pulling from library/mysql
5e6ec7f28fb7: Pull complete 
4140e62498e1: Pull complete 
e7bc612618a0: Pull complete 
1af808cf1124: Pull complete 
ff72a74ebb66: Pull complete 
852cfe5dca55: Pull complete 
e27e60fa86d5: Pull complete 
ab7c1c7d8dd6: Pull complete 
bb9fcaf41441: Pull complete 
0c4bda3739a6: Pull complete 
e22ee1bc1b20: Pull complete 
Digest: sha256:dc0af7798e7a634f42418c09b94f03bdf18de0531fb02ef8c2ee7db29d152402
Status: Downloaded newer image for mysql:5.5.62
dc0af7798e7a634f42418c09b94f03bdf18de0531fb02ef8c2ee7db29d152402

$ docker ps -a
CONTAINER ID        IMAGE               COMMAND                  CREATED             STATUS              PORTS               NAMES
3f53aaa796ca        mysql:5.5.62        "docker-entrypoint.s…"   9 seconds ago       Up 7 seconds        3306/tcp            slbr-mysql

$ ls ~/Development/databases/slbr
dc0af7798e7a.pid  ibdata1  ib_logfile0  ib_logfile1  mysql  performance_schema  slbr
```

## Restoring the latest backup

Copy the old backup somewhere, decompressing it, there should be a file called `slbr.sql`.

```bash
$ ls -lah ~/Development/databases/slbr/slbr.sql
-rw-r--r-- 1 kinow kinow 395K Aug 21  2017 /home/kinow/Downloads/slbrv2/slbr.sql
```

Then load it into the running MySQL database.

```bash
$ docker exec -i slbr-mysql mysql -uroot -pslbr slbr < ~/Development/databases/slbr/slbr.sql
$ echo $?
0
```
