
app.controller("manageSupplierController",function ($scope, $auth, $state, $http, $rootScope){
        $scope.totalPages   = 0;
        $scope.currentPage  = 0;
        $scope.range = 0;
        $scope.init= function(page,searchValue){
            
            var request = {
                method:"POST",
                url:"/api/getSupplierList?page="+page,
                data:{"searchValue":searchValue},
                headers : {'Content-Type' : 'application/json'},
            };
            $http(request).then(function successCallback(response) {
                $scope.details = response.data.result.info.data;
                $scope.totalPages   = response.data.result.info.last_page;
                $scope.currentPage  = response.data.result.info.current_page;

                // Pagination Range
                var pages = [];
                for(var i=1;i<=response.data.result.info.last_page;i++) {          
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


        $scope.init(1,"");



        $scope.addSupplier = function(){

            console.log();
        }

      
        
       

        
});