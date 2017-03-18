
app.config(function($stateProvider, $urlRouterProvider, $authProvider) {
            // Satellizer configuration that specifies which API
            // route the JWT should be retrieved from
            $authProvider.loginUrl = '/api/authenticate';
            // Redirect to the auth state if any other states
            // are requested other than users
            $urlRouterProvider.otherwise('/');
            $stateProvider
            .state('layout', {
                    templateUrl: 'app/modules/shared/template.html',
                })
                .state('auth', {
                    url: '/auth',
                    templateUrl: 'app/modules/auth/views/login.html',
                    controller: 'authController as auth'
                })
                .state('logout',{
                    url:'/logout',
                    controller:'logoutController as logout',
                })
                .state('layout.users', {
                    url: '/users',
                    templateUrl: '/app/modules/users/views/userView.html',
                    controller: 'userController as user'
                })
                .state('layout.profile',{
                  url : '/profile',
                  templateUrl:'app/modules/profile/views/_profile.html',
                  controller : 'profileController as profile'
                })
                .state('layout.supplierList',{
                  url : '/supplierList',
                  templateUrl : '/app/modules/supplier/views/_supplierList.html',
                  controller : 'manageSupplierController as manageSupplier',
                  pageTitile : 'Suppliers'
                })
                .state('layout.supplierAdd',{
                  url : '/supplierAdd',
                  templateUrl : '/app/modules/supplier/views/_supplierAdd.html',
                  controller: 'supplierAddController as addSupplier',
                  pageTitle : 'Add Supplier'
                })
                .state('layout.supplierEdit',{
                  url:'/supplierEdit/:id',
                  templateUrl:'/app/modules/supplier/views/_supplierEdit.html',
                  controller:'supplierEditController as supplierEdit',
                  pageTitle:'Edit Supplier'
                })
                .state('layout.productList',{
                  url : '/productList',
                  templateUrl : '/app/modules/product/views/_productList.html',
                  controller : 'manageProductController as manageProduct',
                  pageTitile : 'Products'
                })
                .state('layout.productAdd',{
                  url : '/productAdd',
                  templateUrl : '/app/modules/product/views/_productAdd.html',
                  controller: 'productAddController as addProduct',
                  pageTitle : 'Add Product'
                })
                .state('layout.productEdit',{
                  url:'/productEdit/:id',
                  templateUrl:'/app/modules/product/views/_productEdit.html',
                  controller:'productEditController as productEdit',
                  pageTitle:'Edit Product'
                })
                .state('layout.productinwardList',{
                  url : '/productinwardList',
                  templateUrl : '/app/modules/productinward/views/_productinwardList.html',
                  controller : 'manageProductinwardController as manageProductinward',
                  pageTitile : 'Products '
                })
                .state('layout.productinwardAdd',{
                  url : '/productinwardAdd',
                  templateUrl : '/app/modules/productinward/views/_productinwardAdd.html',
                  controller: 'productinwardAddController as productinwardAdd',
                  pageTitle : 'Add Product'
                })
                .state('layout.productinwardEdit',{
                  url:'/productinwardEdit/:id',
                  templateUrl:'/app/modules/productinward/views/_productinwardEdit.html',
                  controller:'productinwardEditController as productinwardEdit',
                  pageTitle:'Edit Product'
                })
                .state('layout.productinwardShow',{
                  url:'/productinwardShow/:id',
                  templateUrl:'/app/modules/productinward/views/_productinwardShow.html',
                  controller:'productinwardShowController as productinwardShow',
                  pageTitle:'Show Product'
                })
                .state('layout.stockList',{
                  url:'/stockList',
                  templateUrl:'/app/modules/stock/views/_stockList.html',
                  controller:'manageStockController as manageStock',
                  pageTitle:'Show Product'
                })
                


        });

app.run(['$rootScope', '$location','$auth','$state', function ($rootScope, $location, $auth, $state, $templateCache) {

     $rootScope.$on('$stateChangeSuccess',function(event, toState, toParams, fromState, fromParams){
        $rootScope.pageTitle = toState.pageTitle;
        $rootScope.url = toState.url;
  });

    $rootScope.$on( "$locationChangeStart", function(event, next, current) {
      if (!$auth.isAuthenticated()) {
        if($location.path() != "/auth"){
           $location.path("/auth");
        }       
        $rootScope.authenticated = false;
      }
      else
      { 
        $rootScope.authenticated = true;
        $rootScope.userId = localStorage.getItem('userId');
        $rootScope.usename = localStorage.getItem('usename');
        
        if($location.path() == "/auth" || $location.path() == "/")
        {
            if ($auth.isAuthenticated()) {          
                $location.path("/profile");
              }
        }
      }
  });



  $rootScope.userType = localStorage.getItem('userType');
  $rootScope.userId = localStorage.getItem('userId');
  $rootScope.usename = localStorage.getItem('usename');
  $rootScope.userTypeId = localStorage.getItem('userTypeId');
  $rootScope.paginate = localStorage.getItem('paginate');
  $rootScope.avatar = localStorage.getItem('avatar');

}]);