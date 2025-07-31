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
      />

      <PayrollComp
        :records="filteredPayroll"
        @edit="openEditModal" 
        @delete="deleteRecord"
      />

      <!-- Edit Modal -->
      <div class="modal fade" ref="editModal" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <form @submit.prevent="saveEdit">
              <div class="modal-header">
                <h5 class="modal-title">Generate PayRoll</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <div class="mb-2">
                  <label class="form-label fw-bold" style="color: black;">Employee Name</label>
                  <input v-model="editForm.name" class="form-control" required />
                </div>
                <div class="mb-2">
                  <label class="form-label fw-bold" style="color: black;">Hours Worked</label>
                  <input v-model.number="editForm.hoursWorked" type="number" class="form-control" required />
                </div>
                <div class="mb-2">
                  <label class="form-label fw-bold" style="color: black;">Leave Deductions</label>
                  <input v-model.number="editForm.leaveDeductions" type="number" class="form-control" required />
                </div>
                <div class="mb-2">
                  <label class="form-label fw-bold" style="color: black;">Tax (10%)</label>
                  <input :value="computedTax" class="form-control" readonly />
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Generate</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import PayrollComp from "@/components/PayrollComp.vue";
import * as bootstrap from "bootstrap";
import axios from "axios";

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
      const q = this.search.trim().toLowerCase();
      if (!q) return this.payrollList;
      return this.payrollList.filter(emp =>
        emp.name.toLowerCase().includes(q) || String(emp.id).includes(q)
      );
    },
    computedTax() {
      const gross = (this.editForm.hoursWorked * 500) - (this.editForm.leaveDeductions * 200);
      return (gross * 0.10).toFixed(2);
    }
  },
  async mounted() {
    await this.fetchPayrollData();
  },
  methods: {
    async fetchPayrollData() {
      try {
        const res = await axios.get("http://localhost/hr-management-system/hr-backend/listpayroll.php");
        if (res.data.success) {
          this.payrollList = res.data.payrollData.map(item => ({
            id: item.employee_id,
            name: item.employee_name,
            hoursWorked: Number(item.hours_worked),
            leaveDeductions: Number(item.leave_deductions),
            salary: Number(item.final_salary)
          }));
        }
      } catch (error) {
        console.error("Failed to fetch payroll data:", error);
      }
    },
    async deleteRecord(id) {
      try {
        const res = await axios.post("http://localhost/hr-management-system/hr-backend/deletePayroll.php", {
          employee_id: id
        });
        if (res.data.success) {
          this.payrollList = this.payrollList.filter(record => record.id !== id);
        } else {
          alert(res.data.message || "Failed to delete record");
        }
      } catch (error) {
        console.error("Error deleting payroll record:", error);
      }
    },
    openEditModal(employee) {
      this.editForm = { ...employee };
      const modal = new bootstrap.Modal(this.$refs.editModal);
      modal.show();
    },
    async saveEdit() {
      const hourlyRate = 500;
      const deductionRate = 200;
      const grossSalary = (this.editForm.hoursWorked * hourlyRate) - (this.editForm.leaveDeductions * deductionRate);
      const tax = grossSalary * 0.10;
      this.editForm.salary = grossSalary - tax;

      try {
        const res = await axios.post("http://localhost/hr-management-system/hr-backend/updatePayroll.php", {
          employee_id: this.editForm.id,
          hours_worked: this.editForm.hoursWorked,
          leave_deductions: this.editForm.leaveDeductions,
          final_salary: this.editForm.salary
        });

        if (res.data.success) {
          const index = this.payrollList.findIndex(e => e.id === this.editForm.id);
          if (index !== -1) {
            this.payrollList.splice(index, 1, { ...this.editForm });
          }
          const modal = bootstrap.Modal.getInstance(this.$refs.editModal);
          modal.hide();
        } else {
          alert(res.data.message || "Failed to save changes");
        }
      } catch (error) {
        console.error("Error saving payroll changes:", error);
      }
    }
  }
};
</script>

<style>
.search-input {
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
  }
}
</style>
