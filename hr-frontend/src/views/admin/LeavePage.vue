<template>
  <div class="page-wrapper">
    <h1>Leave Requests</h1>
    <p>Handle all your employees' leave requests with just a click.</p>

    <div v-if="isLoading" class="loading">Loading leave requests...</div>
    
    <div class="main-page" v-else>
      <!-- History Section -->
      <div v-if="showHistory">
        

        <div class="filters">
          <input
          v-model="historySearch"
          type="text"
          placeholder="Search history by employee ID or reason"
          class="search-input"
        />
          <button class="butn" @click="setHistoryFilter('Approved')">Approved</button>
          <button class="butn" @click="setHistoryFilter('Denied')">Denied</button>
          <button class="butn" @click="setHistoryFilter('')">All</button>
          <button class="butn" @click="showHistory = false">Hide History</button>
        </div>

        <table v-if="filteredHistory.length">
          <thead>
            <tr>
              <th>Employee ID</th>
              <th>Name</th>
              <th>Leave Date</th>
              <th>End Date</th>
              <th>Reason</th>
              <th>Status</th>
              <th>Remove</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(req, index) in filteredHistory" :key="req.id">
              <td>{{ req.employee_id }}</td>
              <td>{{ req.employee_name }}</td>
              <td>{{ req.leave_date }}</td>
              <td>{{ req.end_date }}</td>
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
        <p v-else>No history records found.</p>
      </div>

      <!-- Current Requests Section -->
      <div v-else>
        

        <div class="filters">
          <input
          v-model="search"
          type="text"
          placeholder="Search by employee ID, name or reason"
          class="search-input"
        />
          <button class="butn" @click="showHistory = true">View History</button>
        </div>

        <div style="overflow-x:auto;">
          <table class="table table-striped-columns table-responsive" v-if="filteredLeaveRequests.length">
            <thead>
              <tr>
                <th>Employee ID</th>
                <th>Name</th>
                <th>Department</th>
                <th>Leave Date</th>
                <th>End Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(req, idx) in filteredLeaveRequests" :key="req.id">
                <td>{{ req.employee_id }}</td>
                <td>{{ req.employee_name }}</td>
                <td>{{ req.department_name }}</td>
                <td>{{ req.leave_date }}</td>
                <td>{{ req.end_date }}</td>
                <td>{{ req.reason }}</td>
                <td :style="{ color: req.status === 'Approved' ? 'green' : req.status === 'Denied' ? 'red' : 'black' }">
                  {{ req.status }}
                </td>
                <td>
                  <div class="btn-cont">
                    <button
                      v-if="req.status === 'Pending'"
                      @click="handleStatusChange(req, 'Approved')"
                      class="btn btn-success mx-2"
                    >
                      Approve
                    </button>
                    <button
                      v-if="req.status === 'Pending'"
                      @click="handleStatusChange(req, 'Denied')"
                      class="btn btn-danger mx-2"
                    >
                      Deny
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
          <p v-else>No leave requests found. {{ allLeaveRequests.length === 0 ? 'No data loaded from server.' : 'No matching requests found.' }}</p>
        </div>
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
      historyRequests: [],
      search: '',
      statusFilter: '',
      showHistory: false,
      historySearch: '',
      historyStatusFilter: '',
      isLoading: true
    }
  },
  created() {
    this.fetchLeaveRequests()
    this.fetchLeaveHistory()
  },
  computed: {
    filteredLeaveRequests() {
      return this.allLeaveRequests.filter(req => {
        const searchTerm = this.search.toLowerCase()
        const matchesSearch =
          req.employee_id.toString().includes(searchTerm) ||
          req.employee_name.toLowerCase().includes(searchTerm) ||
          req.reason.toLowerCase().includes(searchTerm)

        const matchesStatus = this.statusFilter
          ? req.status.toLowerCase() === this.statusFilter.toLowerCase()
          : true

        return matchesSearch && matchesStatus
      })
    },
    filteredHistory() {
      return this.historyRequests.filter(req => {
        const searchTerm = this.historySearch.toLowerCase()
        const matchesSearch =
          req.employee_id.toString().includes(searchTerm) ||
          (req.employee_name && req.employee_name.toLowerCase().includes(searchTerm)) ||
          req.reason.toLowerCase().includes(searchTerm)

        const matchesStatus = this.historyStatusFilter
          ? req.status.toLowerCase() === this.historyStatusFilter.toLowerCase()
          : true

        return matchesSearch && matchesStatus
      })
    }
  },
  methods: {
    async fetchLeaveRequests() {
      this.isLoading = true
      try {
        const res = await axios.get('http://localhost/hr-management-system/hr-backend/getLeaveRequests.php')
        console.log('Leave requests data:', res.data)
        this.allLeaveRequests = res.data.leaveRequests || []
      } catch (error) {
        console.error('Error fetching leave requests:', error)
        console.error('Error details:', error.response)
      } finally {
        this.isLoading = false
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
    async handleStatusChange(req, newStatus) {
  try {
    const success = await this.updateLeaveStatus(req.employee_id, req.leave_date, newStatus);
    if (!success) {
      alert('Failed to update status');
    }
    // The updateLeaveStatus method will now handle refreshing both lists
  } catch (error) {
    console.error('Error updating status:', error);
    alert('Error updating status');
  }
},
    async updateLeaveStatus(employee_id, leave_date, status) {
  try {
    const res = await axios.post('http://localhost/hr-management-system/hr-backend/updateLeaveStatus.php', {
      employee_id,
      leave_date,
      status
    })
    
    // Refresh both lists after status change
    this.fetchLeaveRequests()
    this.fetchLeaveHistory()
    
    return res.data.success
  } catch (error) {
    console.error('Error updating leave status:', error)
    return false
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
.page-wrapper {
  padding: 20px;
}

.loading {
  padding: 20px;
  text-align: center;
  font-style: italic;
  color: #666;
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

.filters {
  display: flex;
  gap: 8px;
  margin-bottom: 12px;
  flex-wrap: wrap;
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
  width: 100%;
  border-collapse: collapse;
  margin-top: 8px;
}

.main-page th, .main-page td {
  padding: 8px;
  border: 1px solid #ddd;
  text-align: left;
}

.main-page th {
  background-color: #f2f2f2;
}

.btn-cont {
  display: flex;
  justify-content: center;
  gap: 8px;
}

.btn-success {
  background-color: #28a745;
  color: white;
}

.btn-danger {
  background-color: #dc3545;
  color: white;
}

.btn-outline-danger {
  background-color: transparent;
  color: #dc3545;
  border: 1px solid #dc3545;
}
</style>