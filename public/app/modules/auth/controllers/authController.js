// (function() {    'use strict';
//     angular.module('authApp').controller('AuthController', AuthController);


//     function AuthController($auth, $state) {

//         var vm = this;
            
//         vm.login = function() {

//             var credentials = {
//                 email: vm.email,
//                 password: vm.password
//             }
            
//             // Use Satellizer's $auth service to login
//             $auth.login(credentials).then(function(data) {

//                 // If login is successful, redirect to the users state
//                 $state.go('layout.users', {});
//             });
//         }

//     }

// })();


app.controller('AuthController',function ($scope, $auth, $state, $http, $rootScope) {


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

                
            }, function(error) {
                $scope.loginError = true;
                $scope.loginErrorText = error.data.error;
            });        


        }
        
   

});