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

# Explanation of My Branches

> Some branch might be behind the latest official branch too much, but the modified parts of the branch might give you some ideas. 

## tser-ies
This branch is for TSER project of IES. This follows the latest official **develop** branch and includes branch **feature/vms-authentication** and subtle modification. Also, this branch is running on IIS server which is needed to maintain.

* Front-end url: http://ies-tser.iis.sinica.edu.tw/views/map

* Back-end url: http://ies-tser-backend.iis.sinica.edu.tw

## feature/vms-authentication
This is the **essential** branch to implement VMS account authentication (Login with VMS Email and password) by replacing the original Ushahidi authentication module. 

## feature/realtime-display
I use a 3-party php library to implement realtime-display markers after users uploaded a new record. The principle is to run another server (open socket on different port) to listen the user uploading event and inform to whole client UI to update markers.

## feature/region
In this branch, I tried to build a new page and element in ushahidi and implement the feature of manually drawing the region. You can understand how to add new page into ushahidi. Also, understand how to use built-in leaflet drawing feature in this branch. 

## feature/route
You can find how to draw routes on leaflet map with geojson format in this branch

## feature/custom-marker
The simple practice to change the marker's style and content. However, the latest version modified this part. You can use this branch to find which files are relative to markers.

## feature/display-collections
Can show process name in markers' popup windows. This branch is extended from branch feature/custom-marker. And **it's the branch I try to contribute to ushahidi.**

---

# How to Contribute Code

Because Ushahidi v3 is a rebuild from the ground and still under developing, code might be altered day by day. Below is some procedures I found when we want to contribute our code.

## 1. Say HI
* Say hi to Ushahidi’s developers, let them know what you’d like to work on (front end, back end, etc), and chat about what could be suitable for you.
* There are some issues on github tagged "[Community Task](https://github.com/ushahidi/platform/labels/Community%20Task)". We can choose to work on them. 

## 2. Create New Branch here
Branch name “some-task” is a short description without spaces of what this task is (e.g. “visualise-data”).

## 3. Write Code
Make sure you meet the "[Ushahidi coding standards](https://wiki.ushahidi.com/pages/viewpage.action?pageId=8359652)".
If writing front-end code, use the "[Ushahidi pattern library ](https://github.com/ushahidi/platform-pattern-library)".

## 4. Submit
Open your fork on github and make a pull request to Ushahidi's github.


## My pull request experience

Add a feature about display collection name in popup window of markers.
* May 5: 1st PR
* May 10: tell me to modify code to conform their coding style
* May 11: 2nd PR
* Sep: reply " can't integrate this with our UI at this stage. You're obviously welcome to keep it on your fork though"

## Plugins
The official haven't written documents about how to build a plugin and what's rule to conform

## Join Ushahidi community
* Join the discussion on our [forum](http://forums.ushahidi.com/)
* Gitter at [ushahidi/Community](https://gitter.im/ushahidi/Community) 
