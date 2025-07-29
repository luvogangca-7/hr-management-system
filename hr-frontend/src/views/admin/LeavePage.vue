<template>
  <div class="page-wrapper">
    <h1>Leave Requests</h1>
    <p>Handle all your employees' leave requests with just a click.</p>

    <div class="main-page">

      <!-- history area that will show when you press history -->

            <input
        v-if="showHistory"
        v-model="historySearch"
        type="text"
        placeholder="Search history by employee ID or reason"
        class="search-input"
      />

      <div class="filters" v-if="showHistory">
        <button class="butn" @click="setHistoryFilter('Approved')">Approved</button>
        <button class="butn" @click="setHistoryFilter('Denied')">Denied</button>
        <button class="butn" @click="setHistoryFilter('')">All</button>
      </div>

      <table v-if="showHistory && filteredHistory.length">
        <thead>
          <tr>
            <th>Employee ID</th>
            <th>Leave Date</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Remove</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(req, index) in filteredHistory" :key="req.id">
            <td>{{ req.employee_id }}</td>
            <td>{{ req.leave_date }}</td>
            <td>{{ req.reason }}</td>
            <td :style="{ color: req.status === 'Approved' ? 'green' : 'red' }">{{ req.status }}</td>
            <td>
              <button class="btn btn-outline-danger" @click="removeFromHistory(index, req)">
                Remove
              </button>
            </td>
          </tr>
        </tbody>
      </table>

      <input
        v-model="search"
        type="text"
        placeholder="Search by employee ID or reason"
        class="search-input"
      />

      <div class="filters">
        <button class="butn" @click="setStatusFilter('Pending')">Pending</button>
        <button class="butn" @click="setStatusFilter('Approved')">Approved</button>
        <button class="butn" @click="setStatusFilter('Denied')">Denied</button>
        <button class="butn" @click="setStatusFilter('')">All</button>
      </div>

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
            <tr
              v-for="(req, idx) in filteredLeaveRequests"
              :key="req.employee_id + '-' + req.leave_date"
            >
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
    search: '',
    statusFilter: '',
    showHistory: false,
    historyRequests: [],
    historySearch: '',
    historyStatusFilter: ''
  }
},
  computed: {
  filteredLeaveRequests() {
    return this.allLeaveRequests.filter(req => {
      const q = this.search.toLowerCase()
      const matchesSearch =
        req.employee_id.toString().includes(q) ||
        req.reason.toLowerCase().includes(q)

      const matchesStatus = this.statusFilter
        ? req.status.toLowerCase() === this.statusFilter.toLowerCase()
        : true

      return matchesSearch && matchesStatus
    })
  },
  filteredHistory() {
    return this.historyRequests.filter(req => {
      const q = this.historySearch.toLowerCase()
      const matchesSearch =
        req.employee_id.toString().includes(q) ||
        req.reason.toLowerCase().includes(q)

      const matchesStatus = this.historyStatusFilter
        ? req.status.toLowerCase() === this.historyStatusFilter.toLowerCase()
        : true

      return matchesSearch && matchesStatus
    })
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
  async fetchLeaveHistory() {
    try {
      const res = await axios.get('http://localhost/hr-management-system/hr-backend/getLeaveHistory.php')
      this.historyRequests = res.data.history || []
    } catch (error) {
      console.error('Error fetching leave history:', error)
    }
  },
  async updateLeaveStatus(employee_id, leave_date, status) {
    try {
      const res = await axios.post('http://localhost/hr-management-system/hr-backend/updateLeaveStatus.php', {
        employee_id,
        leave_date,
        status
      })
      return res.data.success
    } catch (error) {
      console.error('Error updating leave status:', error)
      return false
    }
  },
  async handleStatusChange(req, newStatus) {
    const success = await this.updateLeaveStatus(req.employee_id, req.leave_date, newStatus)
    if (success) {
      // Update locally
      const index = this.allLeaveRequests.findIndex(
        item => item.employee_id === req.employee_id && item.leave_date === req.leave_date
      )
      if (index !== -1) {
        this.allLeaveRequests[index].status = newStatus

        // Save to history DB
        await axios.post('http://localhost/hr-management-system/hr-backend/saveToLeaveHistory.php', {
          employee_id: req.employee_id,
          leave_date: req.leave_date,
          reason: req.reason,
          status: newStatus
        })

        // Refresh history
        this.fetchLeaveHistory()
      }
    } else {
      alert('Failed to update status.')
    }
  },
  async removeFromHistory(index, record) {
    const confirmDelete = confirm('Are you sure you want to remove this from history?')
    if (!confirmDelete) return

    try {
      await axios.post('http://localhost/hr-management-system/hr-backend/deleteFromLeaveHistory.php', {
        id: record.id
      })
      this.historyRequests.splice(index, 1)
    } catch (err) {
      console.error('Error deleting history:', err)
    }
  },
  setStatusFilter(status) {
    this.statusFilter = status
    this.showHistory = false
  },
  setHistoryFilter(status) {
    this.historyStatusFilter = status
  }
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

.filters {
  display: flex;
  gap: 8px;
  margin-bottom: 12px;
}

.butn {
  background-color: #eee;
  border: 1px solid #ccc;
  padding: 6px 12px;
  border-radius: 4px;
  cursor: pointer;
  transition: 0.2s;
}

.butn:hover {
  background-color: #ddd;
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
.btn-cont {
  display: flex;
  justify-content: center;
}
</style>
