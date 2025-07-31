import { createStore } from 'vuex';

export default createStore({
  state: {
    isAdmin: true,
    employee: JSON.parse(localStorage.getItem('employee')) || null
  },
  getters: {
    isAdmin(state) {
      return state.isAdmin;
    },
    isLoggedIn(state) {
      return !!state.employee;
    },
    employee(state) {
      return state.employee;
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
  state.employee = {
    ...employeeData,
    leaveRecords: employeeData.leaveRecords || [] // Initialize if missing
  };
  localStorage.setItem('employee', JSON.stringify(state.employee));
},
    logout(state) {
      state.employee = null;
      localStorage.removeItem('employee');
    },
    updateEmployee(state, updatedEmployee) {
  state.employee = updatedEmployee;
  localStorage.setItem('employee', JSON.stringify(updatedEmployee)); 
}},
  actions: {}
});
