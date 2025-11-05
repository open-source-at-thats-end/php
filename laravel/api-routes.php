<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
/*
 * Register new user
*/

Route::get('/clear-cache', function () {
    $exitCode = Artisan::call('cache:clear');
    // return what you want
});

Route::group(['middleware' => 'cors'], function () {
    Route::resource('all/register', 'Api\UsersController', ['only' => ['store']]);

    Route::get('/get-zipcode-by-id/{zipcode}', 'Api\ZipcodeController@getZipCodeById')->name('get-zipcode-by-id');

    // Add leads for photographer to infusionSoft
    Route::post('user/add-photographer-contact', 'Api\UsersController@addPhotographerContact')->name('user.addPhotographerContact');

    // Retrieves the homepage
    //Route::get('/', 'HomeController@returnView')->name('home.view');

    // Retrieves information about an specific referral
    Route::get('user/showReferral/{id}', 'Api\UsersController@showReferral')->name('user.showReferral');

    //Verify user account from email sent at link
    Route::get('verify_account/{confirmationCode}', 'Api\UsersController@verifyAccount')->name('user.verifyAccount');

    //Verify token for the recovery password mail sent at link
    Route::get('password/verify_password_token/{token}', 'Api\AuthController@verifyPasswordToken')->name('auth.verifyPasswordToken');

    //Password recovery
    Route::post('password/recovery', 'Api\AuthController@passwordRecovery')->name('auth.password.recovery');

    //Password reset
    Route::patch('password/reset/{token}', 'Api\AuthController@passwordReset')->name('auth.password.reset');

    /*
         * PUBLIC AGENT ENDPOINTS
    */
    Route::get('/frontend/agent/{agentId}', 'Api\AgentsController@getPublicInfo')->name('agent.getPublicInfo');

    Route::get('/frontend/agent/getBySlug/{slug}', 'Api\AgentsController@getBySlug')->name('agent.getBySlug');

    Route::post('/frontend/agent/sendContactEmail', 'Api\AgentsController@sendContactEmail')->name('agent.sendContactEmail');

    /*
         * PUBLIC SELLER ENDPOINTS
    */
    Route::get('/frontend/seller/{sellerId}', 'Api\SellersController@getPublicInfo')->name('seller.getPublicInfo');

    Route::get('/frontend/seller/getBySlug/{slug}', 'Api\SellersController@getBySlug')->name('seller.getBySlug');

    //Route::post('/frontend/seller/sendContactEmail', 'Api\SellersController@sendContactEmail')->name('seller.sendContactEmail');

    /* returns all the sellers */
    Route::get('seller/getAllSellers', 'Api\SellersController@getAllSellers')->name('seller.getAllSellers');

    /*
         * PROPERTY PUBLIC ENDPOINTS
    */
    Route::get('/property/getByAgentId/{agentId}', 'Api\PropertiesController@getByAgentId')->name('property.getByAgentId');

    Route::get('/property/getBySellerId/{sellerId}', 'Api\PropertiesController@getBySellerId')->name('property.getBySellerId');

    Route::get('/property/list/', 'Api\PropertiesController@publicList')->name('property.getPublicList');

    Route::get('/property/categorized/', 'Api\PropertiesController@getCategorizedListing')->name('property.getCategorizedListing');

    Route::post('/property/search/', 'Api\PropertiesController@search')->name('property.search');

    Route::get('property/getLimitedList', 'Api\PropertiesController@getLimitedList')->name('property.getLimitedList');

    Route::get('property/getBySlug/{slug}', 'Api\PropertiesController@getBySlug')->name('property.getBySlug');

    // OpenGraph Things
    Route::get('property/view/{slug}', 'Api\PropertiesController@view')->name('property.view');

    Route::get('properties/view/{slug}', 'Api\PropertiesController@view')->name('property.view');

    /*
    * MEDIA PUBLIC ENDPOINTS
    */
    /* Returns all the published media files for a certain property */
    Route::get('media/getAllPublicByPropertyId/{propertyId}', 'Api\MediaFilesController@getAllPublicByPropertyId')->name('mediafiles.getAllPublicByPropertyId');

    /*
     * author Deepak Thakur
     * On next routes user needs to has his account validated
     * We use a middleware for this.
     */
    Route::group(['middleware' => 'auth:api'], function () {
        Route::group(['middleware' => 'user.verified'], function () {
            // Send email to Sales
            Route::post('/frontend/sendEmail', 'Api\ContactUsController@sendEmail')->name('frontend.sendEmail');

            Route::get('auth/user', 'Api\AuthController@user');

            //Profile update

            Route::put('user/profile', 'Api\UsersController@update')->name('user.profile.update');

            //Password update
            Route::patch('user/password', 'Api\UsersController@passwordUpdate')->name('user.password.update');

            // Get wallet amount
            Route::get('user/{userId}/wallet_amount', 'Api\UsersController@getWalletAmount')->name('user.wallet_amount');

            // Route::patch('user/addOrRemoveCredit', 'Api\UsersController@addOrRemoveCredit')->name('user.add.or.remove.credit');

            //Update mortgage
            Route::post('user/{userId}/setMortgageFlag', 'Api\UsersController@setMortgageFlag')->name('user.setMortgageFlag');

            /*
            * Routes for images
            */
            //Route::resource('images', 'Api\Controllers\ImagesController', ['only' => ['store', 'destroy']]);

            //get the user profile image
            Route::get('user/profile_image', 'Api\UsersController@getUserProfileImage')->name('user.profileImage');

            /*
            * Get all agents: reas and sellers by same firstname and lastname of user_is parameter
            */
            Route::post('user/getByUserFullname/', 'Api\UsersController@getByUserFullname')->name('user.getByUserFullname');

            /*
                 * Set to add new referal tab for user
            */
            Route::post('user/setReferralTab', 'Api\UsersController@setReferralTab')->name('user.setReferralTab');

            Route::post('user/userReferrals', 'Api\UsersController@userReferrals')->name('user.userReferrals');

            /*
            * Remove referal tab for user
            */
            Route::post('user/removeReferralTab', 'Api\UsersController@removeReferralTab')->name('user.setReferralTab');

            /*
            * Referrals backend
            */
            Route::resource('referrals', 'Api\ReferralsController', ['only' => ['index']]);

            Route::resource('referralsAmount', 'Api\ReferralsAmountController', ['only' => ['index']]);

            Route::resource('walletTransactions', 'Api\WalletTransactionsController', ['only' => ['index']]);

            Route::post('/packages/search', 'Api\PackagesController@search')->name('packages.search');

            Route::get('/packages/all', 'Api\PackagesController@getFullList')->name('packages.all');

            /*
             * Sort packages by position field
             *
             */
            //Route::post('/packages/sort', '\Rutorika\Sortable\SortableController@sort')->name('packages.sort');

            Route::patch('packages/changeActivationStatus/{id}', 'Api\PackagesController@changeActivationStatus')->name('packages.changeActivationStatus');

            Route::put('packages/addAssetType/{packageId}', 'Api\PackagesController@associateAsset')->name('packages.addAssetType');

            /*
            * Delete relation between package and asset
            */
            Route::patch('packages/removeAssetType/{packageId}', 'Api\PackagesController@removeAsset')->name('packages.removeAssetType');

            Route::put('packages/updateAssociatedAssets', 'Api\PackagesController@updateAssociatedAssets')->name('packages.updateAssociatedAssets');

            Route::resource('packages', 'Api\PackagesController', ['only' => ['show', 'store', 'update', 'create', 'index']]);

            /*
            * Transactions backend
            */
            Route::resource('transactions', 'Api\TransactionsController');

            /*
            * Orders routes
            */

            //Migrate agent id
            Route::post('/orders/migrateAgent/{order_id}', 'Api\OrdersController@migrateAgentId')->name('order.migrate.agent.id');

            Route::resource('orders', 'Api\OrdersController');

            Route::get('orders/{orderId}', 'Api\OrdersController@show');

            Route::post('/orders/place', 'Api\OrdersController@place');

            //Update field must have shots table orders.
            Route::put('/orders/{order_id}/updateMustHaveShots', 'Api\OrdersController@updateMustHaveShots')->name('order.updateMustHaveShots');

            Route::get('/orders/getStripeInfo/{OrderId}', 'Api\OrdersController@getStripeInfo')->name('order.getStripeInfo');

            Route::patch('orders/markAsFinished/{id}', 'Api\OrdersController@markAsFinished')->name('orders.markAsFinished');

            Route::patch('/orders/{order_id}/retryCallback', 'Api\OrdersController@retryCallback')->name('order.retryCallback');

            Route::put('/orders/{order_id}/changeSchedule', 'Api\OrdersController@changeSchedule')->name('order.changeSchedule');

            Route::put('/orders/{order_id}/changeRescheduledStatus', 'Api\OrdersController@changeRescheduledStatus')->name('order.changeRescheduledStatus');

            Route::patch('/orders/{order_id}/setStatusOnHold', 'Api\OrdersController@setStatusOnHold')->name('order.setStatusOnHold');

            Route::get('/orders/amountExtraFiles/{OrderId}', 'Api\OrdersController@amountExtraFiles')->name('order.amountExtraFiles');

            Route::get('/orders/getExtraFiles/{OrderId}', 'Api\OrdersController@getExtraFiles')->name('order.getExtraFiles');

            /*
            * Jobs routes
            */
            Route::get('/jobs/getJobByPhotographer', 'Api\JobsController@getJobByPhotographer')->name('job.getJobByPhotographer');

            Route::put('/jobs/reserve', 'Api\JobsController@reserve')->name('job.reserve');

            Route::put('/jobs/finishUpload', 'Api\JobsController@finishUpload')->name('job.finishUpload');

            Route::put('/jobs/cancelReserve/{id}', 'Api\JobsController@cancelReserve')->name('job.cancelReserve');

            Route::post('/jobs/sendUploadFailedNotification', 'Api\JobsController@sendUploadFailedNotification')->name('job.sendUploadFailedNotification');

            Route::post('/jobs/sendToEwarp/{id}', 'Api\JobsController@sendToEwarp')->name('job.sendToEwarp');

            Route::resource('jobs', 'Api\JobsController');

            /*
            * Redit Routes
            */
            Route::get('redit/ewarp_products', 'Api\ReditController@getEwarpProducts')->name('redit.ewarpProducts');

            Route::post('/order/reEdit', 'Api\ReditController@reEdit')->name('order.reEdit');

            /*
            * Zip codes Routes
            *
            */
            Route::post('zip/addNewLocation', 'Api\ZipController@addNewLocation')->name('zip.addNewLocation');

            Route::delete('zip/deleteByZip/{id}', 'Api\ZipController@deleteByZip')->name('zip.deleteByZip');

            /*
            *  Search page Routes
            *
            */
            Route::get('searchPage/getCategories', 'Api\SearchPageController@getCategories')->name('searchPage.getCategories');

            /*
            * Send media files ready email and generate zip
            *
            */
            Route::put('searchPage/updateDetails', 'Api\SearchPageController@updateDetails')->name('searchPage.updateDetails');

            /*
            * Send media files ready email and generate zip
            *
            */
            Route::post('searchPage/addPackageToCategory', 'Api\SearchPageController@addPackageToCategory')->name('searchPage.addPackageToCategory');

            /*
            * Delete a package from category
            */
            Route::delete('searchPage/deletePackage/{package_id}/fromCategory/{category_id}', 'Api\SearchPageController@deletePackageFromCategory')->name('searchPage.deletePackageFromCategory');

            //Update json file search-home.json
            Route::put('searchPage/updateHeaderTitle', 'Api\SearchPageController@updateHeaderTitle')->name('searchPage.SearchPageController');

            /*
            * Media Files Routes
            *
            */
            Route::patch('media/publish/{id}', 'Api\MediaFilesController@changePublishedMediaFile')->name('media.changePublishedMediaFile');

            /*
            * Publish all mediafiles of property
            */
            Route::patch('/mediafiles/publish', 'Api\MediaFilesController@publish')->name('media.publish');

            Route::get('/media/getJwPlayerCreatePostAction', 'Api\MediaFilesController@getJwPlayerCreatePostAction')->name('media.getJwPlayerCreatePostAction');

            /* Adds an specific mediafile type */
            Route::post('/media/add3DTour', 'Api\MediaFilesController@add3Dtour')->name('mediafile.add3dtour');

            /* Adds an specific mediafile type */
            Route::post('/media/addVideo', 'Api\MediaFilesController@addVideo')->name('mediafile.addVideo');

            /* Adds an specific mediafile type */
            Route::post('/media/addEmbedVideo', 'Api\MediaFilesController@addEmbedVideo')->name('mediafile.addEmbedVideo');

            /* deletes all the entries by a certain job id */
            Route::delete('/media/delete_all_by_job_id/{jobId}', 'Api\MediaFilesController@deleteAllByJobId')->name('job.deleteAllByJobId');

            /* returns the initial data for the amazon uploader form */
            Route::get('/media/get_initial_data/{jobId}/{propertyId}/{assetType}/{photoType}/{userId}/{orderId}', 'Api\MediaFilesController@getInitialData')->name('media.getInitialData');

            /*
            * Returns the actions post for the file Uploader with the correct
            * bucket and region of amazon
            */
            Route::get('/media/get_aws_action_post', 'Api\MediaFilesController@getAWSActionPost')->name('media.getBucketData');

            /*
            * Returns the request ok or not for a zip in one of the categories
            */
            Route::put('/media/request_zip_file', 'Api\MediaFilesController@getZipFile')->name('media.requestZipFile');

            /*
            * Returns the request ok or not for a zip extrafiles
            */
            Route::put('/media/request_zip_extra_file', 'Api\MediaFilesController@getZipExtraFile')->name('media.requestZipExtraFile');

            /*
            * Set the requested url as home video on frontend
            */
            Route::post('/media/set_home_video', 'Api\MediaFilesController@setHomeVideo')->name('media.setHomeVideo');

            /*
            * Sort property mediafiles by position field
            *
            */
            Route::post('/media/sort', '\Rutorika\Sortable\SortableController@sort')->name('media.sort');

            /*
            * Send media files ready email and generate zip
            * jun 15
            */
            Route::post('/media/sendMediaReadyEmail', 'Api\MediaFilesController@sendMediaReadyEmail')->name('media.sendMediaReadyEmail');

            Route::resource('media', 'Api\MediaFilesController', ['only' => ['store', 'update', 'destroy']]);

            /* returns all the media files by a certain property */
            Route::get('media/getAllByPropertyId/{propertyId}', 'Api\MediaFilesController@getAllByPropertyId')->name('mediafiles.getAllByPropertyId');

            /*
            * PROPERTY ENDPOINTS
            */
            //Get properties of current logged in agent
            Route::get('property/getAgentSellerProperties', 'Api\PropertiesController@getAgentSellerProperties')->name('property.getAgentSellerProperties');

            Route::get('property/getForLoggedInUserBySlug/{slug}', 'Api\PropertiesController@getForLoggedInUserBySlug')->name('property.getForLoggedInUserBySlug');

            Route::get('property/getForLoggedInUser/{id}', 'Api\PropertiesController@getForLoggedInUser')->name('property.getForLoggedInUser');

            Route::get('property/getPropertyForUpdate/{id}', 'Api\PropertiesController@getPropertyForUpdate')->name('property.getPropertyForUpdate');

            /**problem */
            Route::resource('property', 'Api\PropertiesController', ['only' => ['update']]);

            /*
            * Asset Types endpoints
            */
            Route::resource('asset_types', 'Api\AssetTypesController', ['only' => ['store', 'show', 'update', 'index']]);

            Route::patch('asset_types/changeActivationStatus/{id}', 'Api\AssetTypesController@changeActivationStatus')->name('asset_types.changeActivationStatus');

            /*
            * Mortgage Referrals endpoints
            */
            Route::resource('mortgage_referrals', 'Api\MortgageReferralsController', ['only' => ['show', 'index']]);

            /*
            * Client Recommendations endpoints
            */

            Route::patch('client_recommendation/changeActivationStatus/{id}', 'Api\ClientRecommendationsController@changeActivationStatus')->name('clientRecommendations.changeActivationStatus');

            //Profile update
            Route::resource('client_recommendation', 'Api\ClientRecommendationsController', ['only' => ['show', 'store', 'update', 'index']]);

            /*
            * AGENT ENDPOINTS
            * returns all the agents
            */
            Route::get('/agent/getAllAgents', 'Api\AgentsController@getAllAgents')->name('agent.getAllAgents');

            /*
            * USERS LISTING ENDPOINTS
            * 18 jun
            */
            Route::post('register/storeWithSuCheck', 'Api\UsersController@storeWithSuCheck')->name('register.storeWithSuCheck');

            Route::resource('user', 'Api\UsersController', ['only' => ['index', 'show']]);

            // Get the Referral Setting amount
            Route::get('/getReferralSettings', 'Api\SettingsController@getReferralSettings')->name('backend.getReferralSettings');

            // Update Referral Setting
            Route::put('/referralSetting', 'Api\SettingsController@referralSettingUpdate')->name('backend.referralSettingUpdate');

            // Get the double callback setting
            Route::get('/getCallbackSettings', 'Api\SettingsController@getCallbackSettings')->name('backend.getCallbackSettings');

            // Update Referral Setting
            Route::put('/callbackSetting', 'Api\SettingsController@callbackSettingUpdate')->name('backend.callbackSettingUpdate');

            /*
            * VIMEO
            */
            Route::get('/vimeo/getAccounts', '\App\VimeoIntegration\Http\Controllers\VimeoController@getAccounts')->name('vimeo.getAccounts');

            /*
            * HOME_PHOTOS
            */
            Route::post('home_photos/update_positions', 'Api\HomePhotosController@updatePositions')->name('home_photos.updatePositions');

            Route::post('home_photos/save_main_image', 'Api\HomePhotosController@saveMainImage')->name('home_photos.saveMainImage');

            Route::resource('home_photos', 'Api\HomePhotosController', ['only' => ['show', 'store', 'destroy', 'update', 'create']]);

            /*
            * URL METADATA ENDPOINTS
            */
            Route::post('/urlmetadata/createOrUpdate', 'Api\PageMetadataController@createOrUpdate')->name('urlmetadata.createOrUpdate');

            //Update json file
            Route::put('/homeMicrodata', 'Api\HomeMicrodataController@update')->name('backend.updateHomeMicrodata');

            //Update addons images
            Route::post('/addonsImages', 'Api\AddonsImagesController@saveImage')->name('backend.saveImage');

            /*
            * ANALYTICS API ENDPOINTS
            */
            Route::get('/analytics/getToken', 'Api\AnalyticsController@getToken')->name('analytics.getToken');

            Route::post('/analytics/sendEmailPropertyStatistics', 'Api\AnalyticsController@sendEmailPropertyStatistics')->name('analytics.sendEmailPropertyStatistics');

            /*
            * Callback Log enpoints
            */
            Route::get('/callback_logs/{order_id}', 'Api\CallbackLogsController@index')->name('callback_jobs');

            Route::put('/update_home_counters', 'Api\CountersController@updateHomeCounters')->name('updateHomeCounters');

            Route::get('/get_home_counters_recommended', 'Api\CountersController@getHomeCountersRecommended')->name('getHomeCountersRecommended');

            Route::resource('our_work', 'Api\HomeOurWorkController', ['only' => ['update', 'destroy']]);

            Route::get('/getAllOurWorks', 'Api\HomeOurWorkController@getAllOurWorks')->name('getAllOurWorks');

            //Update 3dTranslations
            Route::put('/home3dTranslations', 'Api\Home3dTranslationsController@update')->name('backend.updateHome3dTranslations');

            //Update lang file
            Route::put('/homeText', 'TextController@update')->name('backend.updateHomeText');

            //Facebook developer application
            Route::get('/facebook/getApp', 'Api\FacebookAppController@getApp')->name('facebook.getApp');

            //Create facebook developer application
            Route::post('/facebook/createNewFacebookApp', 'Api\FacebookAppController@createNewFacebookApp')->name('facebook.createNewApp');
        });
    });

    //Submit email on footer
    Route::post('user/submit_email', 'Api\UsersController@submitEmail')->name('user.submitEmail');
});

