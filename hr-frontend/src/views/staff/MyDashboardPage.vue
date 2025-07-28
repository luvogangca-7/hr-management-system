<template>
  <div class="page-wrapper">
    <h1>My Dashboard</h1>
    <p>Welcome back Staff, these are your stats so far!</p>
    <div class="main-page">
      <div class="container1">
        <div class="box">
    <i class="fas fa-calendar-check fa-2x"></i>
    <h3>Attendance This Month</h3>
    <h1><CountUp :value="attendanceCount" />/<CountUp :value="totalWorkingDays" /></h1>
  </div>
  <div class="box">
    <i class="fas fa-clock fa-2x"></i>
    <h3>Average Hours Worked</h3>
    <h1><CountUp :value="avgHours" :decimals="1" /></h1>
  </div>
  <div class="box">
    <i class="bi bi-currency-dollar"></i>
    <h3>Current Salary</h3>
    <h1>R <CountUp :value="salary" /></h1>
  </div>
  <div class="box">
    <i class="fas fa-tasks fa-2x"></i>
    <h3>Tasks Completed</h3>
    <h1><CountUp :value="tasksCompleted" /></h1>
  </div>
      </div>
      <div class="container2">
        <div class="box2">
          <h3>Your Department</h3>
          <div style="font-size:1.1em; font-weight:600;">{{ department }}</div>
        </div>
        <div class="box2">
          <h4>Performance This Week</h4>
          <div class="opt">
            <div>
              <strong>Score</strong>
            </div>
            <span :style="{color: performanceScore >= 9 ? 'green' : performanceScore >= 8 ? 'orange' : 'red', fontWeight: 'bold'}">
              {{ performanceScore }}/10
            </span>
          </div>
          <div class="opt">
            <div>
              <strong>Last Feedback</strong>
            </div>
            <span style="font-size:0.95em; color:#888;">{{ lastFeedback }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import '@fortawesome/fontawesome-free/css/all.css'
import CountUp from '@/components/CountUp.vue';
import { mapGetters} from 'vuex';

export default {
  components: { CountUp },
  data() {
    return {
      attendanceCount: 18,
      totalWorkingDays: 22,
      avgHours: 7.8,
      salary: 32000,
      tasksCompleted: 12,
      department: 'Development',
      performanceScore: 9.1,
      lastFeedback: 'Great teamwork and timely delivery!'
    }
  },
  computed: {
  ...mapGetters(['employee'])
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
</style>