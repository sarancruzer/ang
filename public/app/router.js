
app.config(function($stateProvider, $urlRouterProvider, $authProvider) {
            // Satellizer configuration that specifies which API
            // route the JWT should be retrieved from
            $authProvider.loginUrl = '/api/authenticate';
            // Redirect to the auth state if any other states
            // are requested other than users
            $urlRouterProvider.otherwise('/auth');
            $stateProvider
            .state('layout', {
                    templateUrl: '/app/modules/shared/template.html',
                })
                .state('auth', {
                    url: '/auth',
                    templateUrl: '/app/modules/auth/views/login.html',
                    controller: 'AuthController as auth'
                })
                .state('layout.users', {
                    url: '/users',
                    templateUrl: '/app/modules/users/views/userView.html',
                    controller: 'UserController as user'
                });
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
                $location.path("/users");
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