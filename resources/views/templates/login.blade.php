<md-dialog aria-label="LOGIN">
  <form name="loginForm" ng-cloak>
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>AUTENTICAZIONE</h2>
      </div>
    </md-toolbar>

    <md-dialog-content>
	<div class="md-dialog-content">
      <md-input-container class="md-block">
        <label>Username</label>
        <input required type="text" name="clientEmail" id="clientEmail" ng-model="user.email" />
          <div ng-messages="loginForm.clientEmail.$error">
            <div ng-message="required">Campo obbligatorio.</div>
          </div>
      </md-input-container>
        <md-input-container class="md-block">
          <label>Password</label>
          <input required name="clientPsw" id="clientPsw" ng-model="user.password" type="password" />
          <div ng-messages="loginForm.clientPsw.$error">
            <div ng-message="required">Campo obbligatorio.</div>
          </div>
        </md-input-container>
	</div>
    </md-dialog-content>

    <md-dialog-actions layout="row">
      <md-button id="loginBtn" class="md-raised md-primary" ng-click="login()" ng-disabled="loginForm.$invalid">
        ACCEDI
      </md-button>
    </md-dialog-actions>
  </form>
</md-dialog>