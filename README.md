# talk-selenium-101
example code for talk **selenium 101**
# Docker
See [Selenium on docker hub](https://hub.docker.com/r/selenium/)
```
docker pull selenium/hub
docker pull selenium/node-chrome
docker pull selenium/node-firefox
```

## docker-compose.yml
```
hub:
  image: selenium/hub
  ports:
    - "4444:4444"
firefox:
  image: selenium/node-firefox
  links:
    - hub
chrome:
  image: selenium/node-chrome
  links:
    - hub
```
