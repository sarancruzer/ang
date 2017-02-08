
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

        $scope.getAllProducts();

        $scope.getProductByChange = function(){
            console.log($scope.productinward.product);

            var request = {
                method:"POST",
                url:"/api/getProductCost",
                data:{productId:$scope.productinward.product_id},
                headers : {'Content-Type' : 'application/json'},
            };
            $http(request).then(function successCallback(response) {
                $scope.productinward.unit_cost = response.data.result;
            }, function errorCallback(response) {
                $scope.CPError=response.data.error;
                if(response.status == 404){
                    $scope.CPError = response.statusText;
                }
            });
     
        }

        $scope.calcTotalCost = function(){

            $scope.productinward.total_cost = $scope.productinward.unit_cost * $scope.productinward.quantity;

        }

        $scope.productinwardAddFunc = function(form){
            var data = $scope.productinward;
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
