<template>
  <div class="page-wrapper">
    <h1>Dashboard</h1>
    <p>Welcome back Admin, these are the stats so far!</p>
    <div class="main-page">
      <div class="container1">
       <div class="box" @click="$router.push('/employees')" style="cursor:pointer;">
    <i class="fas fa-users fa-2x"></i>
    <h3>Total Employees</h3>
    <h1><CountUp :value="employeeCount" /></h1>
  </div>
  <div class="box" @click="$router.push('/attendance')" style="cursor:pointer;">
    <i class="fas fa-calendar-check fa-2x"></i>
    <h3>Attendance</h3>
    <h1><CountUp :value="attendanceCount" /></h1>
  </div>
  <div class="box" @click="$router.push('/payroll')" style="cursor:pointer;">
    <i class="fas fa-clock fa-2x"></i>
    <h3>Average Hours</h3>
    <h1><CountUp :value="avgHours" :decimals="1" /></h1>
  </div>
  <div class="box" @click="$router.push('/payroll')" style="cursor:pointer;">
    <i class="bi bi-currency-dollar"></i>
    <h3>Average Salary</h3>
    <h1>R <CountUp :value="avgSalary" /></h1>
  </div>
      </div>
      <div class="container2">
        <div class="box2" @click="$router.push('/performance')" style="cursor:pointer;">
          <h3>Departments Overview</h3>
          <department-bar-chart :departments="departments" />
        </div>
        <div class="box2" @click="$router.push('/performance')" style="cursor:pointer;">
          <h4>Top 3 Performing Employees This Week</h4>
          <div v-for="(emp, idx) in topPerformers" :key="idx" class="opt">
            <div>
              <strong>{{ idx + 1 }}. {{ emp.name }}</strong>
              <div style="font-size: 0.95em; color: #888;">{{ emp.position }}</div>
            </div>
            <span :style="{color: emp.score >= 9 ? 'green' : emp.score >= 8 ? 'orange' : 'red', fontWeight: 'bold'}">
              {{ emp.score }}/10
            </span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import DepartmentBarChart from '@/components/DepartmentBarChart.vue'
import CountUp from '@/components/CountUp.vue'
import '@fortawesome/fontawesome-free/css/all.css'

export default {
  components: { DepartmentBarChart, CountUp },
  data() {
    return {
      avgSalary: 63600,
      employeeCount: 10,
      attendanceCount: 8,
      avgHours: 7.5,
      departments: [
        { name: 'IT', count: 2 },
        { name: 'Support', count: 1 },
        { name: 'QA', count: 1 },
        { name: 'Development', count: 2 },
        { name: 'Finance', count: 1 },
        { name: 'Marketing', count: 1 },
        { name: 'Design', count: 1 },
        { name: 'Sales', count: 1 },
        { name: 'HR', count: 1 }
      ],
      clockStatus: [
        { name: 'Sibongile Nkosi', status: 'Absent' },
        { name: 'Lungile Moyo', status: 'Present' },
        { name: 'Thabo Molefe', status: 'Absent' }
      ],
      topPerformers: [
        { name: 'Sibongile Nkosi', score: 9.5, position: 'Developer' },
        { name: 'Lungile Moyo', score: 9.2, position: 'QA' },
        { name: 'Thabo Molefe', score: 8.9, position: 'Support' }
      ]
    }
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
  padding: 20px 0 10px 0; /* Add vertical padding for better spacing */
}
.box:hover, .box2:hover {
  transform: scale(1.04);
  box-shadow: 0 4px 24px #af272733;
  background: #f7f7f7;
}

.box i {
  margin-bottom: 12px;
  font-size: 2.5rem; /* Make icon larger */
  color: #af2727;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 60px;   /* Ensures icon is centered and doesn't overflow */
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