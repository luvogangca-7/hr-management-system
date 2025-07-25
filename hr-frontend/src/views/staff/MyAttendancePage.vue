<template>
  <div class="attendance-container">
    <h1>My Attendance</h1>

    <label for="week">Filter by Week:</label>
    <input type="week" v-model="selectedWeek" @change="filterByWeek" />

    <button @click="checkIn">Check In</button>
    <p v-if="message">{{ message }}</p>

    <table v-if="filteredAttendance.length">
      <thead>
        <tr>
          <th>Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="record in filteredAttendance" :key="record.attendance_date">
          <td>{{ record.attendance_date }}</td>
          <td>{{ record.status }}</td>
        </tr>
      </tbody>
    </table>

    <p v-else>No attendance records found.</p>
  </div>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      userId: 1, // Replace with actual user ID from login later
      attendance: [],
      filteredAttendance: [],
      selectedWeek: "",
      message: "",
    };
  },
  methods: {
    async fetchAttendance() {
      try {
        const response = await axios.get(
          "http://localhost:8081/hr_project/hr-system-project-main/HR_Project/api/get-attendance.php"
        );
        this.attendance = response.data;
        this.filterByWeek();
      } catch (error) {
        console.error("Error fetching attendance:", error);
        this.message = "Failed to load attendance.";
      }
    },
    filterByWeek() {
      if (!this.selectedWeek) {
        this.filteredAttendance = this.attendance.filter(
          (record) => record.employee_id === this.userId
        );
        return;
      }

      const [year, week] = this.selectedWeek.split("-W");
      const firstDay = this.getDateOfISOWeek(week, year);
      const lastDay = new Date(firstDay);
      lastDay.setDate(firstDay.getDate() + 6);

      this.filteredAttendance = this.attendance.filter((record) => {
        const recordDate = new Date(record.attendance_date);
        return (
          record.employee_id === this.userId &&
          recordDate >= firstDay &&
          recordDate <= lastDay
        );
      });
    },
    getDateOfISOWeek(week, year) {
      const simple = new Date(year, 0, 1 + (week - 1) * 7);
      const dayOfWeek = simple.getDay();
      const ISOweekStart = simple;
      if (dayOfWeek <= 4)
        ISOweekStart.setDate(simple.getDate() - simple.getDay() + 1);
      else ISOweekStart.setDate(simple.getDate() + 8 - simple.getDay());
      return ISOweekStart;
    },
    async checkIn() {
      const today = new Date().toISOString().split("T")[0]; // Format: YYYY-MM-DD
      const payload = {
        employee_id: this.userId,
        date: today,
        status: "Present",
      };

      try {
        const response = await axios.post(
          "http://localhost:8081/hr_project/hr-system-project-main/HR_Project/api/add_attendance.php",
          payload
        );
        this.message = response.data.message || response.data.error || "";
        if (response.data.success) {
          this.fetchAttendance(); // Refresh after check-in
        }
      } catch (error) {
        console.error("Check-in error:", error);
        this.message = "Error during check-in.";
      }
    },
  },
  mounted() {
    this.fetchAttendance();
  },
};
</script>

<style scoped>
.attendance-container {
  padding: 20px;
}
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
input[type="week"] {
  margin-bottom: 10px;
  padding: 5px;
}
button {
  margin-top: 10px;
  padding: 8px 12px;
}
</style>
