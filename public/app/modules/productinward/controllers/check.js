
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
                data:{productId:$scope.productinward.product},
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



         $scope.personalDetails = [
        {
            'fname':'Muhammed',
            'lname':'Shanid',
            'email':'shanid@shanid.com'
        },
        {
            'fname':'John',
            'lname':'Abraham',
            'email':'john@john.com'
        },
        {
            'fname':'Roy',
            'lname':'Mathew',
            'email':'roy@roy.com'
        }];

        $scope.addNew = function(personalDetail){
            $scope.personalDetails.push({ 
                'fname': "", 
                'lname': "",
                'email': "",
            });
        };

         $scope.remove = function(){
            var newDataList=[];
            $scope.selectedAll = false;
            angular.forEach($scope.personalDetails, function(selected){
                if(!selected.selected){
                    newDataList.push(selected);
                }
            }); 
            $scope.personalDetails = newDataList;
        };


         $scope.checkAll = function () {
        if (!$scope.selectedAll) {
            $scope.selectedAll = true;
        } else {
            $scope.selectedAll = false;
        }
        angular.forEach($scope.personalDetails, function(personalDetail) {
            personalDetail.selected = $scope.selectedAll;
        });
    }; 

    $scope.personalDetail = [];
    $scope.check = function(index){
            console.log(index);
        $scope.personalDetail[index].lname = " name v"; 

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
