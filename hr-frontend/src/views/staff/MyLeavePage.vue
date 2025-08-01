<template>
  <div class="page-wrapper">
    <h1>My Leave</h1>
    <p>Apply for leave and view your leave history.</p>

    <div class="main-page">

      <div class="summary-cards">
      <div class="card">
        <h3>Leave Days Taken</h3>
        <p class="number">{{ totalLeaveTaken }}</p>
      </div>
      <div class="card">
        <h3>Leave Days Left</h3>
        <p class="number">{{ leaveDaysLeft }}</p>
      </div>
    </div>

      <form @submit.prevent="submitLeaveRequest" class="leave-form">

        <h2>Apply for Leave</h2>
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
      <table v-if="leaveHistory.length">
  <thead>
    <tr>
      <th>Start Date</th>
      <th>End Date</th>
      <th>Reason</th>
      <th>Status</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="(record, index) in leaveHistory" :key="index">
      <td>{{ record.startDate }}</td>
      <td>{{ record.endDate }}</td>
      <td>{{ record.reason }}</td>
      <td :style="{ color: record.status === 'Approved' ? 'green' : 'red' }">
  {{ record.status || 'Pending' }}
</td>
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
      leaveRequested: false
    };
  },
 computed: {
  employee() {
    return this.$store.state.employee;
  },
  employeeId() {
    return this.employee?.employee_id;
  },
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
  },
  leaveHistory() {
    return this.$store.state.employee?.leaveRecords?.filter(
      record => record.employee_id === this.employeeId
    ) || [];
  },

  // ✅ Total Approved Leave Days Taken
  totalLeaveTaken() {
    return (this.leaveHistory || [])
      .filter(r => r.status === 'Approved')
      .reduce((sum, r) => {
        const start = new Date(r.startDate);
        const end = new Date(r.endDate);
        return sum + (Math.floor((end - start) / (1000 * 60 * 60 * 24)) + 1);
      }, 0);
  },

  // ✅ Leave Days Left from Vuex (dynamic)
  leaveDaysLeft() {
    return this.employee?.leaveBalance ?? 0;
  }
}
,
  mounted() {
  this.fetchLeaveBalance();
},
methods: {
  async fetchLeaveBalance() {
    try {
      const res = await axios.get(
        `http://localhost/hr-management-system/hr-backend/getLeaveBalance.php?id=${this.employeeId}`
      );
      if (res.data.success) {
        this.$store.commit('updateEmployee', {
          ...this.employee,
          leaveBalance: res.data.leaveBalance
        });
      } else {
        console.warn('Leave balance fetch failed:', res.data.message);
      }
    } catch (err) {
      console.error('Error fetching leave balance:', err);
    }
  },
  async submitLeaveRequest() {
    if (!this.isFormValid || this.exceedsBalance) return;

    try {
      const payload = {
        employeeId: this.employeeId,
        startDate: this.leaveForm.startDate,
        endDate: this.leaveForm.endDate,
        reason: this.leaveForm.reason
      };

      const response = await axios.post(
        'http://localhost/hr-management-system/hr-backend/submitLeaveRequest.php',
        JSON.stringify(payload),
        {
          headers: {
            'Content-Type': 'application/json'
          }
        }
      );

      if (response.data.success) {
        this.leaveRequested = true;

        const newRecord = {
          startDate: this.leaveForm.startDate,
          endDate: this.leaveForm.endDate,
          reason: this.leaveForm.reason,
          status: 'Pending'
        };

        this.$store.commit('updateEmployee', {
          ...this.employee,
          leaveRecords: [...(this.employee.leaveRecords || []), newRecord]
        });

        this.leaveForm = { startDate: '', endDate: '', reason: '' };
        setTimeout(() => {
          this.leaveRequested = false;
        }, 3000);
      } else {
        alert('Failed to submit: ' + response.data.message);
      }
    } catch (error) {
      console.error('Submission error:', error);
      alert('Error: ' + (error.response?.data?.message || error.message));
    }
  }
}
};
</script>
<style scoped>
.leave-page {
  max-width: 720px;
  margin: 2rem auto;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
  padding: 2rem 3rem;
  color: black;
}

.summary-cards {
  display: flex;
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.card {
  flex: 1;
  background: white;
  padding: 1rem;
  border-radius: 10px;
  text-align: center;
  border: 1px solid #af2727;
}

.card h3 {
  margin-bottom: 0.5rem;
  font-size: 1rem;
  color: af2727;
}

.number {
  font-size: 2.2rem;
  font-weight: 700;
  color:af2727;
}

.leave-history h2,
.leave-form-section h2 {
  color: af2727;
  margin: 2rem 0 1rem;
  font-size: 1.3rem;
  font-weight: 600;
  border-bottom: 1px solid #ccc;
  padding-bottom: 0.3rem;
}

table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.95rem;
  margin-top: 0.5rem;
}

table th,
table td {
  text-align: left;
  padding: 0.6rem 1rem;
  border-bottom: 1px solid #e0e0e0;
}

table thead {
  background-color: #f0f4ff;
}

.no-history {
  text-align: center;
  font-style: italic;
  color: #888;
  margin-top: 1rem;
}

.leave-form {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-bottom: 29px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

input[type="date"],
textarea {
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 1rem;
}

textarea {
  resize: vertical;
  min-height: 80px;
}

button {
  background-color: #af2727;
  color: #fff;
  border: none;
  padding: 0.7rem;
  font-size: 1rem;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.2s ease;
}

button:disabled {
  background-color: #af2727;
  cursor: not-allowed;
}

.error-msg {
  color: #e74c3c;
  font-size: 0.95rem;
  margin-top: -0.5rem;
}

.confirmation-message {
  margin-top: 1rem;
  padding: 1rem;
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
  border-radius: 6px;
  font-size: 0.95rem;
  text-align: center;
}

.success-msg {
  color: #1ca64c;
  font-weight: bold;
  margin-top: 1rem;
}

label {
  color: #212529;
}


</style>
