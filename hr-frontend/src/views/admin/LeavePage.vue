<template>
  <div class="page-wrapper">
    <h1>Leave Requests</h1>
    <p>Handle all your employees' leave requests with just a click.</p>
    <div class="main-page">
      <input
        v-model="search"
        type="text"
        placeholder="Search employee by name or reason"
        class="search-input"
      />
      <!-- Responsive table for leave requests -->
      <div style="overflow-x:auto;">
        <table class="table table-striped-columns table-responsive" v-if="filteredLeaveRequests.length">
          <thead>
            <tr>
              <th>Name</th>
              <th>Date</th>
              <th>Reason</th>
              <th>Status</th>
              <th v-if="isHR">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(req, idx) in filteredLeaveRequests" :key="idx">
              <td>{{ req.name }}</td>
              <td>{{ req.date }}</td>
              <td>{{ req.reason }}</td>
              <td>
                <span v-if="req.status === 'Pending' || req.status === 'pending'">Pending</span>
                <span v-else-if="req.status === 'Approved' || req.status === 'approved'" style="color:green">Approved</span>
                <span v-else style="color:red">Denied</span>
              </td>
              <td v-if="isHR">
                <div class="btn-cont">
                  <button v-if="req.status === 'Pending' || req.status === 'pending'" @click="approve(idx)" class="btn btn-primary mx-2">Approve</button>
                  <button v-if="req.status === 'Pending' || req.status === 'pending'" @click="deny(idx)" class="btn btn-danger mx-2">Deny</button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
        <p v-else>No leave requests yet.</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      allLeaveRequests: [], // All leave requests loaded from JSON
      isHR: true,           // Whether the user is HR (controls action buttons)
      search: ''            // Search input value
    }
  },
  computed: {
    // Returns filtered leave requests based on search input
    filteredLeaveRequests() {
      if (!this.search) return this.allLeaveRequests;
      const q = this.search.toLowerCase();
      // Filter by name or reason (case-insensitive)
      return this.allLeaveRequests.filter(
        req =>
          req.name.toLowerCase().includes(q) ||
          req.reason.toLowerCase().includes(q)
      );
    }
  },
  async mounted() {
    try {
      // Fetch attendance and leave data from a JSON file
      const response = await fetch('/hr-data/attendance.json');
      const attendanceData = await response.json();
      // Flatten the leave requests for all employees into a single array
      this.allLeaveRequests = attendanceData.attendanceAndLeave.flatMap(emp =>
        emp.leaveRequests.map(lr => ({
          name: emp.name,
          date: lr.date,
          reason: lr.reason,
          status: lr.status
        }))
      );
    } catch (error) {
      // Log error if fetch fails
      console.error('Failed to fetch leave data:', error);
    }
  },
  methods: {
    // Approve a leave request by index in the filtered list
    approve(idx) {
      // Find the request in the filtered list
      const req = this.filteredLeaveRequests[idx];
      // Find the real index in the allLeaveRequests array
      const realIdx = this.allLeaveRequests.findIndex(
        r =>
          r.name === req.name &&
          r.date === req.date &&
          r.reason === req.reason &&
          r.status === req.status
      );
      // Update the status if found
      if (realIdx !== -1) this.allLeaveRequests[realIdx].status = 'Approved';
    },
    // Deny a leave request by index in the filtered list
    deny(idx) {
      // Find the request in the filtered list
      const req = this.filteredLeaveRequests[idx];
      // Find the real index in the allLeaveRequests array
      const realIdx = this.allLeaveRequests.findIndex(
        r =>
          r.name === req.name &&
          r.date === req.date &&
          r.reason === req.reason &&
          r.status === req.status
      );
      // Update the status if found
      if (realIdx !== -1) this.allLeaveRequests[realIdx].status = 'Denied';
    }
  }
}
</script>

<style scoped>
.main-page h2 {
  margin-bottom: 16px;
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
    min-width: 200px;
  }
}
/* Responsive table: allow horizontal scroll on small screens */
.main-page > div {
  overflow-x: auto;
}
.main-page table {
  min-width: 600px;
  width: 100%;
  border-collapse: collapse;
  margin-top: 8px;
}
.main-page button {
  cursor: pointer;
}
.btn-cont {
  display: flex;
  justify-content: center;
}
</style>