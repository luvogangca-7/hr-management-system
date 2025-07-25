<template>
<div class="table-container table-responsive">
  <table class="table table-striped-columns">
    <thead>
      <tr>
      <th>Full Name</th>
      <th>Position</th>
      <th>Department</th>
      <th>Salary</th>
      <th>Employment History</th>
      <th>Email Address</th>
      <th>Edit</th>
      <th>Delete</th>
    </tr>
    </thead>
    <tbody>
      <tr v-for="employee in employees" :key="employee.id">
      <td>{{ employee.name }}</td>
      <td>{{ employee.position }}</td>
      <td>{{ employee.department }}</td>
      <td>R{{ employee.salary }}</td>
      <td>{{ employee.history }}</td>
      <td>{{ employee.email }}</td>
      <td>
        <button class="butn" @click="$emit('edit-employee', employee)">Edit</button>
      </td>
      <td><button class="addBtn" @click="$emit('delete-employee', employee)">Delete</button></td>
    </tr>
    </tbody>
    
  </table>
 </div>
</template>
<script>
export default {
  props: {
    employees: {
      type: Array,
      required: true
    }
  }
}
</script>
<style>
  button {
    padding: 5px 7px;
    border: none;
    border-radius: 4px;
    color: white;
    
  }


</style>