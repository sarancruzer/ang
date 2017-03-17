
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
            }, function errorCallback(response) {
                $scope.CPError=response.data.error;
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
               // console.log(response);
              //  console.log($scope.suppliers);
                
            }, function errorCallback(response) {
                $scope.CPError=response.data.error;
                if(response.status == 404){
                    $scope.CPError = response.statusText;
                }
            });
        };

        $scope.getAllSuppliers();

        $scope.getAllProducts();

        $scope.inward = [];
        $scope.getProductByChange = function(productId,index){
            var request = {
                method:"POST",
                url:"/api/getProductCost",
                data:{productId:productId},
                headers : {'Content-Type' : 'application/json'},
            };
            $http(request).then(function successCallback(response) {
               // console.log(response);
                //console.log($scope.inward[index].unit_cost);

                $scope.inward[index].unit_cost = response.data.result;
            }, function errorCallback(response) {
                $scope.CPError=response.data.error;
                if(response.status == 404){
                    $scope.CPError = response.statusText;
                }
            });
     
        }

        var grand_total=0;
        
        $scope.grand_total = 0;
        $scope.calcTotalCost = function(index){
            $scope.inward[index].total_cost = $scope.inward[index].unit_cost * $scope.inward[index].quantity;
             angular.forEach($scope.inward, function(value, key){
                  grand_total=grand_total+value.total_cost;
                    
            });

             console.log(grand_total);

            $scope.grand_total=grand_total;
        }

        $scope.productinwardAddFunc = function(form){
            var data = {
                "productInward":$scope.productInward,
                "inward":$scope.inward,
                "grandTotal":$scope.grand_total
            }

            console.log(data);
            var request = {
                method:"POST",
                url:"/api/productinwardAdd",
                data:data,
                headers : {'Content-Type' : 'application/json'},
            };
            $http(request).then(function successCallback(response) {
                
                console.log(response.data.result.info);
               // $location.path("/productList");
                $scope.SSuccess=response.data.result.info;
            }, function errorCallback(response) {
                $scope.SError=response.data.error;
                if(response.status == 404){
                    $scope.CPError = response.statusText;
                }
            });
        };

        $scope.productinwards = [{},{},{}];
    
        $scope.addNew = function(personalDetail){
            $scope.productinwards.push({});
        };

        $scope.remove = function(index){
            $scope.productinwards.splice(index, 1);
        }

       
});


app.directive('chosen', function($timeout) {

  var linker = function(scope, element, attr) {

    scope.$watch('products', function() {
      $timeout(function() {
        element.trigger('chosen:updated');
      }, 0, false);
    }, true);

    $timeout(function() {
      element.chosen();
    }, 0, false);
  };

  return {
    restrict: 'A',
    link: linker
  };
});
