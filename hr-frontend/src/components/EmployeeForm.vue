<template>
    <div class="form-container" method="POST">
    <form @submit.prevent="submitForm" class="mb-4" >
    <input v-model="employeeData.name" placeholder="Full Name" name='name' required class="form-control mb-2" />
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
          this.employeeData = { ...newVal };
        } else {
          this.employeeData = {
            name: '',
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
    // Basic validation
    if (!this.employeeData.name || !this.employeeData.position || 
        !this.employeeData.department || !this.employeeData.salary || 
        !this.employeeData.email) {
      this.$emit('form-error', 'Please fill in all required fields');
      return;
    }
    
    // Email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(this.employeeData.email)) {
      this.$emit('form-error', 'Please enter a valid email address');
      return;
    }

    if (this.employee && this.employee.id) {
      this.$emit('update-employee', { ...this.employeeData, id: this.employee.id });
    } else {
      this.$emit('add-employee', { ...this.employeeData });
      // Only reset if not in edit mode
      this.employeeData = {
        name: '',
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

<style>
    .form-container {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-right: 100px;
    }

    #sub {
        margin-top: 15px;
    }
</style>