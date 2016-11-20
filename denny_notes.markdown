# Code Architecture
Official Architecture Tutorial
https://wiki.ushahidi.com/display/WIKI/Code+Organisation

## appendix of platform (Backend)
* Write in php. Based on Kohana and Clean Architecture.
* bundle.js is a auto-generate file (gulp compile whole script as a bundle)
* /migrations to describe and implement database ordered by time

`bin/update` to update database after every pull and merge

## appendix of platform-client (Front-end) 
* Write in javascript and angularJS.
* /app : controller
* /server/www/ : front-end html (created by gulp build)

**For example**
* Index page

Front: maps, post-view-map-directive <-> Backend: GeoJSONCollection
* post Detail

Front: maps, post-detail-controller <-> Backend: GeoJSON

---

# HOW TO
## build development environment

https://github.com/ushahidi/docs.ushahidi.com/tree/gh-pages/install
or
https://www.ushahidi.com/support/install-ushahidi

Use vagrant to setup local environment. Read linux setup when running on server.

## connect to local database 
Download `MySQLWorkbench` and setup as below
![](https://github.com/yuchenglin/Leaflet-Map-Practice/blob/master/ushahidi_database_setup.png?raw=true)

## add language localization
ushahidi use transfix as its localization control and development platform.
 
1. Register into the webpage https://www.transifex.com/ushahidi/ushahidi-v3/

1. http://docs.transifex.com/client/init/ set TX account/password

1. `gulp transifex-download` to download language files

1. Also, can contribute translation through the page

**Manual update: Go to platform-client `server/www/locales/...`**

## keep feature branch up to date
```
git checkout develop
git pull (from upstream)
git push (to origin OpenISDM)
```
```
git checkout feature/branch
git pull origin develop
```
http://stackoverflow.com/questions/20101994/git-pull-from-master-into-the-development-branch

## trace ushahidi api
Use Browser's inspector and turn on the `network` section. You can trace the request and response http packets.

Use a restful testing tool, such as `postman`, to test their API. 

Below is the API to create a new survey I provided to IES.
https://www.evernote.com/l/AEZf8RC7LktIhL0HcWT06xsWsvLeMHEQryc

---
