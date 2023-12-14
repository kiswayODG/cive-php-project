<?php
session_start();
require_once('src/model/User.php');
require_once('src/model/Course.php');
require_once('src/services/UserService.php');
require_once('src/services/administration/CourseService.php');
require_once('src/services/administration/AdminService.php');
require_once('src/services/administration/AdminNewsService.php');
require_once('src/services/administration/AdminDocService.php');
require_once('AltoRouter.php');

$router = new AltoRouter();
$page = $_GET['page'] ?? '404';
$admincontroller = new AdminService();
$coursecontroller = new CourseService();

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->map('GET','/',function(){
    $ucontroller = new UserService();
    $ucontroller->index();
});

$router->map('GET','/news-details/[i:id]',function($id){
    $ucontroller = new UserService();
    $ucontroller->news_details();
});



$router->map('GET','/index',function(){
    $ucontroller = new UserService();
    $ucontroller->index();
});

$router->map('GET','/login',function(){
    $ucontroller = new UserService();
    $ucontroller->user_login();
});

$router->map('GET','/admin',function(){
    $admincontroller = new AdminService();
    $admincontroller->index();
});

$router->map('GET','/admin/users',function(){
    $admincontroller = new AdminService();
    $admincontroller->showUsers();
});

$router->map('GET','/admin/get-user-details/[i:id]',function($id){
    $admincontroller = new AdminService();
    $admincontroller->getUser($id);
});

$router->map('POST','/delete-user',function(){
    $admincontroller = new AdminService();
    $admincontroller->deleteUser();
});

$router->map('GET|POST','/admin/store-user',function(){
    $admincontroller = new AdminService();
    $admincontroller->createUserFromForm();
});




$router->map('GET','/admin/news-class',function(){
    $newscontroller = new AdminNewsService();
    $newscontroller->showNewsClass();
});

$router->map('GET','/admin/get-news-class-details/[i:id]',function($id){
    $newscontroller = new AdminNewsService();
    $newscontroller->getNewsClass($id);
});

$router->map('POST','/delete-news-class',function(){
    $newscontroller = new AdminNewsService();
    $newscontroller->deleteNewsClass();
});

$router->map('GET|POST','/admin/store-news-class',function(){
    $newscontroller = new AdminNewsService();
    $newscontroller->createNewsClassFromForm();
});



$router->map('GET','/admin/news',function(){
    $newscontroller = new AdminNewsService();
    $newscontroller->showNews();
});

$router->map('GET','/admin/get-news-details/[i:id]',function($id){
    $newscontroller = new AdminNewsService();
    $newscontroller->getNews($id);
});

$router->map('POST','/delete-news',function(){
    $newscontroller = new AdminNewsService();
    $newscontroller->deleteNews();
});

$router->map('GET|POST','/admin/store-news',function(){
    $newscontroller = new AdminNewsService();
    $newscontroller->createNewsFromForm();
});

$router->map('GET','/admin/courses',function(){
    $coursecontroller = new CourseService();
    $coursecontroller->showCourse();
});

$router->map('GET','/admin/get-courses-details/[i:id]',function($id){
    $coursecontroller = new CourseService();
    $coursecontroller->getCourse($id);
});

$router->map('POST','/delete-courses',function(){
    $coursecontroller = new CourseService();
    $coursecontroller->deleteCourse();
});

$router->map('GET|POST','/admin/store-courses',function(){
    $coursecontroller = new CourseService();
    $coursecontroller->createCourseForm();
});


$router->map('GET','/admin/docs',function(){
    $docscontroller = new AdminDocService();
    $docscontroller->showDocuments();
});

$router->map('GET','/admin/get-docs-details/[i:id]',function($id){
    $docscontroller = new AdminDocService();
    $docscontroller->getDocument($id);
});

$router->map('POST','/delete-docs',function(){
    $docscontroller = new AdminDocService();
    $docscontroller->deleteDocument();
});

$router->map('GET|POST','/admin/store-docs',function(){
    $docscontroller = new AdminDocService();
    $docscontroller->createOrUpdateDocumentFromForm();
});
$router->map('GET|POST','/login-check',function(){
    $ucontroller = new UserService();
    $ucontroller->login_final();

});




$match = $router->match();
if ($match!==null){
    call_user_func_array($match['target'],$match['params']);
}