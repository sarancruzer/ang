app.controller('logoutController',function ($scope, $auth, $state, $http, $rootScope) {
		if (!$auth.isAuthenticated()) { return; }
    		$auth.logout()
			$rootScope.authenticated = false;
			$rootScope.currentUser = null;
			$auth.logout();
			
			localStorage.removeItem('usename');
			localStorage.removeItem('userId');
			localStorage.removeItem('userType');
			localStorage.removeItem('avatar');

			$state.go('auth');
});