
app.controller("productinwardEditController",function ($scope, $auth, $state, $http, $rootScope,$location,$stateParams){
        
        $scope.init = function(){

            var data = $scope.product;
            var id =$stateParams.id;

            var request = {
                method:"POST",
                url:"/api/getProductinwardById/"+id,
                data:{info:data},
                headers : {'Content-Type' : 'application/json'},
            };
            $http(request).then(function successCallback(response) {
                
                $scope.product = response.data.result.info;    
                console.log(response.data.result.info);
                $scope.SSuccess=response.data.result.info;
            }, function errorCallback(response) {
                $scope.SError=response.data.error;
                if(response.status == 404){
                    $scope.CPError = response.statusText;
                }
            });
        };





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
                $scope.init();


        $scope.productinwardUpdate = function(form){
            $scope.product.id =$stateParams.id;
            var data = $scope.product;
            
            console.log(data);
            var request = {
                method:"POST",
                url:"/api/productinwardUpdate",
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