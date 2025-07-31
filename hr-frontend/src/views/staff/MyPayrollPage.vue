<template>
  <div class="page-wrapper">
    <h1>My Payroll</h1>
    <p>Welcome! Here is your payroll summary.</p>

    <div class="main-page">
      <div v-if="loading">Loading payroll data...</div>

    <p v-if="message" class="message">{{ message }}</p>

    <div v-else>
      <div v-if="payrollRecord" class="employee-info">
        <p><strong>Employee ID:</strong> {{ payrollRecord.employee_id }}</p>
        <p><strong>Employee Name:</strong> {{ payrollRecord.employee_name }}</p>
      </div>

      <table v-if="payrollRecord">
        <thead>
          <tr>
            <th>Hours Worked</th>
            <th>Leave Deductions</th>
            <th>Final Salary</th>
            <th>Tax (10%)</th>
            <th>Rate</th>
            <th>Net Salary</th>
            <th>Payslip</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ payrollRecord.hours_worked }}</td>
            <td>{{ payrollRecord.leave_deductions }}</td>
            <td>{{ formatCurrency(payrollRecord.final_salary) }}</td>
            <td>{{ formatCurrency(taxAmount) }}</td>
            <td>{{ hourlyRate }}</td>
            <td>{{ formatCurrency(netSalary) }}</td>
            <td>
              <button @click="generatePayslip">Download PDF</button>
            </td>
          </tr>
        </tbody>
      </table>

      <p v-else>No payroll record found.</p>
    </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import jsPDF from "jspdf";
import autoTable from "jspdf-autotable";

export default {
  name: "StaffPayrollPage",
  data() {
    return {
      payrollRecord: null,
      loading: true,
      message: "",
      taxRate: 0.1,
      hourlyRate: "R533.33/hr",
    };
  },
  computed: {
    userId() {
      return this.$store.state.employee?.employee_id || null;
    },
    taxAmount() {
      return this.payrollRecord
        ? this.payrollRecord.final_salary * this.taxRate
        : 0;
    },
    netSalary() {
      return this.payrollRecord
        ? this.payrollRecord.final_salary - this.taxAmount
        : 0;
    },
  },
  methods: {
    async fetchPayroll() {
      if (!this.userId) {
        this.message = "Employee not logged in.";
        this.loading = false;
        return;
      }

      try {
        const res = await axios.get(
          `http://localhost/hr-management-system/hr-backend/listpayroll.php?employee_id=${this.userId}`
        );

        if (res.data.success && res.data.payrollData.length > 0) {
          this.payrollRecord = res.data.payrollData[0];
          this.message = "";
        } else {
          this.message = "No payroll record found.";
        }
      } catch (error) {
        this.message = "Error fetching payroll: " + error.message;
      } finally {
        this.loading = false;
      }
    },
    formatCurrency(amount) {
      return amount.toLocaleString("en-ZA", {
        style: "currency",
        currency: "ZAR",
        minimumFractionDigits: 2,
      });
    },
    generatePayslip() {
      const doc = new jsPDF();
      const record = this.payrollRecord;

      // Calculate values
      const taxAmount = record.final_salary * this.taxRate;
      const netSalary = record.final_salary - taxAmount;

      // Title
      doc.setFontSize(18);
      doc.text("Modern Tech Solutions", 70, 20);
    
      doc.setFontSize(14);
      doc.text("Employee Payslip", 85, 30);

      // Employee info on top
      doc.setFontSize(12);
      doc.text(`Employee ID: ${record.employee_id}`, 20, 45);
      doc.text(`Employee Name: ${record.employee_name}`, 20, 55);

      // Table rows as label-value pairs
      const rows = [
        ["Hours Worked", record.hours_worked],
        ["Leave Deductions", record.leave_deductions],
        ["Rate",this.hourlyRate],
        ["Final Salary", this.formatCurrency(record.final_salary)],
        ["Tax (10%)", this.formatCurrency(taxAmount)],
        ["Net Salary", this.formatCurrency(netSalary)],
      ];

      autoTable(doc, {
        startY: 65,
        body: rows.map(([label, value]) => [label, value]),
        styles: {
          halign: "left",
          valign: "middle",
          cellPadding: 4,
          lineWidth: 0.3,
        },
        columnStyles: {
          0: { fontStyle: "bold", textColor: [33, 33, 33] },
        },
        theme: "grid",
        tableWidth: "auto",
      });

      doc.save(`payslip_${record.employee_id}.pdf`);
    },
  },
  mounted() {
    this.fetchPayroll();
  },
};
</script>

<style scoped>
.payroll-container {
  padding: 20px;
}

.message {
  color: #1565c0;
  margin-top: 10px;
}

.employee-info p {
  margin: 0;
  font-weight: 600;
  font-size: 14px;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
}

th,
td {
  padding: 10px;
  border: 1px solid #ccc;
  text-align: left;
}

button {
  padding: 6px 12px;
  background-color: #1976d2;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
</style>
