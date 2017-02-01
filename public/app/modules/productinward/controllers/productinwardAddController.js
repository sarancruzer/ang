
app.controller("productinwardAddController",function ($scope, $auth, $state, $http, $rootScope,$location){
        

         $scope.getAllProducts= function(){
            var request = {
                method:"POST",
                url:"/api/getAllProducts",
                data:{},
                headers : {'Content-Type' : 'application/json'},
            };
            $http(request).then(function successCallback(response) {
                $scope.products = response.data.result;
                console.log(response);
                console.log($scope.suppliers);
                
            }, function errorCallback(response) {
                $scope.CPError=response.data.error;
                if(response.status == 404){
                    $scope.CPError = response.statusText;
                }
            });
        };

        $scope.getAllProducts();

        $scope.getProductData = function(){
            console.log($scope.productinward.product_id);
            
        }

        $scope.productinwardAddFunc = function(form){
            var data = $scope.product;
            console.log(data);
            var request = {
                method:"POST",
                url:"/api/productinwardAdd",
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