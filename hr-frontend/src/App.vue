<template>
  <header v-if="hideDash">
    <div class="header-cont">
      <!-- Hamburger icon on the left -->
      <button
        class="hamburger"
        @click="toggleSidebar"
        v-show="isMobile"
        aria-label="Toggle sidebar"
      >
        <i class="bi bi-list"></i>
      </button>
      <h1 class="logo">ModernTech Solutions</h1>
      <!-- Logout button always visible -->
      <button class="butn logout-desktop" @click="showLogoutModal">Logout <i class="bi bi-arrow-bar-right"></i></button>
    </div>
  </header>
  <div id="app-layout">
    <!-- Sidebar: show on desktop or if toggled on mobile -->
    <navbar-comp
      :hide-dash="hideDash"
      v-if="!isMobile || sidebarOpen"
      class="sidebar"
      @click="toggleSidebar"
    >
      <template #after-nav>
        <button class="butn logout-mobile" @click="showLogoutModal">Logout <i class="bi bi-arrow-bar-right"></i></button>
      </template>
    </navbar-comp>
    <main class="main-content">
      <!-- Bootstrap Modal -->
      <div class="modal fade" ref="logoutModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Confirm Logout</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to logout?</p>
            </div>
            <div class="modal-footer">
              <button class="btn btn-danger" @click="logOut">Yes</button>
              <button class="btn btn-secondary" data-bs-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>
      <router-view/>
    </main>
  </div>
  <footer-comp/>
</template>

<script>
import FooterComp from './components/FooterComp.vue';
import NavbarComp from './components/NavbarComp.vue';
import * as bootstrap from 'bootstrap';

export default {
  components: { NavbarComp, FooterComp },
  data() {
    return {
      sidebarOpen: false,
      isMobile: false,
      isAdmin:true
    }
  },
  computed: {
    hideDash() {
      return this.$route.path !== '/';
    }
  },
  mounted() {
    this.checkMobile();
    window.addEventListener('resize', this.checkMobile);
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.checkMobile);
  },
  methods: {
    showLogoutModal() {
      const modal = new bootstrap.Modal(this.$refs.logoutModal);
      modal.show();
    },
    logOut() {
      this.$router.push('/');
      const modal = bootstrap.Modal.getInstance(this.$refs.logoutModal);
      modal.hide();
    },
    toggleSidebar() {
      this.sidebarOpen = !this.sidebarOpen;
    },
    checkMobile() {
      this.isMobile = window.innerWidth < 753;
      if (!this.isMobile) this.sidebarOpen = false;
    }
  }
}
</script>

<style>
* {
  box-sizing: border-box;
}
header {
  display: flex;
  align-items: center;
  height: 80px;
  background-color: #af2727;
  box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.4);
  width: 100vw;
  min-width: 100vw;
  left: 0;
  top: 0;
  position: fixed;
  z-index: 1002;
  overflow-x: hidden;
  right: 0;
}

#app-layout {
  display: flex;
  min-height: 100vh;
  padding-top: 80px;
}

.header-cont {
  width: 100%;
  display: flex;
  justify-content: flex-start;
  align-items: center;
  padding: 0 20px;
}

.hamburger {
  background: none;
  border: none;
  color: white;
  font-size: 2rem;
  display: none;
  cursor: pointer;
  margin-right: 18px;
}

.logo {
  color: white;
  margin-right: auto;
}

.butn {
  background-color: #36424e;
  color: white;
  padding: 8px;
  border: none;
  border-radius: 6px;
  margin-left: auto;
}

.sidebar {
  width: 220px;
  background: #2c3e50;
  color: #fff;
  padding: 30px 0;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.sidebar nav {
  display: flex;
  flex-direction: column;
  width: 100%;
}

.sidebar a {
  color: #fff;
  text-decoration: none;
  padding: 15px 30px;
  font-weight: bold;
  transition: background 0.2s;
  margin: 5px 5px;
  border-radius: 10px;
}

.sidebar a.router-link-exact-active {
  background: #af2727;
  color: #fff;
  border-radius: 10px;
  margin: 5px 5px;
}

.sidebar a:hover {
  background: #ae4444;
  border-radius: 10px;
  margin: 5px 5px;
  transition: transform 0.2ms ease-in-out;
}

i {
  margin-right: 10px;
}

h1 {
  font-weight: 700;
}

.main-content {
  flex: 1;
  padding: 10px 40px;
  background: #f7f7f7;
}

/* Base styles (desktop first) */
.main-page {
  display: flex;
  flex-direction: column;
  margin: 10px;
  background: #f9f9f9;
  padding: 32px;
  border-radius: 10px;
  box-shadow: 0 2px 8px #0001;
  width: 100%;
}

  .butn.logout-mobile{
    display: none;
  }

  .page-wrapper {
    padding: 20px;
  }

  .count-up {
    transition: all 0.3s ease-out;
    display: inline-block;
    min-width: 1em;
    text-align: center;
  }

/* 1200px and below */
@media (max-width: 1200px) {
  header {
    width: 100vw;
  }


}

/* 900px and below (tablet) */
@media (max-width: 900px) {
  .main-page {
    padding: 18px;
    max-width: 100%;
  }
  .search-input {
    width: 60%;
  }
}

/* 768px and below (small tablet) */
@media (max-width: 768px) {
  header {
    height: 60px;
    width: 100vw;
  }
  #app-layout {
    padding-top: 60px;
  }
  footer {
    padding: 12px 10px;
    font-size: 0.9rem;
  }
}

/* 600px and below (mobile) */
@media (max-width: 600px) {
  .main-page {
    padding: 8px 2px;
    margin: 0;
    border-radius: 0;
    box-shadow: none;
  }
  .search-input {
    width: 100%;
    min-width: 200px;
  }
  .butn.logout-desktop {
    display: none;
  }
  .butn.logout-mobile {
    display: block;
    width: 90%;
    margin: 20px auto 0 auto;
    background-color: #af2727;
  }
}

/* 480px and below (small mobile) */
@media (max-width: 480px) {
  footer {
    padding: 8px 4px;
    font-size: 0.8rem;
  }
}

/* Hamburger icon and sidebar for mobile */
@media (max-width: 752px) {
  .hamburger {
    display: block;
  }
  .sidebar {
    position: fixed;
    left: 0;
    top: 60px;
    height: calc(100% - 60px);
    z-index: 1001;
    background: #2c3e50;
    width: 220px;
    transition: transform 0.3s;
  }
}
</style>