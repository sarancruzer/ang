
app.controller("productinwardShowController",function ($scope, $auth, $state, $http, $rootScope){
       
         $scope.showProductInwardDetails= function(productInwardId){
            
            var request = {
                method:"POST",
                url:"/api/getProductinwardDetailById",
                data:{"productInwardId":productInwardId},
                headers : {'Content-Type' : 'application/json'},
            };
            $http(request).then(function successCallback(response) {
                $scope.productInwardDetails = response.data.result.info;
                

            }, function errorCallback(response) {
                $scope.CPError=response.data.error;
                if(response.status == 404){
                    $scope.CPError = response.statusText;
                }
            });
        };


        $scope.showProductInwardDetails($state.params.id);

        
});