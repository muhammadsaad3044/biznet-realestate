<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    AuthController,
    CategoryController,
    SubCategoryController,
    BannerController,
    SubMainCategoryController,
    ProductController,
    ProductImagesController,
    RolesController,
    PermissionsController,
    SharelinkController,
    FvtProductCOntroller,
    ProductOverviewSalesSectionController,
    ProductOverviewHomeSectionTagsController,
    ProductOverviewHomeSectionIconsController,
    ProductOverviewHomeSectionCommentsController,
    ProductVideosController,
    TourInPersonController,
    TourOnVideoChatController,
    TalkToAgentController,
    HomeByCityController,
    ApartmentByCityController,
    RentByCityController,
    JobsController,
    EmailAlertsController,
    UserSearchController,
    SpecialOfferController,
    NewListController,
    StartAnOfferController,
    TiffenyAQuestionController,
    CareersController,
    ApplyForJobController,
    FvtJobController,
    CommunityController,
    ManageServiceController,
    ProjectInquiresController,
    ScheduleProjectController,
    ReviewManagementController,
    GetInTouchController,
    UserProfilingController,
    ProductFiltersController,
    RegisterQuestionsController,
    AnwserRegisterQuestionsController,
    RegisterQuestionsOptionsController,
    BlogsController,
    BlogImagesController,
    MainFaqsController,
    SuccessStoriesController,
    CoummunityEmailController,
    TopHeadlinesController,
    WhatsNewController,
    WhatsNewImagesController,
    ExecutiveLeaderController,
    UpComingEventsController,
    UpComingEventRegisterController,
    ChatController,
    OfferController
};
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/




Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// // Login & SignUp
// Route::post('/register', [AuthController::class, 'register']);
// Route::post('/login', [AuthController::class, 'login']);
// Route::get('/all-users', [AuthController::class, 'getusers']);
// Route::get('/user-profile/{id}', [AuthController::class, 'getuserprofile']);
// Route::post('/user-emailverify', [AuthController::class, 'checkuserlogin']);

// Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail']);
// Route::post('reset-password', [AuthController::class, 'reset']);

// Route::put('change-password', [AuthController::class, 'changepassword']);
// Route::put('profile-update/{id}', [AuthController::class, 'profileupdate']);

// // Get User Agent Fliter
// Route::get('/getuseragent/{agentname}', [AuthController::class, 'getuseragent']);

// // Get All Agents
// Route::get('/all-agents', [AuthController::class, 'getallagents']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/all-users', [AuthController::class, 'getusers']);
Route::get('/user-profile/{id}', [AuthController::class, 'getuserprofile']);
Route::post('/user-emailverify', [AuthController::class, 'checkuserlogin']);

