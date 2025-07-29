<template>
    <div class="page-wrapper">
    <h1>My Profile</h1>
    <p>Welcome back Staff, here you can edit your details!</p>
    <div class="main-page">
      <div class="box-cont">
        <div class="personal-box">

        <div class="profile-pic">
        <svg height='200px'fill="#b0b0b0" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 45.53 45.53" xml:space="preserve" stroke="#b0b0b0" stroke-width="0.00045531999999999994"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M22.766,0.001C10.194,0.001,0,10.193,0,22.766s10.193,22.765,22.766,22.765c12.574,0,22.766-10.192,22.766-22.765 S35.34,0.001,22.766,0.001z M22.766,6.808c4.16,0,7.531,3.372,7.531,7.53c0,4.159-3.371,7.53-7.531,7.53 c-4.158,0-7.529-3.371-7.529-7.53C15.237,10.18,18.608,6.808,22.766,6.808z M22.761,39.579c-4.149,0-7.949-1.511-10.88-4.012 c-0.714-0.609-1.126-1.502-1.126-2.439c0-4.217,3.413-7.592,7.631-7.592h8.762c4.219,0,7.619,3.375,7.619,7.592 c0,0.938-0.41,1.829-1.125,2.438C30.712,38.068,26.911,39.579,22.761,39.579z"></path> </g> </g></svg>
        <br>
        <br>
        <h2>{{ employee.employee_name}}</h2>
      </div>
      

      <div class="details">

         <h5><i class="bi bi-briefcase-fill"></i> Role</h5>
        <p>{{ employee.position }}</p>

        <h5><i class="bi bi-building"></i> Department</h5>
        <p>{{ employee.department_name }}</p>

        <h5><i class="bi bi-calendar-check-fill"> </i>Date Hired</h5>
        <p>{{ employee.employment_history }}</p>

      </div>
      
    </div>
    <div class="job-box">
      
      <h4><i class="bi bi-info-circle"></i>Basic Information</h4>
      <div class="details">

      
      <h5><i class="bi bi-cake-fill"></i> DOB</h5>
      <p>{{ employee.dob }}</p>
      
      <h5><i class="bi bi-gender-ambiguous"></i> Gender</h5>
      <p>{{ employee.gender }}</p>
      
      <h5><i class="bi bi-person-heart"></i> Marital Status</h5>
      <p>{{ employee.marital_status}}</p>
      
      <h5><i class="bi bi-envelope-fill"></i> Email</h5>
      <p>{{ employee.email }}</p>

      <h5><i class="bi bi-telephone-fill"></i> Phone Number</h5>
      <p>{{ employee.phone }}</p>

      <h5><i class="bi bi-geo-alt-fill"></i> Address</h5>
      <p>{{ employee.address }}</p>

      <button class="btn btn-outline-secondary" @click="openEditModal">Edit <i class="bi bi-pencil-fill"></i></button>

      <!-- Edit Modal -->
<div v-if="showModal" class="modal fade show" style="display: block;" tabindex="-1" aria-modal="true" role="dialog">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="modal-header">
        <h5 class="modal-title">Edit Your Information</h5>
        <button type="button" class="btn-close" @click="showModal = false" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form @submit.prevent="updateProfile">
          <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth</label>
            <input v-model="form.dob" type="date" class="form-control" id="dob" />
          </div>

          <div class="mb-3">
            <label for="gender" class="form-label">Gender</label>
            <select v-model="form.gender" id="gender" class="form-select">
              <option value="Male">Male</option>
              <option value="Female">Female</option>
              <option value="Other">Other</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="marital_status" class="form-label">Marital Status</label>
            <select v-model="form.marital_status" id="marital_status" class="form-select">
              <option value="Single">Single</option>
              <option value="In a relationship">In a relationship</option>
              <option value="Married">Married</option>
            </select>
          </div>

          <div class="mb-3">
            <label for="phone" class="form-label">Phone Number</label>
            <input v-model="form.phone" id="phone" type="tel" class="form-control" placeholder="Phone Number" />
          </div>

          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input v-model="form.address" id="address" type="text" class="form-control" placeholder="Address" />
          </div>

          <div class="modal-footer p-0 pt-3">
            <button type="submit" class="btn btn-primary me-2">Save Changes</button>
            <button type="button" class="btn btn-secondary" @click="showModal = false">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


      </div>
      
      
    </div>
  </div>
  
  
</div>
</div>
</template>
<script>

import { mapGetters} from 'vuex';
import axios from 'axios';

export default {
  name: "MyProfilePage",
  data() {
    return {
      showModal: false,
      form: {
        dob: '',
        gender: '',
        marital_status: '',
        phone: '',
        address: ''
      }
    };
  },
  computed: {
    ...mapGetters(['employee'])
  },
  methods: {
    openEditModal() {
      this.showModal = true;
      this.form = {
        dob: this.employee.dob || '',
        gender: this.employee.gender || '',
        marital_status: this.employee.marital_status || '',
        phone: this.employee.phone || '',
        address: this.employee.address || ''
      };
      this.form.id = this.employee.employee_id;
    },
    async updateProfile() {
  try {
    const payload = {
      id: this.employee.employee_id,
      name: this.employee.employee_name,
      username: this.employee.username,
      position: this.employee.position,
      department: this.employee.department_name,
      salary: this.employee.salary,
      email: this.employee.email,
      history: this.employee.employment_history,

      // Extended details from modal
      dob: this.form.dob,
      gender: this.form.gender,
      marital_status: this.form.marital_status,
      phone: this.form.phone,
      address: this.form.address
    };

    console.log(payload);

    const response = await axios.post(
      'http://localhost/hr-management-system/hr-backend/editEmployees.php',
      payload,
      {
        headers: {
          'Content-Type': 'application/json'
        }
      }
    );

    if (response.data.success) {
  alert('Profile updated successfully.');
  this.showModal = false;

 await this.fetchProfile();
}else {
      alert('Update failed: ' + response.data.error);
    }
  } catch (error) {
    alert('An error occurred: ' + error.message);
  }
},
async fetchProfile() {
  try {
    const response = await axios.get('http://localhost/hr-management-system/hr-backend/getEmployeesById.php', {
      params: { id: this.employee.employee_id }
    });
    if (response.data.length > 0) {
      this.$store.commit('updateEmployee', response.data[0]);

    }
  } catch (err) {
    console.error('Fetch failed:', err);
  }
}
},
mounted() {
  this.fetchProfile();
}
};

</script>
<style scoped>

.box-cont{
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 18px;
  padding: 10px 50px;
}
.personal-box, .job-box {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  border: 1px solid rgb(182, 180, 180, 0.2);
  border-radius: 12px;
  box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.13);
  background: #fff;
  transition: transform 0.2s, box-shadow 0.2s;
  padding: 20px;
}

.details {
  display: flex;
  flex-direction: column;
  width: 100%;
  background-color: #f3f3f3;
  border: 1px solid #dadada;
  border-radius: 8px;
  padding: 10px;

}

.profile-pic {
  margin-bottom: 20px;
}

/* p {
  font-size: 1.1rem;
} */

i {
  color:#c8c8c8;
}

button:hover {
  color:#f7f7f7
}

.modal {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
}
.modal-content {
  background: #fff;
  padding: 20px;
  border-radius: 10px;
  width: 400px;
}




</style>