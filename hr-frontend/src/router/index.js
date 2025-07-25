import { createRouter, createWebHashHistory } from 'vue-router'
import DashboardPage from '@/views/admin/DashboardPage.vue'
import AttendancePage from '@/views/admin/AttendancePage.vue'
import LeavePage from '@/views/admin/LeavePage.vue'
import PayrollPage from '@/views/admin/PayrollPage.vue'
import LoginPage from '@/views/admin/LoginPage.vue'
import PerformanceReview from '@/views/admin/Performance Review.vue'
import MyDashboardPage from '@/views/staff/MyDashboardPage.vue'
import MyProfilePage from '@/views/staff/MyProfilePage.vue'
import MyLeavePage from '@/views/staff/MyLeavePage.vue'
import MyPayrollPage from '@/views/staff/MyPayrollPage.vue'
import MyPerformancePage from '@/views/staff/MyPerformancePage.vue'
import MyAttendancePage from '@/views/staff/MyAttendancePage.vue'

const routes = [
  {
    path: '/admin/dashboard',
    name: 'dashboard',
    component: DashboardPage
  },
  {
    path: '/admin/employees',
    name: 'employees',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: function () {
      return import(/* webpackChunkName: "about" */ '../views/admin/EmployeesPage.vue')
    }
  },
  {
    path: '/admin/attendance',
    name: 'attendance',
    component: AttendancePage
  },
  {
    path: '/admin/leave',
    name: 'leave',
    component: LeavePage
  },
  {
    path: '/admin/payroll',
    name: 'payroll',
    component: PayrollPage
  },
  {
    path: '/',
    name: 'login',
    component: LoginPage
  },
  {
    path: '/admin/performance',
    name: 'performanceReview',
    component: PerformanceReview
  },
  {
    path: '/staff/mydashboard',
    name: 'myDashboard',
    component: MyDashboardPage
  },
  {
    path: '/staff/myprofile',
    name: 'myProfile',
    component: MyProfilePage
  },
  {
    path: '/staff/myleave',
    name: 'myLeave',
    component: MyLeavePage
  },
  {
    path: '/staff/mypayroll',
    name: 'myPayroll',
    component: MyPayrollPage
  },
  {
    path: '/staff/myperformance',
    name: 'myPerformance',
    component: MyPerformancePage
  },
  {
    path: '/staff/myattendance',
    name: 'myAttendance',
    component: MyAttendancePage
  }
]

const router = createRouter({
  history: createWebHashHistory(),
  routes
})

export default router
