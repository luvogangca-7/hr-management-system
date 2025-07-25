<template>
  <div class="page-wrapper">
    <h1>Payroll</h1>
    <p>Pay your employees seamlessly.</p>

    <div class="main-page">
      <input
        v-model="search"
        type="text"
        placeholder="Search employee by name or ID"
        class="search-input"
        style="margin-bottom: 18px; padding: 8px 12px; width: 75%; border-radius: 5px; border: 1px solid #ccc; font-size: 16px;"
      />

      <PayrollComp
        :records="filteredPayroll"
        @edit="openEditModal"
        @delete="deleteRecord"
        @generate="generatePayslip"
      />

      <div class="modal fade" ref="editModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <form @submit.prevent="saveEdit">
              <div class="modal-header">
                <h5 class="modal-title">Edit Payroll</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-2">
                  <label class="form-label">Employee Name</label>
                  <input v-model="editForm.name" class="form-control" required />
                </div>
                <div class="mb-2">
                  <label class="form-label">Hours Worked</label>
                  <input v-model.number="editForm.hoursWorked" type="number" class="form-control" required />
                </div>
                <div class="mb-2">
                  <label class="form-label">Leave Deductions</label>
                  <input v-model.number="editForm.leaveDeductions" type="number" class="form-control" required />
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { jsPDF } from "jspdf";
import PayrollComp from "@/components/PayrollComp.vue";
import * as bootstrap from "bootstrap";

export default {
  name: "PayrollPage",
  components: { PayrollComp },
  data() {
    return {
      payrollList: [],
      editForm: { id: null, name: "", hoursWorked: 0, leaveDeductions: 0, salary: 0 },
      search: ""
    };
  },
  computed: {
    filteredPayroll() {
      if (!this.search) return this.payrollList;
      const q = this.search.toLowerCase();
      return this.payrollList.filter(emp =>
        emp.name.toLowerCase().includes(q) ||
        String(emp.id).includes(q)
      );
    }
  },
  async mounted() {
    try {
      const [payrollRes, employeeRes] = await Promise.all([
        fetch('/hr-data/payroll_data.json'),
        fetch('/hr-data/employee_info.json')
      ]);
      const payrollData = await payrollRes.json();
      const employeeData = await employeeRes.json();

      this.payrollList = payrollData.payrollData.map(item => {
        const emp = employeeData.employeeInformation.find(e => e.employeeId === item.employeeId);
        return {
          id: item.employeeId,
          name: emp ? emp.name : 'Unknown',
          hoursWorked: item.hoursWorked,
          leaveDeductions: item.leaveDeductions,
          salary: item.finalSalary
        };
      });
    } catch (error) {
      console.error('Failed to fetch payroll data:', error);
    }
  },
  methods: {
    generatePayslip(employee) {
      const doc = new jsPDF();
      doc.setFontSize(18);
      doc.text("Payslip", 105, 20, { align: "center" });
      doc.setFontSize(12);
      doc.text(`Employee Name: ${employee.name}`, 20, 40);
      doc.text(`Employee ID: ${employee.id}`, 20, 50);
      doc.text(`Hours Worked: ${employee.hoursWorked}`, 20, 60);
      doc.text(`Leave Deductions: ${employee.leaveDeductions}`, 20, 70);
      doc.text(`Salary: R${employee.salary}`, 20, 80);

      doc.save(`Payslip_${employee.name.replace(/\s+/g, "_")}.pdf`);
    },
    deleteRecord(id) {
      this.payrollList = this.payrollList.filter((record) => record.id !== id);
    },
    openEditModal(employee) {
      this.editForm = { ...employee };
      const modal = new bootstrap.Modal(this.$refs.editModal);
      modal.show();
    },
    saveEdit() {
      // Example rates, adjust as needed
      const hourlyRate = 500;
      const deductionRate = 200;

      // Calculate salary
      this.editForm.salary =
        (this.editForm.hoursWorked * hourlyRate) -
        (this.editForm.leaveDeductions * deductionRate);

      const index = this.payrollList.findIndex((e) => e.id === this.editForm.id);
      if (index !== -1) {
        this.payrollList.splice(index, 1, { ...this.editForm });
      } else {
        this.payrollList.push({ ...this.editForm });
      }
      const modal = bootstrap.Modal.getInstance(this.$refs.editModal);
      modal.hide();
    },
    addPayroll() {
      const newId = this.payrollList.length
        ? Math.max(...this.payrollList.map(e => e.id)) + 1
        : 1;
      this.editForm = {
        id: newId,
        name: "",
        hoursWorked: 0,
        leaveDeductions: 0,
        salary: 0
      };
      const modal = new bootstrap.Modal(this.$refs.editModal);
      modal.show();
    }
  }
};
</script>
<style>
.search-input {
  display: flex;
  min-width: 200px;
  max-width: 100%;
  margin-bottom: 18px;
  padding: 8px 12px;
  width: 75%;
  border-radius: 5px;
  border: 1px solid #ccc;
  font-size: 16px;
  box-sizing: border-box;
  transition: width 0.2s;
}

@media (max-width: 900px) {
  .search-input {
    width: 60%;
  }
}

@media (max-width: 600px) {
  .search-input {
    width: 100%;
    min-width: 200px;
  }
}
</style>