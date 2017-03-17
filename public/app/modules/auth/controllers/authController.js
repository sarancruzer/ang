app.controller('authController',function ($scope, $auth, $state, $http, $rootScope) {
$scope.doLogin = function (logdetail) {
           
            var credentials = {
                email: logdetail.email,
                password: logdetail.password
            }


        
            $auth.login(credentials).then(function(data) {

                $rootScope.user = data.data.details;
                $rootScope.curUser = data.data.details.name;
                $rootScope.userId = data.data.details.userid;
                $rootScope.userType = data.data.details.user_type;
                $rootScope.avatar = data.data.details.avatar;
                
                localStorage.setItem('usename',data.data.details.name);
                localStorage.setItem('userId',data.data.details.id);
                localStorage.setItem('userType',data.data.details.user_type);
                localStorage.setItem('avatar',data.data.details.avatar);

                $scope.user = data.data.details;
                var token = data.data.token;
                $rootScope.authenticated = true;
                $state.go('layout.profile',{});
                
            }, function(error) {
                $scope.loginError = true;
                $scope.loginErrorText = error.data.error;
            });        


        }
        
   

});