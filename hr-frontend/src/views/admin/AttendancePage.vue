<template>
  <div class="page-wrapper">
    <div class="head">
      <div>
        <h1>Attendance</h1>
    <p>The attendance of your employees this month.</p>
      </div>
      

    <!-- Week Filter -->
    <div class="filter">
      <label for="week">Select Week:</label>
      <select id="week" v-model="selectedWeek" @change="filterByWeek" class="form-select">
        <option 
          v-for="option in weekOptions" 
          :key="option.label" 
          :value="option.label"
        >
          {{ option.label }}
        </option>
      </select>
    </div>
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
      // Week options with label, start date, and end date (5 days each)
      weekOptions: [
        { label: 'Jul 20 to Jul 24', start: '2025-07-20', end: '2025-07-24' },
        { label: 'Jul 25 to Jul 29', start: '2025-07-25', end: '2025-07-29' },
        { label: 'Jul 31 to Aug 04', start: '2025-07-31', end: '2025-08-04' }
      ],
      selectedWeek: 'Jul 25 to Jul 29',  // Default selected week
      loading: true,
      error: null,
    };
  },
  methods: {
    filterByWeek() {
      const selectedOption = this.weekOptions.find(w => w.label === this.selectedWeek);
      if (!selectedOption) {
        // If none selected, show all
        this.filteredAttendance = this.rawAttendance;
        return;
      }

      const start = selectedOption.start;
      const end = selectedOption.end;

      this.filteredAttendance = this.rawAttendance.map(emp => {
        const filteredRecords = emp.attendance.filter(record => {
          return record.date >= start && record.date <= end;
        });

        return {
          name: emp.name,
          attendance: filteredRecords
        };
      });
    }
  },
  async mounted() {
    try {
      const res = await fetch('http://localhost/hr-management-system/hr-backend/adminAttendance.php');
      const data = await res.json();

      if (data.success) {
        this.rawAttendance = data.attendanceAndLeave;
        this.filterByWeek(); // Apply filter with default selectedWeek
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
<style>
.head {
  display: flex;
  justify-content: space-between;
}
.filter{
  justify-self: flex-end;
}
.filter label {
  font-size: 1.1rem;
  color:#333;
  margin-right: 8px;
}


</style>
