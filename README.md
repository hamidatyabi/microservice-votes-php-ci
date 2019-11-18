# microservice-votes-php-ci
PHP script for management of votes. it's microservice and connected to microservice-auth-java for authentication

# Technologies
- PHP
- Codeigniter 3.11
- Composer

# How to install?
```
$ docker-compose up -d
```

## Oauth2 configuration
Set your authentication server information in docker-compose.yml
```
AUTH_HOST: http://127.0.0.1
AUTH_PORT: 5061
AUTH_CLIENT_ID: client_id
AUTH_CLIENT_SECRET: client_secret
```

# Get votes list
URL: http://host:port/api/votes/list
Method: POST
## Header
You can get access_token from microservice-auth-java or your authentication service
```
Authorization: Bearer access_token
```
## Body:
```json
{
    "title": "",
    "voteId": 0,
    "status": "",
    "page": 1,
    "limit": 10
}
```
## Response sample:
```json
{
    "totalCount": 1,
    "currentPage": 1,
    "currentLimit": 10,
    "totalPage": 1,
    "rows": [
        {
            "id": "1",
            "title": "OS popular",
            "description": "This vote is OS popularity",
            "createTime": "2019-11-18 12:24:32",
            "expireTime": "2020-11-18 00:00:00",
            "status": true,
            "options": [
                {
                    "id": "1",
                    "voteId": "1",
                    "description": "Windows",
                    "createTime": "2019-11-18 13:46:58",
                    "key": "windows"
                },
                {
                    "id": "2",
                    "voteId": "1",
                    "description": "Linux",
                    "createTime": "2019-11-18 13:47:07",
                    "key": "linux"
                },
                {
                    "id": "3",
                    "voteId": "1",
                    "description": "MAX",
                    "createTime": "2019-11-18 13:47:15",
                    "key": "mac"
                }
            ]
        }
    ]
}
```