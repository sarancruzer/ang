app.controller('authController',function ($scope, $auth, $state, $http, $rootScope) {
$scope.doLogin = function (logdetail) {
           
            var credentials = {
                email: logdetail.email,
                password: logdetail.password
            }


        
            $auth.login(credentials).then(function(data) {
                $rootScope.user = data.data.details;

                console.log(data);
                
                // $rootScope.Username = data.data.details.name;
                // $rootScope.UserType = data.data.details.user_type;
                // $rootScope.Email = data.data.details.email;
                
                
                // localStorage.setItem('usename',data.name);
                // localStorage.setItem('email',data.id);
                // localStorage.setItem('userType',data.user_type);
                
                var token = data.data.token;
                $rootScope.authenticated = true;
                $state.go('layout.profile', {});
                
            }, function(error) {
                $scope.loginError = true;
                $scope.loginErrorText = error.data.error;
            });        


        }
        
   

});