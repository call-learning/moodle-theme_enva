This folder contains the compiled version of the Mobile stylesheet. To use this stylesheet in the mobile app follow these steps:

# Login as Admin.
# Navigate to Site Administration > Mobile App > Mobile Appearance.
# In the field mobilecssurl enter the web url for the mobile.css file (for exampe: http://enva.moodle.com/theme/enva/styles/mobile.css)
# Download the mobile app and connect to your moodle instance.
# Go to setting > Synchronisation and click the synchronise button.
# You should now be able to see a red navbar and other custom styles.

To compile the styles for the mobile.css stylesheet on the command line follow these steps

# cd to the 'theme/enva' folder
# run "npm install"
# run "sudo npm install -g npx"
# run "npx node-sass --output-style expanded --precision 6 mobile/styles.scss styles/mobile.css"
