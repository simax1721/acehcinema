/**
 * auth-admin.js
 * Versi web/session — untuk login admin via AJAX (Laravel session)
 */

const AdminAuth = {
  tokenKey: 'admin_token',
  userKey: 'admin_user',
  logoutBound: false,

  init() {
    // this.checkSession();
    this.renderAdminUI();
    this.handleLoginForm();

    if (!this.logoutBound) {
      $(document).on('click', '#admin-logout-btn', (e) => {
        e.preventDefault();
        this.logout();
      });
      this.logoutBound = true;
    }
  },

  /** 🔹 Render tampilan admin di navbar/dashboard */
  renderAdminUI() {
    const token = this.getToken();
    const admin = this.getAdmin();

    if (token && admin) {
      $('#admin-name').html(`${admin.name}`);
      $('#admin-name-first').attr('data-initial', `${admin.name[0]}`);
    } else {
      // $('#admin-name').html(`<i class="fa-solid fa-user-shield"></i>`);
      // $('.admin-out-session').removeClass('d-none');
      // $('.admin-in-session').addClass('d-none');
    }
  },

  /** 🔹 Handle form login admin */
  handleLoginForm() {
    $(document).on('submit', '#admin-loginForm', (e) => {
        e.preventDefault();
        const email = $('#email').val();
        const password = $('#password').val();
        const _token = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
          type: 'POST',
          url: '/admin/auth/login',
          data: { email, password, _token },
          beforeSend: () => {
            $('#admin-login-btn')
              .attr('disabled', '')
              .html('<i class="fa-solid fa-spinner fa-spin"></i>');
          },
          complete: () => {
            $('#admin-login-btn')
              .removeAttr('disabled')
              .html('LOGIN');
          },
          success: (res) => {
            this.setToken(res.token || 'session');
            this.setAdmin(res.admin);

            window.dispatchEvent(new Event('admin:login'));
            sweetAlertNorm('Masuk', `Selamat datang, ${res.admin.name}!`, 'success');
            setTimeout(() => (window.location.href = '/admin/dashboard'), 1000);
          },
          error: (xhr) => {
            console.log(xhr);
            const msg =
              xhr.responseJSON?.message ||
              xhr.responseJSON?.name?.[0] ||
              xhr.responseJSON?.password?.[0] ||
              'Login gagal.';
            toastr.warning(msg);
          },
        });
      });
  },

  /** 🔹 Helper LocalStorage */
  setToken(token) {
    localStorage.setItem(this.tokenKey, token);
  },
  getToken() {
    return localStorage.getItem(this.tokenKey);
  },
  setAdmin(admin) {
    localStorage.setItem(this.userKey, JSON.stringify(admin));
  },
  getAdmin() {
    const data = localStorage.getItem(this.userKey);
    return data ? JSON.parse(data) : null;
  },
  clear() {
    localStorage.removeItem(this.tokenKey);
    localStorage.removeItem(this.userKey);
  },

  /** 🔹 Logout admin */
  logout() {
    $.ajax({
      url: '/admin/auth/logout',
      method: 'POST',
      data: { _token: $('meta[name="csrf-token"]').attr('content') },
      beforeSend: () => {
        $('#admin-logout-btn')
          .addclass('disabled')
          .html('<i class="fa-solid fa-spinner fa-spin"></i>');
      },
      complete: () => {
        $('#admin-logout-btn')
          .removeClass('disabled')
          .html('Logout');
      },
      success: () => {
        this.clear();
        window.dispatchEvent(new Event('admin:logout'));
        sweetAlertNorm('Logout', 'Anda telah keluar dari akun admin.', 'info');
        setTimeout(() => (window.location.href = '/admin/auth/login'), 1000);
      },
      error: (error) => {
        console.log(error);
        
        sweetAlertNorm('Logout', 'Gagal keluar dari akun.', 'error');
      },
    });
  },

  /** 🔹 Cek session aktif di server */
  checkSession() {
    $.ajax({
      url: '/admin/auth/me',
      method: 'GET',
      success: (res) => {
        if (res?.admin) {
          this.setAdmin(res.admin);
          if (res.token) this.setToken(res.token);
        } else {
          this.clear();
        }
        this.renderAdminUI();
      },
      error: () => {
        this.clear();
        this.renderAdminUI();
      },
    });
  },

  isLoggedIn() {
    return !!this.getToken();
  },
};

/** 🔹 Jalankan otomatis */
$(document).ready(() => {
  AdminAuth.init();
});

