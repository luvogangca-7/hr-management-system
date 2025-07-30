<template>
  <div class="page-wrapper">
    <h1>My Leave</h1>
    <p>Apply for leave and view your leave history.</p>

    <div class="main-page">
      <form @submit.prevent="submitLeaveRequest">
        <label>Start Date:</label>
        <input type="date" v-model="leaveForm.startDate" required />

        <label>End Date:</label>
        <input type="date" v-model="leaveForm.endDate" required />

        <label>Reason:</label>
        <textarea v-model="leaveForm.reason" required></textarea>

        <button type="submit" :disabled="!isFormValid || exceedsBalance">
          Submit Leave Request
        </button>

        <p v-if="exceedsBalance" style="color: red;">
          Requested days exceed your available leave balance ({{ employee.leaveBalance }} days).
        </p>
      </form>

      <div v-if="leaveRequested" style="color: green; margin-top: 10px;">
        Leave request submitted successfully!
      </div>

      <h2>My Leave History</h2>
      <table v-if="employee.leaveRecords.length">
        <thead>
          <tr>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reason</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(record, index) in employee.leaveRecords" :key="index">
            <td>{{ record.startDate }}</td>
            <td>{{ record.endDate }}</td>
            <td>{{ record.reason }}</td>
          </tr>
        </tbody>
      </table>

      <p v-else>No leave records found.</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      leaveForm: {
        startDate: '',
        endDate: '',
        reason: ''
      },
      leaveRequested: false,
      employeeId: '', // Replace with dynamic user ID if available
      employee: {
        leaveBalance: 15,
        leaveRecords: []
      }
    };
  },
  computed: {
    isFormValid() {
      return (
        this.leaveForm.startDate &&
        this.leaveForm.endDate &&
        this.leaveForm.reason &&
        new Date(this.leaveForm.startDate) <= new Date(this.leaveForm.endDate)
      );
    },
    leaveDaysRequested() {
      if (!this.isFormValid) return 0;
      const start = new Date(this.leaveForm.startDate);
      const end = new Date(this.leaveForm.endDate);
      return Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1;
    },
    exceedsBalance() {
      return this.leaveDaysRequested > this.employee.leaveBalance;
    }
  },
  methods: {
    async submitLeaveRequest() {
      if (!this.isFormValid || this.exceedsBalance) return;

      try {
        const response = await axios.post(
          'http://localhost/hr-management-system/hr-backend/submitLeaveRequest.php',
          {
            employeeId: this.employeeId,
            startDate: this.leaveForm.startDate,
            endDate: this.leaveForm.endDate,
            reason: this.leaveForm.reason
          }
        );

        if (response.data.success) {
          this.leaveRequested = true;
          this.employee.leaveRecords.push({
            startDate: this.leaveForm.startDate,
            endDate: this.leaveForm.endDate,
            reason: this.leaveForm.reason
          });
          this.leaveForm = { startDate: '', endDate: '', reason: '' };
        } else {
          alert('Failed to submit: ' + response.data.message);
        }
      } catch (error) {
        console.error('Submission error:', error);
        alert('Server error occurred.');
      }
    }
  }
};
</script>
