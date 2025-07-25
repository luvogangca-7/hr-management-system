<template>
  <table class="table table-striped-columns table-responsive">
    <thead class="table-light">
      <tr>
        <th>Employee ID</th>
        <th>Employee Name</th>
        <th>Hours Worked</th>
        <th>Leave Deductions</th>
        <th>Salary</th> 
        <th>Action</th>
        <th>Download</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="employee in records" :key="employee.id">
        <td>{{ employee.id }}</td>
        <td>{{ employee.name }}</td>
        <td>{{ employee.hoursWorked }}</td>
        <td>{{ employee.leaveDeductions }}</td>
        <td>R{{ employee.salary }}</td>
        <td>
          <button class="butn mx-2" @click="$emit('edit', employee)">Edit</button>
          <button class="addBtn mx-2" @click="$emit('delete', employee.id)">Delete</button>
        </td>
        <td>
          <button class="btn btn-secondary" @click="$emit('generate', employee)">Payslip</button>
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script>
export default {
  name: "PayrollComp",
  props: {
    records: Array
  }
};
</script>
