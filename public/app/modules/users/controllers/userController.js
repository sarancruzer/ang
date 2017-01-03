
app.controller("UserController",function ($scope, $auth, $state, $http, $rootScope){
        $scope.totalPages   = 0;
        $scope.currentPage  = 0;
        $scope.range = 0;
        $scope.init= function(page){
            
            var request = {
                method:"POST",
                url:"/api/getUsers?page="+page,
                data:{},
                headers : {'Content-Type' : 'application/json'},
            };
            $http(request).then(function successCallback(response) {
                $scope.details = response.data.result.info.data;
                $scope.totalPages   = response.data.result.last_page;
                $scope.currentPage  = response.data.result.current_page;

                // Pagination Range
                var pages = [];
                for(var i=1;i<=response.data.result.last_page;i++) {          
                  pages.push(i);
                }
                $scope.range = pages;

            }, function errorCallback(response) {
                $scope.CPError=response.data.error;
                if(response.status == 404){
                    $scope.CPError = response.statusText;
                }
            });
        };

        $scope.init(1);

      
        
       

        
});