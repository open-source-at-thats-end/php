# REQUIREMENT

1. Need to get data from third party server using API and store in WordPress custom database. 

2. Make sure database get updated on regular time interval.  

3. Once database is ready, need to develop admin functionality to manage settings

4. Develop webiste part for end useres to access and serch through data.

5. All of above features must be handy, so it can be used in multiple WordPress websites

# SOLUTION
1. As client was looking for WordPress as a platform we decided to develop custom plugin.

2. All of the features have been implemented in custom plugin called [BROKER PLUGIN] including custom database. There is a seperate database tabes which are merged with WordPress tabes in MySQL database.

3. We used API documentation from API provider to integreate API

4. For regular time interval update of database, we created a background script which run automatically using cron job in hosting panel

5. When have scripped the entire admin area settings features

6. When have scripped the webiste part end user interface

7. At the end of development we had a zip file of custom plugin, which can be uploaded to WordPress plugin manager and installed and activated to start the use