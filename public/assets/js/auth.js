/**
 * auth.js (versi web/session)
 * Mengatur login, register, logout via session Laravel dengan AJAX.
 */

const Auth = {
  tokenKey: 'token',
  userKey: 'user',
  logoutBound: false,

  init() {
    this.checkSession();
    this.renderUserUI();
    this.handleAuthForms();
    this.handleGoogleCallback();

    if (!this.logoutBound) {
      $(document).on('click', '#logout-btn', (e) => {
        e.preventDefault();
        this.logout();
      });

      $(document).on('click', '#open-auth-modal', (e) => {
        e.preventDefault();
        const modal = new bootstrap.Modal(document.getElementById('authModal'));
        modal.show();
      });

      this.logoutBound = true;
    }
  },

  /** 🔹 Render tampilan user di navbar */
  renderUserUI() {
    const token = this.getToken();
    const user = this.getUser();

    if (token && user) {
      $('#user-name').html(`<i class="fa-regular fa-circle-user"></i><span style="margin-right: 10px"></span> ${user.name}`);
      $('.auth-in-session').removeClass('d-none');
      $('.auth-out-session').addClass('d-none');
      $('#user-dropdown').attr('style', 'margin-left: -30px');
    } else {
      $('#user-name').html(`<i class="fa-regular fa-circle-user"></i></span>`);
      $('#user-dropdown').attr('style', 'margin-left: -55px');
      $('.auth-out-session').removeClass('d-none');
      $('.auth-in-session').addClass('d-none');
    }
  },

  /** 🔹 Tangani form login, register, dan Google */
  handleAuthForms() {
    // LOGIN
    $(document).off('submit', '#login-form').on('submit', '#login-form', (e) => {
      e.preventDefault();
      const email = $('#email').val();
      const password = $('#password').val();
      const _token = $('meta[name="csrf-token"]').attr('content');

      $.ajax({
        type: 'POST',
        url: '/auth/login',
        data: { email, password, _token },
        beforeSend: () => {
          // setting a timeout
          $('#login-btn').attr('disabled', '');
          $('#login-btn').html('<i class="fa-solid fa-spinner"></i>');
        },
        complete:  () => { 
          $('#login-btn').removeAttr('disabled', '');
          $('#login-btn').html('Masuk');
        },
        success: (res) => {
          // simpan token & user dulu baru render
          this.setToken(res.token);
          this.setUser(res.user);
          this.renderUserUI();

          window.dispatchEvent(new Event('auth:login'));
          sweetAlertNorm('Masuk', `Selamat datang, ${res.user.name}!`, 'success');
          bootstrap.Modal.getInstance(document.getElementById('authModal')).hide();
        },
        error: (xhr) => {
          console.log(xhr);
          const msg =
            xhr.responseJSON?.message ||
            xhr.responseJSON?.name?.[0] ||
            xhr.responseJSON?.password?.[0] ||
            'Login gagal.';
          sweetAlertNorm('Masuk', msg, 'warning');
        },
      });
    });

    // REGISTER
    $(document).off('submit', '#register-form').on('submit', '#register-form', (e) => {
      e.preventDefault();
      const name = $('#reg-name').val();
      const email = $('#reg-email').val();
      const password = $('#reg-password').val();
      const _token = $('meta[name="csrf-token"]').attr('content');

      $.ajax({
        type: 'POST',
        url: '/auth/register',
        data: { name, email, password, _token },
        beforeSend: () => {
          // setting a timeout
          $('#register-btn').attr('disabled', '');
          $('#register-btn').html('<i class="fa-solid fa-spinner"></i>');
        },
        complete:  () => { 
          $('#register-btn').removeAttr('disabled', '');
          $('#register-btn').html('Daftar');
        },
        success: (res) => {
          this.setToken(res.token);
          this.setUser(res.user);
          this.renderUserUI();

          sweetAlertNorm('Daftar', `Akun ${res.user.name} berhasil dibuat!`, 'success');
          bootstrap.Modal.getInstance(document.getElementById('authModal')).hide();
          window.dispatchEvent(new Event('auth:login'));
        },
        error: (xhr) => {
          console.log(xhr);
          const msg =
            xhr.responseJSON?.message ||
            xhr.responseJSON?.name?.[0] ||
            xhr.responseJSON?.email?.[0] ||
            xhr.responseJSON?.password?.[0] || 
            'Registrasi gagal.';
          sweetAlertNorm('Daftar', msg, 'error');
        },
      });
    });

    // LOGIN VIA GOOGLE
    $(document)
      .off('click', '#google-login-btn')
      .on('click', '#google-login-btn', (e) => {
        e.preventDefault();
        const currentUrl = window.location.href;
        const redirectAfter = encodeURIComponent(currentUrl);
        window.location.href = `/auth/google?redirect_after=${redirectAfter}`;
      });
  },

  /** 🔹 Helper LocalStorage */
  setToken(token) {
    localStorage.setItem(this.tokenKey, token);
  },
  getToken() {
    return localStorage.getItem(this.tokenKey);
  },
  setUser(user) {
    localStorage.setItem(this.userKey, JSON.stringify(user));
  },
  getUser() {
    const data = localStorage.getItem(this.userKey);
    return data ? JSON.parse(data) : null;
  },
  clear() {
    localStorage.removeItem(this.tokenKey);
    localStorage.removeItem(this.userKey);
  },

  handleGoogleCallback() {
    const params = new URLSearchParams(window.location.search);
    const googleToken = params.get('google_token');
    const userData = params.get('user');

    if (googleToken) {
      try {
        this.setToken(googleToken);
        if (userData) {
          const parsedUser = JSON.parse(decodeURIComponent(userData));
          this.setUser(parsedUser);
        }
        window.history.replaceState({}, document.title, window.location.pathname);
        this.renderUserUI();
      } catch (err) {
        console.error('Gagal parsing data Google:', err);
      }
    }
  },

  /** 🔹 Logout */
  logout() {
    $.ajax({
      url: '/auth/logout',
      method: 'POST',
      data: { _token: $('meta[name="csrf-token"]').attr('content') },
      success: () => {
        this.clear();
        this.renderUserUI();
        window.dispatchEvent(new Event('auth:logout'));
        protectUrlRequiringLogin();
        sweetAlertNorm('Keluar', 'Anda telah keluar!', 'info');
      },
      error: () => {
        sweetAlertNorm('Logout', 'Gagal keluar dari akun.', 'error');
      },
    });
  },

  isLoggedIn() {
    return !!this.getToken();
  },

  /** 🔹 Cek session aktif di server */
  checkSession() {
    $.ajax({
      url: '/auth/me',
      method: 'GET',
      success: (res) => {
        if (res?.user) {
          this.setUser(res.user);
          if (res.token) this.setToken(res.token);
        } else {
          this.clear();
        }
        this.renderUserUI();
      },
      error: () => {
        this.clear();
        this.renderUserUI();
      },
    });
  },
};

