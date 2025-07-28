<template>
  <div class="page-wrapper">
      <div class="heading">
     <h1>Employees</h1>

 <p>Managing your employees has never been easier.</p>


  </div>


 <div class="main-page">

 <input
  v-model="search"
  type="text"
  placeholder="Search employee by name, position, or department"
  class="search-input"
/>


   <button class="addBtn" @click="showAdd()">{{ addEmp ? 'Hide' : 'Add employee'}}</button>

  <!-- Only show the form if adding OR editing, not both -->
<div class="main-page" v-if="addEmp || editingEmployee">
  <h3>{{ editingEmployee ? 'Edit employee' : 'Add new employee' }}</h3>
  <employee-form
    :employee="editingEmployee"
    @add-employee="addEmployee"
    @update-employee="updateEmployee"
  />

</div>

 
 <employee-comp
  :employees="filteredEmployees"
  @edit-employee="editEmployee"
  @delete-employee="deleteEmployee"
/>

 </div>

  </div>



 
 
</template>
<script>
import EmployeeComp from '@/components/EmployeeComp.vue';
import EmployeeForm from '@/components/EmployeeForm.vue';
import axios from 'axios';

export default{
   data() {
    return {
      employees: [],
      editingEmployee: null,
      addEmp: false,
      search: ''
    }
  },
  async mounted() {
    await this.fetchEmployees();
  },
  computed: {
    filteredEmployees() {
      if (!this.search) return this.employees;
      const q = this.search.toLowerCase();
      return this.employees.filter(emp =>
        emp.name.toLowerCase().includes(q) ||
        emp.position.toLowerCase().includes(q) ||
        emp.department.toLowerCase().includes(q)
      );
    }
  },
  methods: {
    async fetchEmployees() {
      try {
        const response = await axios.get('http://localhost/hr-management-system/hr-backend/getEmployees.php');

        
        this.employees = response.data.map(item => ({
          id: item.employee_id,           // Make sure this matches the PHP field name
          name: item.employee_name,       // Make sure this matches the PHP field name
          position: item.position,
          department: item.department_name, // Make sure this matches the PHP field name
          salary: item.salary,
          history: item.employment_history, // Make sure this matches the PHP field name
          email: item.email
        }));
        
        console.log('Mapped employees:', this.employees); 
      } catch (error) {
        console.error('Error fetching employees:', error);
        console.error('Error response:', error.response); // Additional debug info
      }
    },
    
    async addEmployee(newEmployee) {
  try {
    const response = await axios.post(
      'http://localhost/hr-management-system/hr-backend/addEmployees.php',
      newEmployee,
      {
        headers: {
          'Content-Type': 'application/json'
        }
      }
    );

    if (response.data.success) {
      console.log('Employee added successfully!', response.data);
      await this.fetchEmployees(); // Refresh the list
      this.addEmp = false; // Close the form
    } else {
      console.error('Server error:', response.data.error);
      alert(`Error: ${response.data.error || 'Failed to add employee'}`);
    }
  } catch (error) {
    console.error('Request failed:', error);
    alert('Network error. Check console for details.');
  }
},
    async deleteEmployee(employee) {
      try {
        const response = await axios.post('http://localhost/hr-management-system/hr-backend/deleteEmployees.php', { id: employee.id });
        if (response.data.success) {
          // Remove from local array for instant UI update
          this.employees = this.employees.filter(e => e.id !== employee.id);
          // Optionally, fetch from backend again to sync
          await this.fetchEmployees();
        } else {
          alert('Failed to delete employee: ' + response.data.error);
        }
      } catch (error) {
        console.error('Error deleting employee:', error);
        alert('Error deleting employee. Please try again.');
      }
    },
    editEmployee(employee) {
  // Set the employee to be edited
  this.editingEmployee = { ...employee };
  this.addEmp = false; // Make sure addEmp is false when editing!
},
async updateEmployee(updatedEmployee) {
  try {
    const response = await axios.post('http://localhost/hr-management-system/hr-backend/editEmployees.php', updatedEmployee);
    if (response.data.success) {
      await this.fetchEmployees();
      this.editingEmployee = null;
      this.addEmp = false;
    } else {
      alert('Failed to update employee: ' + response.data.error);
    }
  } catch (error) {
    console.error('Error updating employee:', error);
    alert('Error updating employee. Please try again.');
  }
},
showAdd() {
  this.addEmp = !this.addEmp;
  if (this.addEmp) {
    this.editingEmployee = null;
  }
}
},

  components:{
    EmployeeComp,
    EmployeeForm

  }
}
</script>
<style>

h3 {
  padding: 20px 0;
}
.table-container {
    display: flex;
    justify-content: center;
    align-items: center;
 }

table {
  width: 100%;
  padding: 0 50px;
  border: 1px solid gray;
}

td {
  text-align: start;
  padding: 20px;
  margin: 20px;
}

td, th {
  border-left-color: gray;
}

.addBtn {
  background-color: #af2727;
  color: white;
  padding: 8px;
  border: none;
  border-radius: 6px;
  margin-bottom: 8px;
  width: fit-content;
}

.search-input {
  display: flex;
  min-width: 200px;
  max-width: 100%;
  margin-bottom: 18px;
  padding: 8px 12px;
  width: 75%;
  border-radius: 5px;
  border: 1px solid #ccc;
  font-size: 16px;
  box-sizing: border-box;
  transition: width 0.2s;
}

@media (max-width: 900px) {
  .search-input {
    width: 60%;
  }
}

@media (max-width: 600px) {
  .search-input {
    width: 100%;
  }
}
</style>