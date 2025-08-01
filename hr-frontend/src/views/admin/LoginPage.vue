<template>
  <div class="login-wrapper">
    <div class="roles">
      <button @click="$store.commit('adminRole')">Admin</button>
      <button @click="$store.commit('staffRole')">Staff</button>
    </div>
    <div class="login-box">
      <h2>{{$store.state.isAdmin? 'Welcome Admin' : 'Welcome Staff'}}</h2>
      <form @submit.prevent="$store.state.isAdmin? loginAdmin() : loginStaff()">
        <div class="form-group">
          <label for="username">Username</label>
          <input class="input" id="username" v-model="username" type="text" required />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input class="input" id="password" v-model="password" type="password" required />
        </div>
        <button class="submit" type="submit">Login</button>
      </form>
      <!-- <div class="forgot-password">
        <a href="#" @click.prevent="forgotPassword">Forgot password?</a>
      </div> -->
    </div>
  </div>
  <div v-if="showForgotModal" class="modal-overlay">
    <div class="modal-box">
      <h3>Reset Password</h3>
      <div class="form-group">
        <label for="empId">Employee ID</label>
        <input id="empId" v-model="selectedEmpId" class="input" type="text" placeholder="Enter your Employee ID" />
      </div>
      <div class="form-group">
        <label for="newPassword">New Password</label>
        <input class="input" id="newPassword" v-model="newPassword" type="password" required />
      </div>
      <div class="modal-actions">
        <button @click="submitForgotPassword" class="submit">Submit</button>
        <button @click="showForgotModal = false" class="cancel">Cancel</button>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: "Login",
  data() {
    return {
      username: "",
      password: "",
      showForgotModal: false,
      selectedEmpId: "",
      newPassword: "",
      error: ""
    };
  },
  methods: {
    loginAdmin() {
      if (this.username === "admin" && this.password === "1234") {
        this.error = "";
        this.$router.push("/admin/dashboard");
      } else {
        this.error = "Invalid admin username or password.";
      }
    },
    async loginStaff() {
      try {
        const response = await axios.post("http://localhost/hr-management-system/hr-backend/employeelogin.php", {
          username: this.username,
          password: this.password
        });

        if (response.data.success) {
          // Save employee data for later use
          this.$store.commit("setEmployee", response.data.employee);
          this.error = "";
          this.$router.push("/staff/mydashboard");
        } else {
          this.error = response.data.message || "Invalid login.";
        }
      } catch (err) {
        console.error("Login error:", err);
        this.error = "Server error or failed to connect.";
      }
    },
    forgotPassword() {
      this.showForgotModal = true;
      this.selectedEmpId = "";
      this.newPassword = "";
    },
    submitForgotPassword() {
      if (!this.selectedEmpId || !this.newPassword.trim()) {
        alert("Employee ID and new password are required.");
        return;
      }
      // Example: send password reset to backend (not yet implemented)
      this.showForgotModal = false;
      alert("Password reset request sent (functionality to be added).");
    }
  }
};
</script>
<style>
.footer-bar {
  position: fixed;
  left: 0;
  bottom: 0;
  width: 100vw;
  background: #111;
  color: #fff;
  text-align: center;
  padding: 5px 0;
  font-size: 1rem;
  letter-spacing: 1px;
  z-index: 100;
}
.login-wrapper {
  min-height: 100vh;
  width: 100vw;
  background-image: url('/src/views/pics/mts-logo.jpg');
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin: 0;
  padding: 0;
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1;
}
.login-box {
  position: relative;
  top: -100px;
  background: rgba(255, 255, 255, 0.2); /* Transparent white */
  backdrop-filter: blur(10px); /* Glass effect */
  padding: 40px;
  border-radius: 15px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
  width: 350px;
  color: #fff;
  /* Animation for login box appearance */
  animation: slide-appear 2s 0.2s ease forwards;
  opacity: 0;
}
.login-box h2 {
  text-align: center;
  margin-bottom: 20px;
}
.form-group {
  margin-bottom: 15px;
}
label {
  display: block;
  margin-bottom: 5px;
  color: #fff;
}
.input {
  width: 100%;
  padding: 8px;
  border: none;
  border-bottom: 1px solid #fff;
  outline: none;
  background: transparent;
  color:#fff;
}

.input:focus{
  background: transparent;
}

.input:-webkit-autofill,
.input:-webkit-autofill:hover,
.input:-webkit-autofill:focus {
  -webkit-box-shadow: 0 0 0 1000px transparent inset !important;
  box-shadow: 0 0 0 1000px transparent inset !important;
  -webkit-text-fill-color: #fff;
  transition: background-color 9999s ease-in-out 0s;
  background: rgba(0,0,0,0.2) !important;
}

.submit {
  width: 100%;
  padding: 10px;
  background-color: #ffffffaa;
  border: none;
  border-radius: 8px;
  color: #000;
  font-weight: bold;
  cursor: pointer;
}
.submit:hover {
  background-color: #ffffffcc;
}

.forgot-password {
  text-align: center;
  margin-top: 10px;
}
.forgot-password a {
  color: white;
  text-decoration: underline;
  font-size: 0.95rem;
  cursor: pointer;
}

.roles {
  display: flex;
  justify-content: center;
  gap: 1rem;
  margin-bottom: 20px;
}

.roles button {
  background: #af2727;
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 10px 28px;
  font-size: 1rem;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.2s, transform 0.2s;
  box-shadow: 0 2px 8px rgba(175, 39, 39, 0.15);
  opacity: 0;
  animation: appear 0.5s 1.3s ease forwards;
  transition: transform 0.2s, background 0.2s;
}

.roles button:hover,
.roles button:focus {
  transform: translateY(-1px) scale(1.02);
  box-shadow: 5px 2px 8px rgba(175, 39, 39, 0.45);
}


@keyframes appear {
  from {
    opacity: 0;
  }
  to {
    opacity: 1;
  }
}

.main-content {
  padding: 0;
}

/* Keyframes for login box animation */
@keyframes slide-appear {
  0% {
    opacity: 0.1;
  }
  100% {
    opacity: 1;
    transform: translateY(100px);
  }
  
}

.modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.5);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
}
.modal-box {
  background: #fff;
  color: #222;
  padding: 2rem;
  border-radius: 12px;
  min-width: 300px;
  box-shadow: 0 8px 32px rgba(0,0,0,0.2);
  display: flex;
  flex-direction: column;
  gap: 1rem;
}
.modal-box label {
  color: #af2727;
  font-weight: 600;
  margin-bottom: 0.2rem;
}
.modal-box .input {
  color: #222;
  background: #fff;
  border-bottom: 1px solid #af2727;
}
.modal-actions {
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
}
.cancel {
  background: #af2727;
  color: #fff;
  border: none;
  border-radius: 8px;  
  padding: 10px 24px;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.2s;
}
.cancel:hover {
  background: #d32f2f;
}
.modal-actions .submit {
  background: #fff;
  color: #222;
  border: 2px solid #222;
  border-radius: 8px;
  padding: 10px 24px;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.2s, color 0.2s, border 0.2s;
}
.modal-actions .submit:hover {
  background: #222;
  color: #fff;
  border: 2px solid #222;
}
</style>
