
app.controller("manageStockController",function ($scope, $auth, $state, $http, $rootScope){
        $scope.totalPages   = 0;
        $scope.currentPage  = 0;
        $scope.range = 0;
        $scope.search_value="";
        $scope.init= function(page,searchValue){
            
            var request = {
                method:"POST",
                url:"/api/getStockList?page="+page,
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
                
                $scope.MSError = "";

            }, function errorCallback(response) {
                $scope.MSError=response.data.error;
                $scope.details=[];
                if(response.status == 404){
                    $scope.MSError = response.statusText;
                }
            });
        };


        $scope.init(1,"");

        $scope.modelDel = function(id){
            $scope.delId = id;
        }

        $scope.productDelete = function(){
            console.log($scope.delId);
            var data = {"id":$scope.delId};
            var request = {
                    method:"POST",
                    url:"/api/productDelete",
                    data:data,
                    headers : {'Content-Type':'application/json'}   
            };
            $http(request).then(function successCallback(response){
                
                $scope.SpSuccess=response.data.result;
                 $scope.init(1,"");
            },function errorCallback(response){
                $scope.SpError=response.data.error;
                if(response.status == 404){
                    $scope.SpError = response.statusText;
                }
            });
        }


        $scope.searchFilter = function(){
            console.log($scope.search_value);
            $scope.init(1,$scope.search_value);    
        }
       
        
});