/** 🔹 Toggle form login <-> register */
function formAuthBtnRegLog() {
  $('#show-register').click(function (e) {
    e.preventDefault();
    $('#show-register').addClass('show');
    $('#show-login').removeClass('show');
    $('#login-form').hide();
    $('#register-form').fadeIn();
    $('#form-title').text('Buat Akun Baru');
  });

  $('#show-login').click(function (e) {
    e.preventDefault();
    $('#show-login').addClass('show');
    $('#show-register').removeClass('show');
    $('#register-form').hide();
    $('#login-form').fadeIn();
    $('#form-title').text('Masuk ke Akun Anda');
  });
}

function protectButtonRequiringLogin() {
  $(document).on('click', '.need-login', function (e) {
    if (!Auth.isLoggedIn()) {
      e.preventDefault();
      const modal = new bootstrap.Modal(document.getElementById('authModal'));
      modal.show();
    }
  });
}

function protectUrlRequiringLogin() {
  document.addEventListener('DOMContentLoaded', () => {
    if (!Auth.isLoggedIn()) {
        sweetAlertNorm('Akun', 'Silakan login terlebih dahulu untuk menonton.', 'warning');
        window.location.href = '/';
        return;
    }

    window.addEventListener('auth:logout', () => {
        // alert('Sesi Anda telah berakhir. Anda akan diarahkan ke beranda.');
        sweetAlertNorm('Akun', 'Sesi Anda telah berakhir. Anda akan diarahkan ke beranda.', 'warning');
        window.location.href = `/`;
    });
    // 🔹 Pantau jika user logout dari halaman lain
  });
}

/** 🔹 Jalankan otomatis */
$(document).ready(() => {
  Auth.init();
  formAuthBtnRegLog();
  protectButtonRequiringLogin();
});
