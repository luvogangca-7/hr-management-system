<template>
  <div class="page-wrapper">
    <h1>My Payroll</h1>
    <p>Welcome back Staff, here is your payroll information.</p>
    <div class="main-page">

      <!-- Search/filter by employeeId -->
      <div class="filter">
        <label for="filterEmployeeId">Filter by Employee ID:</label>
        <input
          type="number"
          id="filterEmployeeId"
          v-model.number="filterEmployeeId"
          min="1"
          placeholder="Enter employee ID"
        />
      </div>

      <!-- Payroll Table -->
      <section class="payroll-table" v-if="filteredPayroll.length">
        <h2>Payroll Records</h2>
        <table>
          <thead>
            <tr>
              <th scope="col">Employee ID</th>
              <th scope="col">Hours Worked</th>
              <th scope="col">Leave Deductions</th>
              <th scope="col">Final Salary</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="record in filteredPayroll" :key="record.employee_id">
              <td>{{ record.employee_id }}</td>
              <td>{{ record.hours_worked }}</td>
              <td>{{ record.leave_deductions }}</td>
              <td>{{ formatCurrency(record.final_salary) }}</td>
            </tr>
          </tbody>
        </table>
      </section>

      <section v-else>
        <p>No payroll records found.</p>
      </section>

      <!-- Contact HR -->
      <section class="contact-hr">
        <h3>Need help with payroll?</h3>
        <p>If you have any questions or discrepancies, please <a href="mailto:hr@company.com">contact HR</a>.</p>
      </section>

    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      filterEmployeeId: null,
      payrollRecords: [],
    };
  },
  mounted() {
    axios.get('http://localhost/api/get_payroll.php') // update URL to your PHP API endpoint
      .then(response => {
        this.payrollRecords = response.data.payrollData || [];
      })
      .catch(error => {
        console.error('Error loading payroll data:', error);
        alert('Error loading payroll data');
      });
  },
  computed: {
    filteredPayroll() {
      if (!this.filterEmployeeId) return this.payrollRecords;
      return this.payrollRecords.filter(
        record => record.employee_id === this.filterEmployeeId
      );
    },
  },
  methods: {
    formatCurrency(amount) {
      return amount.toLocaleString(undefined, {
        style: 'currency',
        currency: 'USD',
      });
    },
  },
};
</script>

<style scoped>
.page-wrapper {
  max-width: 900px;
  margin: auto;
  padding: 1rem;
  font-family: Arial, sans-serif;
  color: #333;
}

h1 {
  margin-bottom: 0.2rem;
}
p {
  margin-top: 0;
  margin-bottom: 1.5rem;
  color: #555;
}

.filter {
  margin-bottom: 1rem;
}

.filter label {
  margin-right: 0.5rem;
  font-weight: 600;
}

table {
  width: 100%;
  border-collapse: collapse;
}

table thead tr {
  background-color: #e0e0e0;
}

table tbody tr td,
table thead tr th {
  border: 1px solid #ccc;
  padding: 0.5rem 0.7rem;
  text-align: left;
}

.contact-hr {
  margin-top: 2rem;
}

.contact-hr a {
  color: #007bff;
  text-decoration: none;
}

.contact-hr a:hover {
  text-decoration: underline;
}
</style>
