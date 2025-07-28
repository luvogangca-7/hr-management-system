<template>
  <div>
    <table class="table table-striped-columns table-bordered table-sm table-hover">
      <thead class="table-light">
        <tr>
          <th>Employee</th>
          <th v-for="date in dates" :key="date">{{ formatDate(date) }}</th>
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
              color: getTextColor(status),
              textAlign: 'center'
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
      if (status === "Present") return "#D4EDDA";    // light green
      if (status === "Absent") return "#F8D7DA";     // light red
      if (status === "Late") return "#FFF3CD";       // light yellow/orange
      return "";
    },
    getTextColor(status) {
      if (status === "Present") return "#155724";
      if (status === "Absent") return "#721C24";
      if (status === "Late") return "#856404";
      return "";
    },
    formatDate(dateStr) {
      if (!dateStr) return "";
      const options = { month: 'short', day: 'numeric' }; // e.g. Jul 28
      return new Date(dateStr).toLocaleDateString(undefined, options);
    }
  }
};
</script>