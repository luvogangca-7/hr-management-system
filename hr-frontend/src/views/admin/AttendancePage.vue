<template>
  <div class="page-wrapper">
    <h1>Company Attendance</h1>
    <p>The attendance of your employees this month.</p>

    <!-- Week Filter -->
    <div class="filter">
      <label for="week">Select Week:</label>
      <input type="week" id="week" v-model="selectedWeek" @change="filterByWeek" />
    </div>

    <div v-if="error" class="error">{{ error }}</div>
    <div v-else-if="loading">Loading attendance data...</div>
    <div v-else class="main-page">
      <AttendanceComp :matrix="filteredMatrix" :dates="filteredDates" />
    </div>
  </div>
</template>

<script>
import AttendanceComp from '@/components/AttendanceComp.vue';

export default {
  name: "AttendancePage",
  components: { AttendanceComp },
  data() {
    return {
      rawAttendance: [],
      filteredAttendance: [],
      selectedWeek: '',
      loading: true,
      error: null,
    };
  },
  methods: {
    filterByWeek() {
      if (!this.selectedWeek) {
        this.filteredAttendance = this.rawAttendance;
        return;
      }

      const [year, weekStr] = this.selectedWeek.split('-W');
      const week = parseInt(weekStr);

      const startDate = this.getDateOfISOWeek(week, parseInt(year));
      const endDate = new Date(startDate);
      endDate.setDate(startDate.getDate() + 6); // end of the selected week

      const start = startDate.toISOString().split('T')[0];
      const end = endDate.toISOString().split('T')[0];

      this.filteredAttendance = this.rawAttendance.map(emp => {
        const filteredRecords = emp.attendance.filter(record => {
          return record.date >= start && record.date <= end;
        });

        return {
          name: emp.name,
          attendance: filteredRecords
        };
      });
    },
    getDateOfISOWeek(week, year) {
      const simple = new Date(year, 0, 1 + (week - 1) * 7);
      const dow = simple.getDay();
      const ISOweekStart = simple;
      if (dow <= 4)
        ISOweekStart.setDate(simple.getDate() - simple.getDay() + 1);
      else
        ISOweekStart.setDate(simple.getDate() + 8 - simple.getDay());
      return ISOweekStart;
    }
  },
  async mounted() {
    try {
      const res = await fetch('http://localhost/hr-management-system/hr-backend/adminAttendance.php');
      const data = await res.json();

      if (data.success) {
        this.rawAttendance = data.attendanceAndLeave;
        this.filteredAttendance = data.attendanceAndLeave; // default
      } else {
        this.error = data.message || 'Failed to load attendance data';
      }
    } catch (e) {
      this.error = 'Error fetching attendance data: ' + e.message;
    } finally {
      this.loading = false;
    }
  },
  computed: {
    filteredDates() {
      const dateSet = new Set();
      this.filteredAttendance.forEach(emp => {
        emp.attendance.forEach(record => {
          dateSet.add(record.date);
        });
      });
      return Array.from(dateSet).sort();
    },
    filteredMatrix() {
      return this.filteredAttendance.map(emp => {
        const dateStatusMap = {};
        emp.attendance.forEach(record => {
          dateStatusMap[record.date] = record.status;
        });
        return {
          name: emp.name,
          statuses: this.filteredDates.map(date => dateStatusMap[date] || '')
        };
      });
    }
  }
};
</script>

<style scoped>
.page-wrapper {
  padding: 20px;
  font-family: Arial, sans-serif;
}

h1 {
  margin-bottom: 0.2em;
}

.main-page {
  margin-top: 1em;
}

.error {
  color: red;
  font-weight: bold;
}

.filter {
  margin-bottom: 1em;
}

.filter label {
  margin-right: 10px;
  font-weight: bold;
}
</style>
