<template>
  <div class="page-wrapper">
    <h1>My Attendance</h1>
    <p>Monitor your attendance</p>

    <div class="main-page">
      <label for="weekSelect" style="color: #212529;">Select Week:</label>
      <select id="weekSelect" v-model="selectedWeek" @change="fetchAttendance">
        <option v-for="week in weeks" :key="week.label" :value="week">
          {{ week.label }}
        </option>
      </select>

      <table v-if="attendance.length">
        <thead>
          <tr>
            <th>Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="record in attendance" :key="record.date">
            <td>{{ record.date }}</td>
            <td>{{ record.status }}</td>
          </tr>
        </tbody>
      </table>

      <p v-else>No attendance records found for this week.</p>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      employeeId: null, // Will be set from local storage or auth
      weeks: [
        { label: "Jul 20 – Jul 24", start: "2025-07-20", end: "2025-07-24" },
        { label: "Jul 25 – Jul 29", start: "2025-07-25", end: "2025-07-29" },
        { label: "Jul 30 – Aug 03", start: "2025-07-30", end: "2025-08-03" },
      ],
      selectedWeek: null,
      attendance: [],
    };
  },
  mounted() {
    this.employeeId = localStorage.getItem("employee_id");
    this.selectedWeek = this.weeks[0];
    this.fetchAttendance();
  },
  methods: {
    async fetchAttendance() {
      if (!this.employeeId || !this.selectedWeek) return;

      try {
        const res = await axios.get(
          `http://localhost/hr-management-system/hr-backend/getEmployeeAttendance.php`,
          {
            params: {
              id: this.employeeId,
              start: this.selectedWeek.start,
              end: this.selectedWeek.end,
            },
          }
        );
        this.attendance = res.data;
      } catch (error) {
        console.error("Error fetching attendance:", error);
        this.attendance = [];
      }
    },
  },
};
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 15px;
}
th,
td {
  padding: 8px;
  border: 1px solid #ccc;
  text-align: left;
}
select {
  margin-bottom: 10px;
  padding: 6px;
}
</style>
