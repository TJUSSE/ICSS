var ICSS = {
  Util: {
    showLoginSSO: function () {
      $('.role-login').addClass('show');
      $('.dialog-mask').addClass('show');
      $('.dialog-login-sso').addClass('show');
    },

    showLoginNative: function () {
      $('.role-login').addClass('show');
      $('.dialog-mask').addClass('show');
      $('.dialog-login-native').addClass('show');
    },

    hideLogin: function () {
      $('.role-login').removeClass('show');
      $('.dialog-mask').removeClass('show');
      $('.dialog-login-sso').removeClass('show');
      $('.dialog-login-native').removeClass('show');
    }
  }
}

$(document).on('click', '.role-login-button', ICSS.Util.showLoginSSO);