	var selIds = [];
// $(function() {
	var app = angular.module('kunsthalle', ['ui.multiselect']);
	/*, function($interpolateProvider) {
		$interpolateProvider.startSymbol('<%');
	    $interpolateProvider.endSymbol('%>');	
	});
	/**/
	app.controller('MainCtrl', function($scope, $http) {
	    $scope.name = 'World';
	    $scope.selIds = [];
	    $scope.cars = [{id:1, name: 'Audi'}, {id:2, name: 'BMW'}, {id:1, name: 'Honda'}];
	    $scope.selectedCar = [];

	    $scope.exbs = [{id:1, title: 'Exb - 1'}, {id:2, title: 'Exb - 2'}, {id:1, title: 'Exb - 3'}];
	    $scope.selectedExb = [];

	    $scope.fruits = [{id: 1, name: 'Apple'}, {id: 2, name: 'Orange'},{id: 3, name: 'Banana'}];
	    $scope.selectedFruit = null;

        $scope.getExbs = function(id) {
        	console.log("getExbs called...");
          /*$http({
                method : 'GET',
                url: '/content/exb-list', //id/' + id,
                data: JSON.stringify({ 'eid' : id }),
                headers: {'Content-Type':'application/x-www-form-urlencoded'},
                notifySuccess: true,
                notifyFailure: true,
             }). /**/
		  	$http.get('/content/exb-list', { params: { id: id  }, headers: 'Content-Type: application/json' }).
              success(function(data, status) { //, headers, config) {
                console.log('Success.. '+ data);
                var s = '';
                exbs = document.getElementById('exhibitions');//$('#exhibitions');

                //alert(exbs.attr('selectedIndex'));// alert(exbs[exbs.selectedIndex].value);//options.length);

                /**/
                for(var k in data) {
                	
	                for(var i in exbs.options) {
	                	if(exbs.options[i].value == data[k]) {
	                		s += k + ' : ' + data[k] + "\n";
			                $scope.selIds[$scope.selIds.length] = data[k];
			                exbs.options[i].selected = true;
	                	}
	                }
                } /**/
                console.log('selIds: ' + $scope.selIds);
                console.log('Data: ' + s);
                return 'OK'// $scope.selIds; //'Success';
            }).
            error(function(data, status) { //, headers, config) {
                console.log('failed..'+ data);

                return 'failure';
            });
      	};

      	// vals = $scope.$apply($scope.getExbs(2));
      	// console.log("vals: " + vals);

	});
// });

$(function() {
	selIds = [];
	var scope = angular.element($('#exhibitions')).scope();
	scope.$apply(function() {
//		scope.getExbs(2);
	});
});
