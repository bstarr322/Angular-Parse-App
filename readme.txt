Readme 

Local Copy

1. In pars.js, change the Parse.initialize(appID, restAPIkey) to match the dev app information on Parse (click the App, then Settings)
2. Find the “.htaccess” file in the root folder and comment out the first four lines. These lines force the user to use HTTPS, which is not what we want for local development.
3. Run the site locally (using Mamp or something similar) and make sure it’s working. If you’re having issues you can try clearing your cache or visiting the local site in a private/incognito window. 

Cloud Code

1. Setup Parse in your terminal (https://parse.com/docs/cloud_code_guide)
2. Find the local copies of main.js and mandrill.js. If they aren’t there, create them in the “cloud/“ folder and copy the contents from the Cloud Code section of parse.com/DYOM-dev (or whatever the dev app is named). If it’s not there, copy main.js and mandrill.js from the live app’s Cloud Code section.

Making an admin

1. Open the app in parse.com
2. Click on Roles
3. Click “+ Row”
4. Type “Administrator” in name and then double click Public Read and Write under ACL. Then make sure Read and Write are checked and click Save ACL
5. Click View Relations under the users column in the new Administrator object. 
6. Click “+ Row” and scroll over all the way to the username column. Enter the desired admin username and click in the white space below to deselect the username box and save the new object.
7. You should get an error regarding the password. Enter the desired password in the password column. After this, the object should save successfully. 

Testing the admin

1. Login to the local site using the admin credentials you created
2. Go to localhost/dashboard
3. Confirm that the “Manage applications” and “Manage admins” buttons are present in the left column under your username and “Edit profile”