// OTP based password reset flow
Route::post('/forgot-password', [AuthController::class, 'sendOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::put('/change-password', [AuthController::class, 'changepassword']);
Route::put('/profile-update/{id}', [AuthController::class, 'profileupdate']);

Route::get('/getuseragent/{agentname}', [AuthController::class, 'getuseragent']);
Route::get('/all-agents', [AuthController::class, 'getallagents']);

// Category
Route::get('/get-category', [CategoryController::class, 'index']);
Route::post('/store-category', [CategoryController::class, 'store']);
Route::put('/update-category/{id}', [CategoryController::class, 'update']);
Route::delete('/deletecategory/{id}', [CategoryController::class, 'destory']);


// Sub Category
Route::get('/subcategories/{id}', [SubCategoryController::class, 'index']);
Route::post('/store-sub-category', [SubCategoryController::class, 'store']);
Route::put('/update-sub-category/{id}', [SubCategoryController::class, 'update']);
Route::delete('/deletesubcategory/{id}', [SubCategoryController::class, 'destory']);


// Banner
Route::get('/get-banners', [BannerController::class, 'index']);
Route::post('/store-banner', [BannerController::class, 'store']);
Route::put('/update-banner/{id}', [BannerController::class, 'update']);
Route::delete('/deletebanner/{id}', [BannerController::class, 'destory']);

// Roles 
Route::get('/get-roles', [RolesController::class, 'index']);
Route::post('/store-role', [RolesController::class, 'store']);
Route::put('/update-role/{id}', [RolesController::class, 'update']);
Route::delete('/deleterole/{id}', [RolesController::class, 'destory']);

// Permissions
Route::get('/get-permissions', [PermissionsController::class, 'index']);
Route::post('/store-permissions', [PermissionsController::class, 'store']);
Route::put('/update-permissions/{id}', [PermissionsController::class, 'update']);
Route::delete('/deletepermissions/{id}', [PermissionsController::class, 'destory']);



// Product 
Route::get('/get-products', [ProductController::class, 'index']);
Route::get('/get-product/{id}', [ProductController::class, 'getproducts']);
Route::post('/store-product', [ProductController::class, 'store']);
Route::put('/update-product/{id}', [ProductController::class, 'update']);
Route::delete('/deleteproduct/{id}', [ProductController::class, 'destory']);

// Get Product Based on location 
Route::get('/getproduct/{lontitude}/{latitude}', [ProductController::class, 'getproductsbylocation']);
Route::get('/getallproducts/{value}', [ProductController::class, 'getallproducts']);

// Update Status of Product
Route::post('/update-productstatus', [ProductController::class, 'changestatus']);

// Get Products Based on Category
Route::get('/getallproductsbyCategory/{id}', [ProductController::class, 'getindexbycategory']);

// Approve product
Route::post('/approveproduct', [ProductController::class, 'approveproduct']);



// Product Images
Route::get('/get-productimages', [ProductImagesController::class, 'index']);
Route::post('/store-productimage', [ProductImagesController::class, 'store']);
Route::put('/update-productimage/{id}', [ProductImagesController::class, 'update']);
Route::delete('/deleteproductimage/{id}', [ProductImagesController::class, 'destory']);

// Store floor plan in imags table 
Route::post('/store-productfloorimage', [ProductImagesController::class, 'storefloorimage']);


// Product Share Listing
Route::get('/get-shareproduct', [SharelinkController::class, 'index']);
Route::post('/store-shareproduct', [SharelinkController::class, 'store']);
Route::put('/update-shareproduct/{id}', [SharelinkController::class, 'update']);
Route::delete('/deleteshareproduct/{id}', [SharelinkController::class, 'destory']);

// Fvt Products
Route::get('/get-fvtproducts/{id}', [FvtProductCOntroller::class, 'index']);
Route::post('/store-mfvtproducts', [FvtProductCOntroller::class, 'store']);
Route::delete('/deletefvtproduct/{id}', [FvtProductCOntroller::class, 'destory']);



// Products Videos

Route::get('/get-productvideos', [ProductVideosController::class, 'index']);
Route::post('/store-productvideo', [ProductVideosController::class, 'store']);
Route::put('/update-productvideo/{id}', [ProductVideosController::class, 'update']);
Route::delete('/deleteproductvideos/{id}', [ProductVideosController::class, 'destory']);

// OverView Sales Section  
Route::get('/get-productoverviewsales', [ProductOverviewSalesSectionController::class, 'index']);
Route::post('/store-productoverviewsale', [ProductOverviewSalesSectionController::class, 'store']);
Route::put('/update-productoverviewsale/{id}', [ProductOverviewSalesSectionController::class, 'update']);
Route::delete('/deleteproductoverviewsale/{id}', [ProductOverviewSalesSectionController::class, 'destory']);

// Overview Home  Section Tags 
Route::get('/get-productoverviewhome', [ProductOverviewHomeSectionTagsController::class, 'index']);
Route::post('/store-productoverviewhome', [ProductOverviewHomeSectionTagsController::class, 'store']);
Route::put('/update-productoverviewhome/{id}', [ProductOverviewHomeSectionTagsController::class, 'update']);
Route::delete('/deleteproductoverviewhome/{id}', [ProductOverviewHomeSectionTagsController::class, 'destory']);


// Overview Home  Section icons 
Route::get('/get-productoverviewhomeicons', [ProductOverviewHomeSectionIconsController::class, 'index']);
Route::post('/store-productoverviewhomeicon', [ProductOverviewHomeSectionIconsController::class, 'store']);
Route::put('/update-productoverviewhomeicon/{id}', [ProductOverviewHomeSectionIconsController::class, 'update']);
Route::delete('/deleteproductoverviewhomeicon/{id}', [ProductOverviewHomeSectionIconsController::class, 'destory']);


// Overview Home  Section Comments  
Route::get('/get-productoverviewhomecomments', [ProductOverviewHomeSectionCommentsController::class, 'index']);
Route::post('/store-productoverviewhomecomment', [ProductOverviewHomeSectionCommentsController::class, 'store']);
Route::put('/update-productoverviewhomecomment/{id}', [ProductOverviewHomeSectionCommentsController::class, 'update']);
Route::delete('/deleteproductoverviewhomecomment/{id}', [ProductOverviewHomeSectionCommentsController::class, 'destory']);

// Search By User ID
Route::get('/get-productoverviewhomecomments/{user_id}', [ProductOverviewHomeSectionCommentsController::class, 'user_index']);



// Tour In Person 
Route::get('/get-tourinpersons', [TourInPersonController::class, 'index']);
Route::post('/store-tourinperson', [TourInPersonController::class, 'store']);
Route::put('/update-tourinperson/{id}', [TourInPersonController::class, 'update']);
Route::delete('/deletetourinperson/{id}', [TourInPersonController::class, 'destory']);

// Search By User ID
Route::get('/get-tourinpersons/{user_id}', [TourInPersonController::class, 'user_index']);

// TOur On video chat
Route::get('/get-touronvideochat', [TourOnVideoChatController::class, 'index']);
Route::post('/store-touronvideochat', [TourOnVideoChatController::class, 'store']);
Route::put('/update-touronvideochat/{id}', [TourOnVideoChatController::class, 'update']);
Route::delete('/deletetouronvideochat/{id}', [TourOnVideoChatController::class, 'destory']);

// Search By User ID
Route::get('/get-touronvideochat/{user_id}', [TourOnVideoChatController::class, 'user_index']);


// Talk with agent 
Route::get('/get-talktoagent', [TalkToAgentController::class, 'index']);
Route::post('/store-talktoagent', [TalkToAgentController::class, 'store']);
Route::put('/update-talktoagent/{id}', [TalkToAgentController::class, 'update']);
Route::delete('/deletetalktoagent/{id}', [TalkToAgentController::class, 'destory']);


// Searchg By Home
Route::get('/get-searchbyhome', [HomeByCityController::class, 'index']);
Route::post('/store-searchbyhome', [HomeByCityController::class, 'store']);
Route::put('/update-searchbyhome/{id}', [HomeByCityController::class, 'update']);
Route::delete('/deletesearchbyhome/{id}', [HomeByCityController::class, 'destory']);
// Fliter
Route::get('/get-filterbyhome/{id}', [ProductController::class, 'home']);

// Searchg By Apartment
Route::get('/get-searchbyapartment', [ApartmentByCityController::class, 'index']);
Route::post('/store-searchbyapartment', [ApartmentByCityController::class, 'store']);
Route::put('/update-searchbyapartment/{id}', [ApartmentByCityController::class, 'update']);
Route::delete('/deletesearchbyapartment/{id}', [ApartmentByCityController::class, 'destory']);
// Fliter
Route::get('/get-filterbyapartment/{id}', [ProductController::class, 'apartment']);


// Searchg By Rent
Route::get('/get-searchbyrent', [RentByCityController::class, 'index']);
Route::post('/store-searchbyrent', [RentByCityController::class, 'store']);
Route::put('/update-searchbyrent/{id}', [RentByCityController::class, 'update']);
Route::delete('/deletesearchbyrent/{id}', [RentByCityController::class, 'destory']);
// Fliter
Route::get('/get-filterbyrent/{id}', [ProductController::class, 'rent']);

// Searchg By Job

Route::get('/get-jobs', [JobsController::class, 'index']);

Route::post('/get-approve-job', [JobsController::class, 'approve_job']);
Route::get('/get-all-approve-job', [JobsController::class, 'get_approve_job']);
Route::post('/store-job', [JobsController::class, 'store']);
Route::put('/update-job/{id}', [JobsController::class, 'update']);
Route::delete('/deletejob/{id}', [JobsController::class, 'destory']);

// Filter on Jobs
Route::get('/get-jobs/{search}', [JobsController::class, 'getjobdata']);


// EMail ALerts
Route::get('/get-email-alerts', [EmailAlertsController::class, 'index']);
Route::post('/store-email-alerts', [EmailAlertsController::class, 'store']);


// User Search 
Route::get('/get-user-search', [UserSearchController::class, 'index']);
Route::get('/get-user-search/{user_id}', [UserSearchController::class, 'user_index']);
Route::post('/store-user-search', [UserSearchController::class, 'store']);
Route::put('/update-user-search/{id}', [UserSearchController::class, 'update']);
Route::delete('/deleteusersearch/{id}', [UserSearchController::class, 'destory']);


//  Special offer
Route::get('/get-special-offer', [SpecialOfferController::class, 'index']);
Route::post('/store-special-offer', [SpecialOfferController::class, 'store']);
Route::put('/update-special-offer/{id}', [SpecialOfferController::class, 'update']);
Route::delete('/deletespecialoffer/{id}', [SpecialOfferController::class, 'destory']);



// New List   
Route::get('/get-new-list', [NewListController::class, 'index']);
Route::post('/store-new-list', [NewListController::class, 'store']);
Route::put('/update-new-list/{id}', [NewListController::class, 'update']);
Route::delete('/deletenewlist/{id}', [NewListController::class, 'destory']);
// Search with user_id
Route::get('/get-new-list/{user_id}', [NewListController::class, 'user_index']);

// Start An Offer 
Route::get('/get-start-offer', [StartAnOfferController::class, 'index']);
Route::post('/store-start-offer', [StartAnOfferController::class, 'store']);
Route::put('/update-start-offer/{id}', [StartAnOfferController::class, 'update']);
Route::delete('/deletestartoffer/{id}', [StartAnOfferController::class, 'destory']);

// Get Filter based on product id and user_id
Route::get('/get-start-offer/{p_id}', [StartAnOfferController::class, 'product_index']);
Route::get('/get-start-offer-user/{user_id}', [StartAnOfferController::class, 'user_index']);

// Tiffeny a question
Route::get('/get-tiffeny-question', [TiffenyAQuestionController::class, 'index']);
Route::post('/store-tiffeny-question', [TiffenyAQuestionController::class, 'store']);
Route::delete('/deletetiffenyquestion/{id}', [TiffenyAQuestionController::class, 'destory']);





// Careers
Route::get('/get-careers', [CareersController::class, 'index']);

Route::get('/get-career/{id}', [CareersController::class, 'getindex']);

Route::post('/store-careers', [CareersController::class, 'store']);
Route::put('/update-careers/{id}', [CareersController::class, 'update']);
Route::delete('/deletecareers/{id}', [CareersController::class, 'destory']);



// Apply For job
Route::get('/get-apply-for-job', [ApplyForJobController::class, 'index']);

Route::post('/store-apply-for-job', [ApplyForJobController::class, 'store']);
// My Info Sections
Route::post('/store-job-my-info', [ApplyForJobController::class, 'my_info_store']);
// My Experience
Route::post('/store-job-my-experience', [ApplyForJobController::class, 'my_expeirence_store']);
// Application Questions
Route::post('/store-apply-job-application-questions', [ApplyForJobController::class, 'application_questions_store']);


Route::put('/update-apply-for-job/{id}', [ApplyForJobController::class, 'update']);
// My Info Sections
Route::put('/update-job-my-info/{job_id}', [ApplyForJobController::class, 'update_info_store']);
// My Experience
Route::put('/update-job-my-experience/{job_id}', [ApplyForJobController::class, 'update_my_expeirence_store']);
// Application Questions
Route::put('/update-apply-job-application-questions/{job_id}', [ApplyForJobController::class, 'update_application_questions_store']);

Route::delete('/deleteapplyforjob/{id}', [ApplyForJobController::class, 'destory']);



// fvt Jobs 

Route::get('/get-fvt-job/{user_id}', [FvtJobController::class, 'user_index']);
Route::get('/get-all-fvt-job', [FvtJobController::class, 'index']);
Route::post('/store-fvt-job', [FvtJobController::class, 'store']);
Route::delete('/removefvtjob/{id}', [FvtJobController::class, 'destory']);


// Community
Route::get('/get-community', [CommunityController::class, 'index']);
Route::post('/store-community', [CommunityController::class, 'store']);
Route::delete('/deletecommunity/{id}', [CommunityController::class, 'destory']);



//  Manage Services
Route::get('/get-manage-services', [ManageServiceController::class, 'index']);
Route::post('/store-manageservice', [ManageServiceController::class, 'store']);
Route::put('/update-manageservice/{id}', [ManageServiceController::class, 'update']);
Route::delete('/deletemanageservice/{id}', [ManageServiceController::class, 'destory']);


// Inquires
Route::get('/get-inquires', [ProjectInquiresController::class, 'index']);
Route::post('/store-inquire', [ProjectInquiresController::class, 'store']);
Route::put('/update-inquire/{id}', [ProjectInquiresController::class, 'update']);
Route::delete('/deleteinquire/{id}', [ProjectInquiresController::class, 'destory']);

// Schedule
Route::get('/get-schedules', [ScheduleProjectController::class, 'index']);
Route::post('/store-schedule', [ScheduleProjectController::class, 'store']);
Route::put('/update-schedule/{id}', [ScheduleProjectController::class, 'update']);
Route::delete('/deleteschedule/{id}', [ScheduleProjectController::class, 'destory']);

// Review
Route::get('/get-reviews', [ReviewManagementController::class, 'index']);
Route::post('/store-review', [ReviewManagementController::class, 'store']);
Route::put('/update-review/{id}', [ReviewManagementController::class, 'update']);
Route::delete('/deletereview/{id}', [ReviewManagementController::class, 'destory']);


// Get In Touch
Route::get('/all-getintouch', [GetInTouchController::class, 'index']);
Route::post('/store-getintouch', [GetInTouchController::class, 'store']);
Route::put('/update-getintouch/{id}', [GetInTouchController::class, 'update']);
Route::delete('/deletegetintouch/{id}', [GetInTouchController::class, 'destory']);

// User Profiling
Route::get('/get-userprofiling', [UserProfilingController::class, 'index']);
Route::get('/get-userprofiling/{user_id}', [UserProfilingController::class, 'getUserindex']);
Route::post('/store-userprofiling', [UserProfilingController::class, 'store']);
Route::put('/update-userprofiling/{id}', [UserProfilingController::class, 'update']);
Route::delete('/deleteuserprofiling/{id}', [UserProfilingController::class, 'destory']);


// For Recent Products
Route::get('/get-recentproducts', [ProductFiltersController::class, 'getrecentindex']);

// For Sold Property
Route::get('/get-soldproperty', [ProductFiltersController::class, 'getsoldindex']);

// For Sale Property
Route::get('/get-saleproperty', [ProductFiltersController::class, 'getsalesindex']);


// Global Serach 
Route::get('/get-searchproduct/{search}', [ProductFiltersController::class, 'getsearchindex']);



// Register Questions 
Route::get('/get-questions/{user_type}', [RegisterQuestionsController::class, 'index']);
Route::post('/store-questions', [RegisterQuestionsController::class, 'store']);
Route::delete('/deletequestions/{id}', [RegisterQuestionsController::class, 'destory']);
Route::put('/register-question/{id}', [RegisterQuestionsController::class, 'update']);


// Register Answers

Route::get('/check-questionnaire-status/{user_id}', [AnwserRegisterQuestionsController::class, 'index']);
Route::post('/store-answers', [AnwserRegisterQuestionsController::class, 'store']);

// Get USers with Similar Answers
Route::get('/getsimilarusers/{user_id}', [AnwserRegisterQuestionsController::class, 'getsimilarusers']);



// Register Questions Options
Route::get('/get-question-options/{question_id}', [RegisterQuestionsOptionsController::class, 'index']);
Route::post('/store-questionoptions', [RegisterQuestionsOptionsController::class, 'store']);
Route::put('/update-questionoptions/{id}', [RegisterQuestionsOptionsController::class, 'update']);
Route::delete('/deletequestionoptions/{id}', [RegisterQuestionsOptionsController::class, 'destory']);


// Blogs
Route::get('/all-blogs', [BlogsController::class, 'index']);
Route::post('/store-blogs', [BlogsController::class, 'store']);
Route::put('/update-blogs/{id}', [BlogsController::class, 'update']);
Route::delete('/deleteblogs/{id}', [BlogsController::class, 'destory']);


// Filter
Route::get('/get-featurrblog', [BlogsController::class, 'getfeatureblog']);
Route::get('/get-latestblog', [BlogsController::class, 'getlatestblog']);
Route::get('/get-blog/{id}', [BlogsController::class, 'getsingleblog']);


// BlogsImages
Route::get('/all-blogimages', [BlogImagesController::class, 'index']);
Route::post('/store-blogimages', [BlogImagesController::class, 'store']);
Route::put('/update-blogimages/{id}', [BlogImagesController::class, 'update']);
Route::delete('/deleteblogimages/{id}', [BlogImagesController::class, 'destory']);


// Main Faqs
Route::get('/all-mainfaqs', [MainFaqsController::class, 'index']);
Route::post('/store-mainfaqs', [MainFaqsController::class, 'store']);
Route::put('/update-mainfaqs/{id}', [MainFaqsController::class, 'update']);
Route::delete('/deletemainfaqs/{id}', [MainFaqsController::class, 'destory']);


// Success Stories
Route::get('/all-stories', [SuccessStoriesController::class, 'index']);
Route::post('/store-stories', [SuccessStoriesController::class, 'store']);
Route::put('/update-stories/{id}', [SuccessStoriesController::class, 'update']);
Route::delete('/deletestories/{id}', [SuccessStoriesController::class, 'destory']);


Route::post('/send-communityemails', [CoummunityEmailController::class, 'sendemail']);




// Top headlines
Route::get('/all-headlines', [TopHeadlinesController::class, 'index']);
Route::post('/store-headlines', [TopHeadlinesController::class, 'store']);
Route::put('/update-headlines/{id}', [TopHeadlinesController::class, 'update']);
Route::delete('/deleteheadlines/{id}', [TopHeadlinesController::class, 'destory']);


// whats new
Route::get('/all-whatsnew', [WhatsNewController::class, 'index']);
Route::post('/store-whatsnew', [WhatsNewController::class, 'store']);
Route::put('/update-whatsnew/{id}', [WhatsNewController::class, 'update']);
Route::delete('/deletewhatsnew/{id}', [WhatsNewController::class, 'destory']);


// whats new images
Route::get('/all-whatsnewimg', [WhatsNewImagesController::class, 'index']);
Route::post('/store-whatsnewimg', [WhatsNewImagesController::class, 'store']);
Route::put('/update-whatsnewimg/{id}', [WhatsNewImagesController::class, 'update']);
Route::delete('/deletewhatsnewimg/{id}', [WhatsNewImagesController::class, 'destory']);


// Executive Leadership
Route::get('/all-executiveleaders', [ExecutiveLeaderController::class, 'index']);
Route::post('/store-executiveleaders', [ExecutiveLeaderController::class, 'store']);
Route::put('/update-executiveleaders/{id}', [ExecutiveLeaderController::class, 'update']);
Route::delete('/deleteexecutiveleaders/{id}', [ExecutiveLeaderController::class, 'destory']);



// UpComing Events
Route::get('/all-upcomingevents', [UpComingEventsController::class, 'index']);
Route::post('/store-upcomingevents', [UpComingEventsController::class, 'store']);
Route::put('/update-upcomingevents/{id}', [UpComingEventsController::class, 'update']);
Route::delete('/deleteupcomingevents/{id}', [UpComingEventsController::class, 'destory']);


// UpComing Events Register
Route::get('/all-upcomingeventsregister', [UpComingEventRegisterController::class, 'index']);
Route::post('/store-upcomingeventsregister', [UpComingEventRegisterController::class, 'store']);
Route::put('/update-upcomingeventsregister/{id}', [UpComingEventRegisterController::class, 'update']);
Route::delete('/deleteupcomingeventsregister/{id}', [UpComingEventRegisterController::class, 'destory']);


// Chat
Route::post('/storechat', [ChatController::class, 'storeMessages'])->name('storechat')->middleware('throttle:1000,1');
Route::get('/get-chat/{senderId}/{receiverId}', [ChatController::class, 'fetchMessages'])->name('getchat')->middleware('throttle:1000,1');
// gets count of unreadable messages
Route::get('/unread-messages/{senderId}/{receiverId}', [ChatController::class, 'unreadmesaages'])->name('unreadmesaages')->middleware('throttle:1000,1');
// Mark as need api 

Route::post('/mark-messages-read', [ChatController::class, 'markasread'])->name('markasread')->middleware('throttle:1000,1');


Route::get('/offers', [OfferController::class, 'index']);
Route::post('/offers', [OfferController::class, 'store']);
Route::get('/offers/{id}', [OfferController::class, 'show']);
Route::put('/offers/{id}', [OfferController::class, 'update']);
Route::delete('/offers/{id}', [OfferController::class, 'destroy']);
