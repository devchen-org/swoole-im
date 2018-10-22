# 基于 Swoole(WebSocket) 实现简易IM


### Nginx
```
upstream websocket {
    server 127.0.0.1:9501 weight=1;
    server 127.0.0.1:9502 weight=1;
    ip_hash;
}

map $http_upgrade $connection_upgrade {
    default upgrade;
    '' close;
}

server {
    listen 8080;
    server_name swoole-im.local;
    location / {
        proxy_pass http://websocket;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
    }
}
```