/* Login API Call */
Route::prefix('SchedulingAPI/api')->group(function () {
    Route::post(
        'Login/Login',
        [
            'uses' => 'LoginController@CheckLogin',
            'as' => 'user.login',
        ]
    );
    Route::post(
        'User/UserDeviceRegistration',
        [
            'uses' => 'LoginController@UserDeviceRegistration',
            'as' => 'user.device',
        ]
    );
    Route::post(
        'GetNewJobDetails/NewJobDetails',
        [
            'uses' => 'GetNewJobDetailsController@NewJobDetails',
            'as' => 'GetNewJobDetails.newjobdetails',
        ]
    );
    Route::post(
        'GetNewJobDetails/RescheduleJob',
        [
            'uses' => 'GetNewJobDetailsController@RescheduleJob',
            'as' => 'GetNewJobDetails.reschedulejob',
        ]
    );
    Route::post(
        'WebAPI/StartJob',
        [
            'uses' => 'WebAPIController@StartJob',
            'as' => 'WebAPI.startjob',
        ]
    );
    Route::post(
        'WebAPI/Get_Unavailablity',
        [
            'uses' => 'WebAPIController@GetUnavailablity',
            'as' => 'WebAPI.getunavailablity',
        ]
    );
    Route::post(
        'WebAPI/UpdateAssistantEmails',
        [
            'uses' => 'WebAPIController@UpdateAssistantEmails',
            'as' => 'WebAPI.updateassistantemails',
        ]
    );
    Route::post(
        'WebAPI/GetJobListing_ByUserID',
        [
            'uses' => 'WebAPIController@GetJobListingByUserID',
            'as' => 'WebAPI.getjoblistingbyuserid',
        ]
    );
    Route::post(
        'WebAPI/GetJobDetailsBy_UserId_JobID',
        [
            'uses' => 'WebAPIController@GetJobDetailsBy_UserId_JobID',
            'as' => 'WebAPI.getjobdetailsbyuseridjobid',
        ]
    );
    Route::post(
        'WebAPI/GetPackages',
        [
            'uses' => 'WebAPIController@GetPackages',
            'as' => 'WebAPI.getpackages',
        ]
    );
    Route::post(
        'WebAPI/changeSchedule',
        [
            'uses' => 'WebAPIController@ChangeSchedule',
            'as' => 'WebAPI.changeschedule',
        ]
    );
    Route::post(
        'WebAPI/GetDriveTime',
        [
            'uses' => 'WebAPIController@GetDriveTime',
            'as' => 'WebAPI.getdrivetime',
        ]
    );
    Route::post(
        'WebAPI/UploadImage',
        [
            'uses' => 'WebAPIController@UploadImage',
            'as' => 'WebAPI.UploadImage',
        ]
    );
    Route::post(
        'WebAPI/AcceptJob',
        [
            'uses' => 'WebAPIController@AcceptJob',
            'as' => 'WebAPI.acceptjob',
        ]
    );
    Route::post(
        'MessageAPI/GetMessage',
        [
            'uses' => 'MessageAPIController@GetMessage',
            'as' => 'MessageAPIController.getmessage',
        ]
    );
    Route::post(
        'MessageAPI/GetNotificationList',
        [
            'uses' => 'MessageAPIController@GetNotificationList',
            'as' => 'MessageAPIController.getnotificationlist',
        ]
    );
    Route::post(
        'MessageAPI/NotificationCount',
        [
            'uses' => 'MessageAPIController@GetNotificationCount',
            'as' => 'MessageAPIController.getnotificationcount',
        ]
    );
    Route::post(
        'MessageAPI/MarkAllRead',
        [
            'uses' => 'MessageAPIController@MarkAllRead',
            'as' => 'MessageAPIController.markallread',
        ]
    );
    Route::post(
        'MessageAPI/MarkRead',
        [
            'uses' => 'MessageAPIController@MarkRead',
            'as' => 'MessageAPIController.markread',
        ]
    );
    Route::post(
        'MessageAPI/SendMessage',
        [
            'uses' => 'MessageAPIController@SendMessage',
            'as' => 'MessageAPIController.sendmessage',
        ]
    );
    Route::post(
        'WebAPI/DeclineJob',
        [
            'uses' => 'WebAPIController@DeclineJob',
            'as' => 'WebAPIController.declinejob',
        ]
    );
    Route::post(
        'WebAPI/EndJob',
        [
            'uses' => 'WebAPIController@EndJob',
            'as' => 'WebAPIController.EndJob',
        ]
    );
    Route::post(
        'GetNewJobDetails/OnHoldJob',
        [
            'uses' => 'GetNewJobDetailsController@OnHoldJob',
            'as' => 'GetNewJobDetailsController.OnHoldJob',
        ]
    );
    Route::get(
        'GetNewJobDetails/AssignJobsToTire2Users',
        [
            'uses' => 'GetNewJobDetailsController@AssignJobsToTire2Users',
            'as' => 'GetNewJobDetailsController.AssignJobsToTire2Users',
        ]
    );
    Route::post(
        'changejobstatus',
        [
            'uses' => 'CronJobsController@ChangeJobStatusToUrgent',
            'as' => 'CronJobsController.ChangeJobStatusToUrgent',
        ]
    );
    Route::post(
        'HomeJabNotification',
        [
            'uses' => 'CronJobsController@HomeJabNotification',
            'as' => 'CronJobsController.HomeJabNotification',
        ]
    );
});
Route::post(
    'SchedulingAPI/Api/WebAPI/Delete_Unavailablity',
    [
        'uses' => 'WebAPIController@DeleteUnavailablity',
        'as' => 'WebAPI.deleteunavailablity',
    ]
);
Route::post(
    'SchedulingAPI/Api/WebAPI/Add_Edit_Unavailablity',
    [
        'uses' => 'WebAPIController@AddEditUnavailablity',
        'as' => 'WebAPI.addeditunavailablity',
    ]
);
Route::post(
    'SchedulingAPI/Notification',
    [
        'uses' => 'PushNotificationController@PushNotification',
        'as' => 'PushNotificationController.PushNotification',
    ]
);

