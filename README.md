# Parse tags

## Description
This is a script that parses following text:
```
[TAG_NAME:description]data[/TAG_NAME]
```
Into an array:
```json
{
    "TAG_NAME": {
        "description": "description",
        "data": "data"
    }
}
```
It is built inside docker environment using cli php image. There are unit tests implemented to be able to validate functionality working properly and handling corner cases as expected.<br>

### Parser script location:
```text
app/src/classes/TagsParser.php
```
### Unit tests location:
```text
app/tests/TagsParserTest.php
```


## Table of contents
 - [Installation](#installation)
 - [Run script](#run-script)
 - [Run unit tests](#run-unit-tests)

## Installation
Just run following command inside root folder
```shell
docker-compose up -d
```

## Run script
Go inside php container using this command or any other preferred way
```shell
docker exec -it php /bin/bash
```
Run your command like this and see the output in json format
```shell
./src/parse_tags_cli.php '[TAG_NAME:description]data[/TAG_NAME]'
```
Output:
```json
{
    "TAG_NAME": {
        "description": "description",
        "data": "data"
    }
}
```

## Run unit tests
Go inside php container using this command or any other preferred way
```shell
docker exec -it php /bin/bash
```
Run tests:
```shell
./vendor/bin/phpunit
```