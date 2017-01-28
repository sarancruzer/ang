
app.controller("productAddController",function ($scope, $auth, $state, $http, $rootScope,$location){
        

         $scope.getAllSuppliers= function(){
            var request = {
                method:"POST",
                url:"/api/getAllSuppliers",
                data:{},
                headers : {'Content-Type' : 'application/json'},
            };
            $http(request).then(function successCallback(response) {
                $scope.suppliers = response.data.result;
                console.log(response);
                console.log($scope.suppliers);
                
            }, function errorCallback(response) {
                $scope.CPError=response.data.error;
                if(response.status == 404){
                    $scope.CPError = response.statusText;
                }
            });
        };

        $scope.getAllSuppliers();


        $scope.productAddFunc = function(form){
            var data = $scope.product;
            console.log(data);
            var request = {
                method:"POST",
                url:"/api/productAdd",
                data:data,
                headers : {'Content-Type' : 'application/json'},
            };
            $http(request).then(function successCallback(response) {
                
                console.log(response.data.result.info);
                $location.path("/productList");
                $scope.SSuccess=response.data.result.info;
            }, function errorCallback(response) {
                $scope.SError=response.data.error;
                if(response.status == 404){
                    $scope.CPError = response.statusText;
                }
            });
        };

     

        
});