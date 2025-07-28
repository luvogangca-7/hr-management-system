<template>
  <div class="form-container" method="POST">
    <form @submit.prevent="submitForm" class="mb-4" >
      <input v-model="employeeData.name" placeholder="Full Name" name='name' required class="form-control mb-2" />
      <input v-model="employeeData.username" placeholder="Username" name='username' required class="form-control mb-2" />
      <input v-model="employeeData.password" placeholder="Password" name='password' type="password" :required="!employee || !employee.id" class="form-control mb-2" />
      <input v-model="employeeData.position" placeholder="Position" name='position' required class="form-control mb-2" />
      <input v-model="employeeData.department" placeholder="Department" name='department' required class="form-control mb-2" />
      <input v-model.number="employeeData.salary" placeholder="Salary" name='salary' type="number" required class="form-control mb-2" />
      <input v-model="employeeData.history" placeholder="Employment History" name='history' class="form-control mb-2" />
      <input v-model="employeeData.email" placeholder="Email Address" type="email" name="email" required class="form-control mb-2" />
      <button type="submit" class="addBtn" id="sub">{{ employee && employee.id ? 'Update Employee' : 'Submit' }}</button>
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
