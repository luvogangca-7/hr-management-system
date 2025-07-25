<template>
  <div class="page-wrapper">
    <h1>Leave Info</h1>
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

    <section class="leave-history" v-if="employee.leaveRecords.length">
      <h2>Leave History</h2>
      <table>
        <thead>
          <tr>
            <th>From</th>
            <th>To</th>
            <th>Days</th>
            <th>Reason</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(record, index) in employee.leaveRecords" :key="index">
            <td>{{ formatDate(record.startDate) }}</td>
            <td>{{ formatDate(record.endDate) }}</td>
            <td>{{ calculateDays(record.startDate, record.endDate) }}</td>
            <td>{{ record.reason }}</td>
          </tr>
        </tbody>
      </table>
    </section>

    <p v-else class="no-history">No leave records yet.</p>

    <section class="leave-form-section">
      <h2>Request New Leave</h2>
      <form @submit.prevent="submitLeaveRequest" class="leave-form">
        <div class="form-group">
          <label>Start Date</label>
          <input type="date" v-model="leaveForm.startDate" required :min="today" />
        </div>

        <div class="form-group">
          <label>End Date</label>
          <input type="date" v-model="leaveForm.endDate" required :min="leaveForm.startDate || today" />
        </div>

        <div class="form-group">
          <label>Reason</label>
          <select v-model="leaveForm.reason" required class="input">
            <option disabled value="">Select reason</option>
            <option>Sick Leave</option>
            <option>Personal</option>
            <option>Family Emergency</option>
            <option>Vacation</option>
            <option>Medical Appointment</option>
            <option>Bereavement</option>
            <option>Childcare</option>
            <option>Other</option>
          </select>
        </div>

        <button :disabled="!isFormValid || exceedsBalance">Submit Leave Request</button>
        <p v-if="exceedsBalance" class="error-msg">
          You don't have enough leave days left for this request.
        </p>
      </form>

      <!-- Confirmation Message -->
      <div v-if="leaveRequested" class="confirmation-message">
        <p>Your leave request has been submitted successfully!</p>
      </div>
      <p v-if="leaveRequested" class="success-msg">
        Leave has been requested!
      </p>
    </section>
  </div>
  </div>
</template>

<script>
export default {
  name: "PersonalLeavePage",
  data() {
    return {
      employee: {
        name: "Sibongile Nkosi",
        totalLeaveAllowed: 20,
        leaveRecords: [
          {
            startDate: "2025-07-22",
            endDate: "2025-07-22",
            reason: "Sick Leave	"
          },
          {
            startDate: "2024-12-01	",
            endDate: "2024-12-01",
            reason: "Personal"
          }
        ]
      },
      leaveForm: {
        startDate: "",
        endDate: "",
        reason: ""
      },
      today: new Date().toISOString().split("T")[0],
      leaveRequested: false
    };
  },
  computed: {
    totalLeaveTaken() {
      return this.employee.leaveRecords.reduce(
        (sum, record) => sum + this.calculateDays(record.startDate, record.endDate),
        0
      );
    },
    leaveDaysLeft() {
      return Math.max(this.employee.totalLeaveAllowed - this.totalLeaveTaken, 0);
    },
    requestedLeaveDays() {
      const { startDate, endDate } = this.leaveForm;
      return this.isValidDateRange ? this.calculateDays(startDate, endDate) : 0;
    },
    isFormValid() {
      const { startDate, endDate, reason } = this.leaveForm;
      return startDate && endDate && reason.trim() && startDate <= endDate;
    },
    isValidDateRange() {
      return this.leaveForm.startDate && this.leaveForm.endDate && this.leaveForm.startDate <= this.leaveForm.endDate;
    },
    exceedsBalance() {
      return this.requestedLeaveDays > this.leaveDaysLeft;
    }
  },
  methods: {
    formatDate(dateStr) {
      return new Date(dateStr).toLocaleDateString(undefined, {
        year: "numeric",
        month: "short",
        day: "numeric"
      });
    },
    calculateDays(start, end) {
      const msPerDay = 1000 * 60 * 60 * 24;
      return Math.floor((new Date(end) - new Date(start)) / msPerDay) + 1;
    },
    submitLeaveRequest() {
      if (!this.isFormValid || this.exceedsBalance) return;

      this.employee.leaveRecords.push({
        startDate: this.leaveForm.startDate,
        endDate: this.leaveForm.endDate,
        reason: this.leaveForm.reason
      });

      this.leaveForm = { startDate: "", endDate: "", reason: "" };
      this.leaveRequested = true; // Show confirmation
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

h1 {
  color: #af2727 ;
  font-size: 1.8rem;
  margin-bottom: 2rem;
  font-weight: 700;
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


</style>
