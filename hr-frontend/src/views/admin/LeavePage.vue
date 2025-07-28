<template>
  <div class="page-wrapper">
    <h1>Leave Requests</h1>
    <p>Handle all your employees' leave requests with just a click.</p>

    <div class="main-page">
      <input
        v-model="search"
        type="text"
        placeholder="Search by employee ID or reason"
        class="search-input"
      />

      <div style="overflow-x:auto;">
        <table class="table table-striped-columns table-responsive" v-if="filteredLeaveRequests.length">
          <thead>
            <tr>
              <th>Employee ID</th>
              <th>Leave Date</th>
              <th>Reason</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(req, idx) in filteredLeaveRequests" :key="req.employee_id + '-' + req.leave_date">
              <td>{{ req.employee_id }}</td>
              <td>{{ req.leave_date }}</td>
              <td>{{ req.reason }}</td>
              <td :style="{ color: req.status === 'Approved' ? 'green' : req.status === 'Denied' ? 'red' : 'black' }">
                {{ req.status }}
              </td>
              <td>
                <div class="btn-cont">
                  <button
                    v-if="req.status === 'Pending'"
                    @click="updateLeaveStatus(req.employee_id, req.leave_date, 'Approved')"
                    class="btn btn-success mx-2"
                  >
                    Approve
                  </button>
                  <button
                    v-if="req.status === 'Pending'"
                    @click="updateLeaveStatus(req.employee_id, req.leave_date, 'Denied')"
                    class="btn btn-danger mx-2"
                  >
                    Deny
                  </button>
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
import axios from 'axios'

export default {
  data() {
    return {
      allLeaveRequests: [],
      search: ''
    }
  },
  computed: {
    filteredLeaveRequests() {
      if (!this.search) return this.allLeaveRequests
      const q = this.search.toLowerCase()
      return this.allLeaveRequests.filter(
        req =>
          req.employee_id.toString().includes(q) ||
          req.reason.toLowerCase().includes(q)
      )
    }
  },
  methods: {
    async fetchLeaveRequests() {
      try {
        const res = await axios.get('http://localhost/hr-management-system/hr-backend/getLeaveRequests.php')
        this.allLeaveRequests = res.data.leaveRequests || []
      } catch (error) {
        console.error('Error fetching leave requests:', error)
      }
    },
    async updateLeaveStatus(employee_id, leave_date, status) {
      try {
        const res = await axios.post('http://localhost/hr-management-system/hr-backend/updateLeaveStatus.php', {
          employee_id,
          leave_date,
          status
        })

        if (res.data.success) {
          // Update status locally
          const index = this.allLeaveRequests.findIndex(
            req => req.employee_id === employee_id && req.leave_date === leave_date
          )
          if (index !== -1) this.allLeaveRequests[index].status = status
        } else {
          alert(res.data.message || 'Failed to update status')
        }
      } catch (error) {
        console.error('Error updating leave status:', error)
      }
    }
  },
  mounted() {
    this.fetchLeaveRequests()
  }
}
</script>

<style scoped>
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