// Admin Routes

//Route::group(['middleware' => 'auth:admin'], function () {
    Route::group(['middleware' => 'admin'], function () {
        Route::prefix('api/admin')->group(function () {
            // Photographer routes
            Route::post(
                'photographer/Search',
                [
                    'uses' => 'PhotographerController@Search',
                    'as' => 'Photographer.search',
                ]
            );
            Route::patch(
                'photographer/ChangeUserRank/{id}',
                [
                    'uses' => 'PhotographerController@ChangeUserRank',
                    'as' => 'Photographer.changeuserrank',
                ]
            );
            Route::patch(
                'photographer/ChangeActivateStatus/{id}',
                [
                    'uses' => 'PhotographerController@ChangeActivateStatus',
                    'as' => 'photographer.changeactivatestatus',
                ]
            );

            Route::get(
                'photographer/GetSelectedGroupList/{id}',
                [
                    'uses' => 'PhotographerController@GetSelectedGroupList',
                    'as' => 'photographer.getselectedgrouplist',
                ]
            );

            Route::post(
                'photographer/AssignGroup/{id}',
                [
                    'uses' => 'PhotographerController@AssignGroup',
                    'as' => 'photographer.assigngroup',
                ]
            );
            Route::get(
                'photographer/GetSelectedPackageList/{id}',
                [
                    'uses' => 'PhotographerController@GetSelectedPackageList',
                    'as' => 'photographer.getselectedpackagelist',
                ]
            );

            Route::get(
                'photographer/GetUsersPaymentInfoByUserId/{id}',
                [
                    'uses' => 'PhotographerController@GetUsersPaymentInfoByUserId',
                    'as' => 'photographer.getuserspaymentbyuserid',
                ]
            );

            Route::post(
                'photographer/AssignPaymentInfo/{id}',
                [
                    'uses' => 'PhotographerController@AssignPaymentInfo',
                    'as' => 'photographer.assignpaymentinfo',
                ]
            );
            Route::post(
                'photographer/GetUserUnavailabilityList/{id}',
                [
                    'uses' => 'PhotographerController@GetUserUnavailabilityList',
                    'as' => 'photographer.getuserunavailabilitylist',
                ]
            );

            Route::resource('photographer', 'PhotographerController');

            //Group routes
            Route::patch(
                'group/ChangeActivateStatus/{id}',
                [
                    'uses' => 'GroupController@ChangeActivateStatus',
                    'as' => 'group.changeactivatestatus',
                ]
            );

            Route::post(
                'group/Search',
                [
                    'uses' => 'GroupController@Search',
                    'as' => 'group.search',
                ]
            );

            Route::resource('group', 'GroupController');

            //Metadata Routes

            Route::resource('metadata', 'MetadataController');

            //Package Route
            Route::post(
                'package/AssignPackages',
                [
                    'uses' => 'UsersPackageController@AssignPackages',
                    'as' => 'package.assignpackages',
                ]
            );

            // Address location route
            Route::get(
                'jobs/addresslocation/{id}',
                [
                    'uses' => 'JobsController@GetOrderLocationByJobId',
                    'as' => 'jobs.getorderlocationbyjobId',
                ]
            );

            // Chat box route
            Route::get(
                'chat/getfullchatlist/{jobid}',
                [
                    'uses' => 'ChatBoxController@GerFullChatList',
                    'as' => 'chatbox.getfullchatlist',
                ]
            );
            Route::post(
                'chat/sendChatMessage',
                [
                    'uses' => 'ChatBoxController@sendChatMessage',
                    'as' => 'chatbox.sendChatMessage',
                ]
            );

            //Notification Routes
            Route::post(
                'notification/GetAllNoticationList',
                [
                    'uses' => 'NotificationController@GetAllNoticationList',
                    'as' => 'notification.getallnoticationlist',
                ]
            );
            Route::patch(
                'notification/UpdateIsClosedStatus/{jobid}',
                [
                    'uses' => 'NotificationController@UpdateIsClosedStatus',
                    'as' => 'notification.updateisclosedstatus',
                ]
            );
            Route::resource('notification', 'NotificationController');

            //orderDetail routes
            Route::get(
                'jobs/GetJobDetailByStatusId/{StatusId}',
                [
                    'uses' => 'JobsController@GetJobsDetailByStatusId',
                    'as' => 'jobs.getjobsdetailbystatusid',
                ]
            );
            Route::post(
                'jobs/Search/{StatusId}',
                [
                    'uses' => 'JobsController@Search',
                    'as' => 'jobs.search',
                ]
            );
            Route::get(
                'jobs/OnHoldJobByJobId/{jobid}',
                [
                    'uses' => 'JobsController@OnHoldJobByJobId',
                    'as' => 'jobs.onholdjobbyjobId',
                ]
            );
            Route::post(
                'jobs/ReScheduleJob',
                [
                    'uses' => 'JobsController@ReScheduleJob',
                    'as' => 'jobs.reschedulejob',
                ]
            );
            Route::post(
                'jobs/RescheduleAssignPhotographer',
                [
                    'uses' => 'JobsController@RescheduleAssignPhotographer',
                    'as' => 'jobs.rescheduleassignphotographer',
                ]
            );
            Route::resource('jobs', 'JobsController');

            //report routes
            Route::post(
                'report/{status}',
                [
                    'uses' => 'ReportsController@Report',
                    'as' => 'reports.report',
                ]
            );
            // export to excel
            /*Route::get(
                'api/admin/report/excel/{status}',
                [
                    'uses' => 'ReportsController@ExportToExcel',
                    'as'   => 'reports.excel'
                ]
            );*/
        });
    });
//});
// jabjob login route
Route::post('api/admin/login', 'UsersController@login');
