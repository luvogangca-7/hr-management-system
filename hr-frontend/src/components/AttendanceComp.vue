<template>
  <div>
    <table class="table table-striped-columns">
      <thead class="table-light">
        <tr>
          <th>Employee</th>
          <th v-for="date in dates" :key="date">{{ date }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, idx) in matrix" :key="idx">
          <td>{{ row.name }}</td>
          <td
            v-for="(status, i) in row.statuses"
            :key="i"
            :style="{
              backgroundColor: getStatusColor(status),
              color: getTextColor(status)
            }"
          >
            {{ status }}
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: "AttendanceComp",
  props: {
    matrix: { type: Array, required: true },
    dates: { type: Array, required: true }
  },
  methods: {
    getStatusColor(status) {
      if (status === "Present") return "#d4edda";    // light green
      if (status === "Absent") return "#f8d7da";     // light red
      if (status === "Late") return "#fff3cd";       // light yellow/orange
      return ""; // default
    },
    getTextColor(status) {
      if (status === "Present") return "#155724";
      if (status === "Absent") return "#721c24";
      if (status === "Late") return "#856404";
      return "";
    }
  }
}
</script>