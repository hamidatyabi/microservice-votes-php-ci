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
    "totalCount": 2,
    "currentPage": 2,
    "currentLimit": 1,
    "totalPage": 2,
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
                },
                {
                    "id": "1",
                    "voteId": "1",
                    "description": "Windows",
                    "createTime": "2019-11-18 13:46:58",
                    "key": "windows"
                }
            ],
            "media": {
                "fileName": "15741595412982.jpeg",
                "extension": "jpeg",
                "mime": "image/jpeg",
                "baseWidth": "960",
                "baseHeight": "678",
                "width": "0",
                "height": "0",
                "size": "156167",
                "path": "uploads/15741595412982.jpeg"
            }
        }
    ]
}
```

# Get vote information
URL: http://host:port/api/votes/get?voteId=xxx
Method: GET
## Header
You can get access_token from microservice-auth-java or your authentication service
```
Authorization: Bearer access_token
```
## Response sample:
```json
{
    "id": "1",
    "title": "OS popular",
    "description": "This vote is OS popularity",
    "createTime": "2019-11-18 12:24:32",
    "expireTime": "2020-11-18 00:00:00",
    "status": true,
    "options": [
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
        },
        {
            "id": "1",
            "voteId": "1",
            "description": "Windows",
            "createTime": "2019-11-18 13:46:58",
            "key": "windows"
        }
    ],
    "media": {
        "fileName": "15741595412982.jpeg",
        "extension": "jpeg",
        "mime": "image/jpeg",
        "baseWidth": "960",
        "baseHeight": "678",
        "width": "0",
        "height": "0",
        "size": "156167",
        "path": "uploads/15741595412982.jpeg"
    }
}
```

# Add new vote
URL: http://host:port/api/votes/add
Method: POST
## Header
You can get access_token from microservice-auth-java or your authentication service
```
Authorization: Bearer access_token
```
## Body:
```json
{
    "title": "Test",
    "description": "Test vote",
    "createTime": "2019-11-18 20:50:00",
    "expireTime": "",
    "status": true,
    "media": "base64_encode(binary_image)"
}
```
## Response sample:
```json
{
    "id": "1",
    "title": "OS popular",
    "description": "This vote is OS popularity",
    "createTime": "2019-11-18 12:24:32",
    "expireTime": "2020-11-18 00:00:00",
    "status": true,
    "options": [],
    "media": {
        "fileName": "15741595412982.jpeg",
        "extension": "jpeg",
        "mime": "image/jpeg",
        "baseWidth": "960",
        "baseHeight": "678",
        "width": "0",
        "height": "0",
        "size": "156167",
        "path": "uploads/15741595412982.jpeg"
    }
}
```

# Update vote
URL: http://host:port/api/votes/update
Method: POST
## Header
You can get access_token from microservice-auth-java or your authentication service
```
Authorization: Bearer access_token
```
## Body:
```json
{
    "voteId": 1,
    "title": "Test",
    "description": "Test vote",
    "createTime": "2019-11-18 20:50:00",
    "expireTime": "",
    "status": true,
    "media": "base64_encode(binary_image)"
}
```
## Response sample:
```json
{
    "id": "1",
    "title": "OS popular",
    "description": "This vote is OS popularity",
    "createTime": "2019-11-18 12:24:32",
    "expireTime": "2020-11-18 00:00:00",
    "status": true,
    "options": [],
    "media": {
        "fileName": "15741595412982.jpeg",
        "extension": "jpeg",
        "mime": "image/jpeg",
        "baseWidth": "960",
        "baseHeight": "678",
        "width": "0",
        "height": "0",
        "size": "156167",
        "path": "uploads/15741595412982.jpeg"
    }
}
```

# Delete vote image
URL: http://host:port/api/votes/delete_image?voteId=xxxx
Method: GET
## Header
You can get access_token from microservice-auth-java or your authentication service
```
Authorization: Bearer access_token
```
## Response sample:
```json
{
    "id": "1",
    "title": "OS popular",
    "description": "This vote is OS popularity",
    "createTime": "2019-11-18 12:24:32",
    "expireTime": "2020-11-18 00:00:00",
    "status": true,
    "options": [],
    "media": {
        "fileName": null,
        "extension": null,
        "mime": null,
        "baseWidth": null,
        "baseHeight": null,
        "width": null,
        "height": null,
        "size": null,
        "path": null
    }
}
```