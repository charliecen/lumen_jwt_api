### Lumen Jwt Api

[中文文档](https://learnku.com/docs/lumen/6.x)

[代码说明](https://learnku.com/articles/49795)

#### 快速使用

##### 下载

```
git clone https://github.com/charliecen/lumen_jwt_api.git
```

##### 安装包

```
composer install
```

##### 拷贝配置

```
copy .env.example .env
```


##### 生成`APP_KEY`

```
php artisan key:generate
```

> 修改`.env`相关的数据库配置信息


##### 生成`jwt-auth secret`

```
php artisan jwt:secret
```

##### 数据迁移

```
php artisan migrate
```

##### 启动

```
php -S localhost:8000 -t public
```

##### 测试

```
# 创建用户
curl -X POST -F "username=test111" -F "password=cenhuqing" -F "email=test111@example.com" "http://localhost:8000/auth/store"

{
    "code": 10001,
    "msg": "创建用户成功",
    "data": {
        "email": "test111@example.com",
        "username": "test111",
        "updated_at": "2020-09-18T09:22:13.000000Z",
        "created_at": "2020-09-18T09:22:13.000000Z",
        "id": 7
    }
}

# 登录用户
curl -X POST -F "username=test111" -F "password=cenhuqing"  "http://localhost:8000/auth/login"
# 返回结果
{
    "code": 20001,
    "msg": "登录成功",
    "data": {
        "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXV0aFwvbG9naW4iLCJpYXQiOjE2MDA0MjEwNjUsImV4cCI6MTYwMDQyNDY2NSwibmJmIjoxNjAwNDIxMDY1LCJqdGkiOiJEOE42ZjVSdXFTSkQwNmQ4Iiwic3ViIjo3LCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.9n58DzDFEiy-DiGls5CD2-yt--V3TqDBpUaNtz8pmgk",
        "token_type": "bearer",
        "expires_in": 3600
    }
}

#### 查看当前用户
curl -X GET -H "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3Q6ODAwMFwvYXV0aFwvbG9naW4iLCJpYXQiOjE2MDA0MjEwNjUsImV4cCI6MTYwMDQyNDY2NSwibmJmIjoxNjAwNDIxMDY1LCJqdGkiOiJEOE42ZjVSdXFTSkQwNmQ4Iiwic3ViIjo3LCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.9n58DzDFEiy-DiGls5CD2-yt--V3TqDBpUaNtz8pmgk" "http://localhost:8000/auth/me"
# 返回结果
{
    "code": 20004,
    "msg": "获取当前用户",
    "data": {
        "id": 7,
        "username": "test111",
        "email": "test111@example.com",
        "created_at": "2020-09-18T09:22:13.000000Z",
        "updated_at": "2020-09-18T09:22:13.000000Z"
    }
}
```


