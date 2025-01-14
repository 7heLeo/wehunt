@extends('basic')

@section('JSscript')
if(localStorage.getItem("userToken")){location.replace("/");}
@endsection

@section('CSSscript')
#weHuntController{
	background: rgb(16, 108, 200);
	width: 100%;
    height: 100%;
}
@endsection
@section('bodyContent')
<md-content id="weHuntController" ng-controller="weHuntCtrl">
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
	$scope.showLogin = function (ev) {
		$mdDialog.show({
		  controller: LoginDialogController,
		  targetEvent: ev,
		  templateUrl: 'templates/login',
		  // Appending dialog to document.body to cover sidenav in docs app
		  // Modal dialogs should fully cover application to prevent interaction outside of dialog
		  parent: angular.element(document.body),
		  clickOutsideToClose: false,
		  escapeToClose: false,
		  onComplete: afterShowLogin,
		  multiple: true
		}).then(function (answer) {
			if(answer=="showMain"){
				$scope.showMain();
			}
			if(answer.substr(0,6)=="login-"){
				dt=answer.substr(6).split("|");
				$scope.loggedin=true;
				$scope.user.id=dt[0];
				$scope.user.nickname=dt[1];
				$scope.showMain();
			}
		}, function () {
		  $scope.status = 'You cancelled the dialog.';
		});
		function afterShowLogin(scope, element, options) {
			$("#clientEmail").keydown(function(event) {
			  if (event.which == 13) {
				$( "#clientPsw" ).focus();
			  }  
			});
			$("#clientPsw").keydown(function(event) {
			  if (event.which == 13) {
				$( "#loginBtn" ).click();
			  }  
			});
		}
	};
	function LoginDialogController($scope, $mdDialog) {
		$scope.user={
			email:'',
			password:''
		}
		$scope.hide = function () {
			$mdDialog.hide();
		};
		$scope.cancel = function () {
			$mdDialog.cancel();
		};
		$scope.answer = function (answer) {
			$mdDialog.hide(answer);
		};
		$scope.login = function (answer) {
			$http({
				method: 'POST',
				data: $scope.user,
				url: 'api/user/login'
			}).then(function(result) {
				json = result.data;
				//console.log(json.status)			
				if(typeof json === 'object'){
					localStorage.setItem("userToken", json.token);
					location.replace('/');
				}else{
					$scope.showAlert("Login","Si è verificato un errore imprevisto. Riprova più tardi.");
				}
			}, function(error) {
				//console.log(error);
				if(error.status==401){
					$scope.showAlert("Login","Accesso negato");
				}
				if(error.status==403){
					$scope.showAlert("Login","Accesso negato");
				}
				if(error.status==422){
					$scope.showAlert("Login","Accesso negato");
				}
			});
		};
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
	}
	$scope.showLogin();
});
@endsection

@section('JSready')

@endsection