@extends('basic')

@section('JSscript')
if(!localStorage.getItem("userToken")){location.replace("/login");}
@endsection

@section('CSSscript')
#weHuntController{
	background: rgb(16, 108, 200);
	width: calc(100vw - 40px);
    height: calc(100vh - 40px);
	padding:20px;
}
h3{color:white;}
.navButton{min-width: 40px;}
@endsection
@section('bodyContent')
<md-content id="weHuntController" ng-controller="weHuntCtrl">
<h3>BREWERIES LIST</h3>
 <div style="height:50%;overflow:auto;background:white;"><md-list>
  <md-list-item ng-repeat="item in list" ng-click="void()">
    <p> @{{ item.name }} </p>
  </md-list-item>
  </md-list>
    </div>
	<md-button ng-disabled="exists(curPage-1)" ng-click="toPage(curPage-1)" class="md-raised">BACK</md-button>
	<md-button ng-if="curPage>2" class="md-raised navButton" ng-click="toPage(curPage-2)">@{{curPage-2}}</md-button>
	<md-button ng-if="curPage>1" class="md-raised navButton" ng-click="toPage(curPage-1)">@{{curPage-1}}</md-button>
	<md-button class="md-raised md-primary navButton">@{{curPage}}</md-button>
	<md-button ng-if="curPage<totalPage" class="md-raised navButton" ng-click="toPage(curPage+1)">@{{curPage+1}}</md-button>
	<md-button ng-if="curPage<totalPage+1" class="md-raised navButton" ng-click="toPage(curPage+2)">@{{curPage+2}}</md-button>
	<md-button ng-if="curPage<totalPage+2 && curPage<3" class="md-raised navButton" ng-click="toPage(curPage+3)">@{{curPage+3}}</md-button>
	<md-button ng-if="curPage<totalPage+3 && curPage<2" class="md-raised navButton" ng-click="toPage(curPage+4)">@{{curPage+4}}</md-button>
	<md-button ng-if="curPage<totalPage"  ng-click="toPage(curPage+1)" class="md-raised">NEXT</md-button>
</md-content>
@endsection

@section('ANGULARJS')
angular.module('weHunt', ['ngMaterial', 'ngMessages']).config(function($mdThemingProvider) {
  $mdThemingProvider.theme('default')
    .primaryPalette('blue', {
      'default': '700', // by default use shade 400 from the pink palette for primary intentions
      'hue-1': '100', // use shade 100 for the <code>md-hue-1</code> class
      'hue-2': '600', // use shade 600 for the <code>md-hue-2</code> class
      'hue-3': 'A100' // use shade A100 for the <code>md-hue-3</code> class
    })
    .accentPalette('orange');
	$mdThemingProvider.theme('blue').backgroundPalette('blue').dark();
}).controller('weHuntCtrl', function($scope, $http, $mdDialog,$mdSidenav) {
	$scope.showAlert = function (title,msg,ev) {
	$mdDialog.show(
	  $mdDialog.alert()
		.parent(angular.element(document.body))
		.clickOutsideToClose(true)
		.title(title)
		.textContent(msg)
		.ariaLabel(title)
		.ok('OK')
		.targetEvent(ev)
		.multiple(true)
		);
	};
	$scope.exists = function (page){
		if(page>0 && page<=$scope.totalPage){return false}else{return true;}
	}
	$scope.void = function () {
	};
	$scope.initList = function () {
		$scope.totalPage=Math.ceil($scope.total / $scope.itemsPerPage);
		$scope.loadContent();
	};
	$scope.toPage = function (page){
		$scope.curPage=page;
		$scope.loadContent();
	}
	$scope.loadContent = function () {
		$http({
			method: 'GET',
			url: 'api/breweries?per_page='+$scope.itemsPerPage+'&page='+$scope.curPage,
			headers: {'authorization': "Bearer "+localStorage.getItem("userToken")}
		}).then(function(result) {
			json = result.data;
			console.log(json)			
			if(typeof json === 'object'){
				$scope.list=json;
			}else{
				$scope.showAlert("Meta2","Si è verificato un errore imprevisto. Riprova più tardi.");
			}
		}, function(error) {
			//console.log(error);
			if(error.status==401){
				$scope.showAlert("Meta","Accesso negato");
				localStorage.removeItem("userToken");
				location.replace("/login");
			}
			if(error.status==403){
				$scope.showAlert("Meta","Accesso negato");
				localStorage.removeItem("userToken");
				location.replace("/login");
			}
		});
		
	};
	$scope.total=0;
	$scope.curPage = 1,
	$scope.totalPage = 0,
	$scope.itemsPerPage = 15,
	$scope.maxSize = 5;
	$scope.list=[];
	if(!localStorage.getItem("totalBreweries")){
		$http({
			method: 'GET',
			data: {},
			url: 'api/breweries/meta',
			headers: {'authorization': "Bearer "+localStorage.getItem("userToken")}
		}).then(function(result) {
			json = result.data;
			//console.log(json.status)			
			if(typeof json === 'object'){
				localStorage.setItem("totalBreweries", json.total);
				$scope.total=json.total;
				$scope.initList();
			}else{
				$scope.showAlert("Meta","Si è verificato un errore imprevisto. Riprova più tardi.");
			}
		}, function(error) {
			//console.log(error);
			if(error.status==401){
				$scope.showAlert("Meta","Accesso negato");
				localStorage.removeItem("userToken");
				location.replace("/login");
			}
			if(error.status==403){
				$scope.showAlert("Meta","Accesso negato");
				localStorage.removeItem("userToken");
				location.replace("/login");
			}
		});
	}else{
		$scope.total=localStorage.getItem("totalBreweries");
		$scope.initList();
	}


});
@endsection

@section('JSready')

@endsection