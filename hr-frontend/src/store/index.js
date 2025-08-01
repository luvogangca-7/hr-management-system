import { createStore } from 'vuex';

export default createStore({
  state: {
    isAdmin: true,
    employee: (() => {
      const stored = JSON.parse(localStorage.getItem('employee'));
      if (!stored) return null;
      return {
        ...stored,
        employee_id: stored.employee_id || stored.id, // Fallback to 'id' if 'employee_id' doesn't exist
        id: stored.employee_id || stored.id, // Consistent ID access
        leaveRecords: stored.leaveRecords || []
      };
    })()
  },

  getters: {
    isAdmin(state) {
      return state.isAdmin;
    },
    isLoggedIn(state) {
      return !!state.employee;
    },
    employee(state) {
      return state.employee || {};
    }
  },

  mutations: {
    adminRole(state) {
      state.isAdmin = true;
    },
    staffRole(state) {
      state.isAdmin = false;
    },

    setEmployee(state, employeeData) {
      const employeeId = employeeData.employee_id || employeeData.id; // Handle both cases
      state.employee = {
        ...employeeData,
        employee_id: employeeId, // Ensured to exist
        id: employeeId,          // Consistent alias
        leaveRecords: employeeData.leaveRecords || []
      };
      localStorage.setItem('employee', JSON.stringify(state.employee));
    },

    logout(state) {
      state.employee = null;
      localStorage.removeItem('employee');
    },

    updateEmployee(state, updatedEmployee) {
      const employeeId = updatedEmployee.employee_id || updatedEmployee.id;
      state.employee = {
        ...updatedEmployee,
        employee_id: employeeId,
        id: employeeId,
        leaveRecords: updatedEmployee.leaveRecords || []
      };
      localStorage.setItem('employee', JSON.stringify(state.employee));
    }
  },

  actions: {}
});