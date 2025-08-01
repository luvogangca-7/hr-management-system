<template>
  <div class="page-wrapper">
    <h1>My Dashboard</h1>
    <p>Welcome back {{ employee?.employee_name || 'Staff' }}, these are your stats so far!</p>
    <div class="main-page" v-if="!loading">
      <div class="container1">
        <div class="box">
          <i class="fas fa-calendar-check fa-2x"></i>
          <h3>Attendance (3 Weeks)</h3>
          <h1><CountUp :value="dashboardData.attendanceCount" />/17</h1>
        </div>
        <div class="box">
          <i class="fas fa-user-tie fa-2x"></i>
          <h3>Position</h3>
          <h1>{{ dashboardData.position || 'N/A' }}</h1>
        </div>
        <div class="box">
          <i class="bi bi-currency-dollar"></i>
          <h3>Current Salary</h3>
          <h1>R <CountUp :value="dashboardData.salary" /></h1>
        </div>
        <div class="box">
          <i class="fas fa-building fa-2x"></i>
          <h3>Department</h3>
          <h1>{{ dashboardData.department }}</h1>
        </div>
      </div>
      <div class="container2">
        <div class="box2">
          <h3>Recent Attendance</h3>
          <div class="attendance-list">
            <div v-for="(day, index) in dashboardData.recentAttendance" :key="index" class="attendance-item">
              <span><strong>{{ day.attendance_date }}</strong></span>
              <span :class="day.status === 'Present' ? 'present' : 'absent'">
                {{ day.status }}
              </span>
            </div>
          </div>
        </div>
        <div class="box2">
          <h4>Performance Summary</h4>
          <div class="opt">
            <div>
              <strong>Score</strong>
            </div>
            <span :style="{color: dashboardData.performanceScore >= 9 ? 'green' : dashboardData.performanceScore >= 8 ? 'orange' : 'red', fontWeight: 'bold'}">
              {{ dashboardData.performanceScore }}/10
            </span>
          </div>
          <div class="opt">
            <div>
              <strong>Last Feedback</strong>
            </div>
            <span style="font-size:0.95em; color:#888;">{{ dashboardData.lastFeedback }}</span>
          </div>
        </div>
      </div>
    </div>
    <div v-else class="loading-message">
      Loading dashboard data...
    </div>
    <div v-if="error" class="error-message">
      {{ error }}
    </div>
  </div>
</template>

<script>
import '@fortawesome/fontawesome-free/css/all.css'
import CountUp from '@/components/CountUp.vue';
import { mapGetters } from 'vuex';
import axios from 'axios';

export default {
  components: { CountUp },
  data() {
    return {
      dashboardData: {
        attendanceCount: 0,
        position: '',
        salary: 0,
        department: '',
        recentAttendance: [],
        performanceScore: 0,
        lastFeedback: ''
      },
      loading: true,
      error: null
    }
  },
  computed: {
    ...mapGetters(['employee'])
  },
  methods: {
    async fetchDashboardData() {
      try {
        // Add debug logging
        console.log('Current employee data:', this.employee);
        
        if (!this.employee || !this.employee.employee_id) {
          throw new Error('Employee not properly loaded');
        }

        const response = await axios.get(
          'http://localhost/hr-management-system/hr-backend/getEmployeeDashboard.php',
          {
            params: { id: this.employee.employee_id }
          }
        );

        console.log('API Response:', response.data);

        if (response.data.success) {
          this.dashboardData = {
            attendanceCount: response.data.attendance_count || 0,
            position: response.data.position || '',
            salary: response.data.salary || 0,
            department: response.data.department || '',
            recentAttendance: response.data.recent_attendance || [],
            performanceScore: response.data.performance_score || 0,
            lastFeedback: response.data.last_feedback || 'No feedback yet'
          };
        } else {
          this.error = response.data.message || 'Failed to load dashboard data';
        }
      } catch (err) {
        console.error('Error fetching dashboard data:', err);
        this.error = 'Failed to load dashboard data. Please try again later.';
      } finally {
        this.loading = false;
      }
    }
  },
  mounted() {
    // Add a small delay to ensure Vuex state is loaded
    setTimeout(() => {
      console.log("Employee from Vuex:", this.employee);
    console.log("Employee ID being sent:", this.employee?.employee_id)
      if (this.employee && this.employee.employee_id) {
        this.fetchDashboardData();
      } else {
        this.error = 'Please log in to view dashboard';
        this.loading = false;
      }
    }, 100);
  }
}
</script>

<style scoped>
.container1 {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 18px;
  padding: 10px 50px;
}

.box {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  border: 1px solid rgb(182, 180, 180, 0.2);
  border-radius: 12px;
  box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.13);
  background: #fff;
  transition: transform 0.2s, box-shadow 0.2s;
  padding: 20px 0 10px 0;
}
.box:hover, .box2:hover {
  transform: scale(1.04);
  box-shadow: 0 4px 24px #af272733;
  background: #f7f7f7;
}

.box i {
  margin-bottom: 12px;
  font-size: 2.5rem;
  color: #af2727;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: #f5eaea;
  padding: 20px;
}

.box h3 {
  margin: 0 0 8px 0;
  font-size: 1.1rem;
  font-weight: 600;
  text-align: center;
}

.box h1 {
  margin: 0;
  font-size: 2.2rem;
  font-weight: bold;
  text-align: center;
}

.container2 {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 18px;
  padding: 10px 50px;
}

.box2 {
  display:flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  border: 1px solid rgb(182, 180, 180, 0.2);
  border-radius: 12px;
  box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.13);
  padding: 20px;
  background: #fff;
  transition: transform 0.2s, box-shadow 0.2s;
}

.opt {
  width: 100%;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px;
  background-color: #fff7e6;
  margin: 10px 5px;
  border-radius: 10px;
  font-weight: 500;
}

@media (max-width: 900px) {
  .container1, .container2 {
    grid-template-columns: 1fr;
    padding: 10px 10px;
  }
}

.attendance-list {
  width: 100%;
  margin-top: 15px;
}
.attendance-item {
  display: flex;
  justify-content: space-between;
  padding: 8px 0;
  border-bottom: 1px solid #eee;
}
.present {
  color: green;
  font-weight: bold;
}
.absent {
  color: red;
  font-weight: bold;
}
</style>