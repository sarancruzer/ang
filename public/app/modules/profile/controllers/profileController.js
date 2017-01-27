app.controller("profileController",function ($scope, $auth, $state, $http, $rootScope){
		
		$scope.init = function(){
			var request = {
				method:"POST",
				url:"/api/profile",
				data:{},
				headers : {'Content-Type' : 'application/json'},
			};
			$http(request).then(function successCallback(response) {
				$scope.details = response.data.result.info[0];
			}, function errorCallback(response) {
				$scope.CPError=response.data.error;
			    if(response.status == 404){
			    	$scope.CPError = response.statusText;
			    }
			});
		};

		$scope.init();
});