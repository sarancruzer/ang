
app.controller("productEditController",function ($scope, $auth, $state, $http, $rootScope,$location,$stateParams){
        
        $scope.init = function(){

            var data = $scope.supplier;
            var id =$stateParams.id;

            var request = {
                method:"POST",
                url:"/api/getProductById/"+id,
                data:{info:data},
                headers : {'Content-Type' : 'application/json'},
            };
            $http(request).then(function successCallback(response) {
                
                $scope.supplier = response.data.result.info[0];    
                console.log(response.data.result.info);
                $scope.SSuccess=response.data.result.info;
            }, function errorCallback(response) {
                $scope.SError=response.data.error;
                if(response.status == 404){
                    $scope.CPError = response.statusText;
                }
            });
        };

        $scope.init();


        $scope.productUpdate = function(form){
            var data = $scope.supplier;
            console.log(data);
            var request = {
                method:"POST",
                url:"/api/productUpdate",
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