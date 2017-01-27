
app.controller("addSupplierController",function ($scope, $auth, $state, $http, $rootScope,$location){
        
        $scope.addSupplierFunc = function(form){

            var data = $scope.supplier;

            console.log(data);

            var request = {
                method:"POST",
                url:"/api/addSupplier",
                data:data,
                headers : {'Content-Type' : 'application/json'},
            };
            $http(request).then(function successCallback(response) {
                
                console.log(response.data.result.info);
                $location.path("/supplierList");
                $scope.SSuccess=response.data.result.info;
            }, function errorCallback(response) {
                $scope.SError=response.data.error;
                if(response.status == 404){
                    $scope.CPError = response.statusText;
                }
            });
        };

      

        
});