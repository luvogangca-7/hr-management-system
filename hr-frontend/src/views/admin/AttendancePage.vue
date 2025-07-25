<template>
<div class="page-wrapper">
    <h1>Company Attendance</h1>
    <p>The attendance of your employees this month.</p>
  <div class="main-page">
    
    <AttendanceComp
      :matrix="attendanceMatrix"
      :dates="allDates"
    />
  </div>
</div>
</template>

<script>
import AttendanceComp from '@/components/AttendanceComp.vue';

export default {
  name: "Attendance",
  components: { AttendanceComp },
  data() {
    return {
      rawAttendance: []
    };
  },
  async mounted() {
    try {
      const response = await fetch('/hr-data/attendance.json');
      const data = await response.json();
      this.rawAttendance = data.attendanceAndLeave;
    } catch (error) {
      console.error('Failed to fetch attendance data:', error);
    }
  },
  computed: {
    // Get all unique dates (sorted)
    allDates() {
      const dates = new Set();
      this.rawAttendance.forEach(emp => {
        emp.attendance.forEach(a => dates.add(a.date));
      });
      return Array.from(dates).sort();
    },
    // Build the matrix: one row per employee, columns for each date
    attendanceMatrix() {
      return this.rawAttendance.map(emp => {
        const statusByDate = {};
        emp.attendance.forEach(a => {
          statusByDate[a.date] = a.status;
        });
        return {
          name: emp.name,
          statuses: this.allDates.map(date => statusByDate[date] || '')
        };
      });
    }
  },
  methods: {
    handleDelete(index) {
      this.rawAttendance.splice(index, 1);
    }
  }
}
</script>