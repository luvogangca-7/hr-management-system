<template>
  <div class="form-container" method="POST">
    <form @submit.prevent="submitForm" class="mb-4" >
      <input v-model="employeeData.name" placeholder="Full Name" name='name' required class="form-control mb-2" />
      <!-- Only show for NEW employees -->
<div v-if="!employee || !employee.id">
  <input
    v-model="employeeData.username"
    placeholder="Username"
    name="username"
    required
    class="form-control mb-2"
  />
  <input
    v-model="employeeData.password"
    placeholder="Password"
    name="password"
    type="password"
    required
    class="form-control mb-2"
  />
</div>
 
      <select v-model="employeeData.position" name="position" required class="form-control mb-2">
          <option disabled value="">Select Position</option>
          <option>HR Manager</option>
          <option>Software Engineer</option>
          <option>UI/UX Designer</option>
          <option>Quality Analyst</option>
          <option>Content Strategist</option>
          <option>Accountant</option>
          <option>Customer Support Lead</option>
          <option>DevOps Engineer</option>
          <option>Sales Representative</option>
          <option>Marketing Specialist</option>
      </select>
      <select v-model="employeeData.department" name="department" required class="form-control mb-2">
          <option disabled value="">Select Department</option>
          <option>HR</option>
          <option>Development</option>
          <option>IT</option>
          <option>Finance</option>
          <option>Marketing</option>
          <option>Support</option>
          <option>Quality Assurance</option>
          <option>Sales</option>
          <option>Design</option>
      </select>
      <input v-model.number="employeeData.salary" placeholder="Salary" name='salary' type="number" required class="form-control mb-2" />
      <input v-model="employeeData.history" placeholder="Employment History" name='history' class="form-control mb-2" />
      <input v-model="employeeData.email" placeholder="Email Address" type="email" name="email" required class="form-control mb-2" />
      <button type="submit" class="addBtn" id="sub">{{ employee && employee.id ? 'Update Employee' : 'Submit' }}</button>
      <button type="button" class="cancelBtn" @click="$emit('cancel-edit')">Cancel</button>
    </form>
  </div>
</template>

<script>
export default {
  props: {
    employee: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      employeeData: {
        name: '',
        username: '',
        password: '',
        position: '',
        department: '',
        salary: '',
        history: '',
        email: ''
      }
    }
  },
  watch: {
    employee: {
      handler(newVal) {
        if (newVal) {
          this.employeeData = { ...newVal, password: '' };
        } else {
          this.employeeData = {
            name: '',
            username: '',
            password: '',
            position: '',
            department: '',
            salary: '',
            history: '',
            email: ''
          };
        }
      },
      immediate: true
    }
  },
  methods: {
    submitForm() {
      if (!this.employeeData.name || !this.employeeData.username || 
          (!this.employee || !this.employee.id) && !this.employeeData.password || 
          !this.employeeData.position || !this.employeeData.department || 
          !this.employeeData.salary || !this.employeeData.email) {
        this.$emit('form-error', 'Please fill in all required fields');
        return;
      }

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(this.employeeData.email)) {
        this.$emit('form-error', 'Please enter a valid email address');
        return;
      }

      if (this.employee && this.employee.id) {
        this.$emit('update-employee', { ...this.employeeData, id: this.employee.id });
      } else {
        this.$emit('add-employee', { ...this.employeeData });
        this.employeeData = {
          name: '',
          username: '',
          password: '',
          position: '',
          department: '',
          salary: '',
          history: '',
          email: ''
        };
      }
    }
  }
}
</script>
