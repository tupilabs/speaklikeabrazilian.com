# Restoring the DB from the old site

## Running MySQL with Docker

```bash
$ docker run --name slbr-mysql -v ~/databases/slbr:/var/lib/mysql -e MYSQL_ROOT_PASSWORD=slbr -d mysql:5.5.62
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
Digest: sha256:0510ece613362e5d91ee9eb28db30a588c04117ae8c59ec31a5981f83e8e9d13
Status: Downloaded newer image for mysql:5.5.62
3f53aaa796ca56509976ac4e0f7967c32f410c28a6950a3d1b2ccf40828d8881


$ docker ps -a
CONTAINER ID        IMAGE               COMMAND                  CREATED             STATUS              PORTS               NAMES
3f53aaa796ca        mysql:5.5.62        "docker-entrypoint.s…"   9 seconds ago       Up 7 seconds        3306/tcp            slbr-mysql

$ ls ~/databases/slbr
3f53aaa796ca.pid  ibdata1  ib_logfile0  ib_logfile1  mysql  performance_schema
```

