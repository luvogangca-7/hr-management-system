<template>
  <aside class="sidebar" v-if="hideDash">
    <nav>
      <router-link :to="$store.state.isAdmin? '/admin/dashboard' : '/staff/mydashboard'"><i class="bi bi-speedometer2"></i>  {{$store.state.isAdmin? 'Dashboard' : 'My Dashboard'}}</router-link>
      <router-link :to="$store.state.isAdmin? '/admin/employees' : '/staff/myprofile'">        <i :class="$store.state.isAdmin ? 'bi bi-people' : 'bi bi-person'"></i> {{$store.state.isAdmin? 'Employees' : 'My Profile'}}</router-link>
      <router-link :to="$store.state.isAdmin? '/admin/attendance' : '/staff/myattendance'"><i class="bi bi-calendar-check"></i> {{$store.state.isAdmin? 'Attendance' : 'My Attendance'}}</router-link>
      <router-link :to="$store.state.isAdmin? '/admin/payroll' : '/staff/mypayroll'"><i class="bi bi-cash-stack"></i>{{$store.state.isAdmin? 'Payroll' : 'My Payroll'}}</router-link>
      <router-link :to="$store.state.isAdmin? '/admin/leave' : '/staff/myleave'"><i class="bi bi-box-arrow-right"></i>{{$store.state.isAdmin? 'Leave' : 'My Leave'}}</router-link>
      <router-link :to="$store.state.isAdmin? '/admin/performance' : '/staff/myperformance'"><i class="bi bi-bar-chart-line"></i>{{$store.state.isAdmin? 'Performance Review' : 'My Performance Review'}}</router-link>
    </nav>
    <slot name="after-nav"></slot>
  </aside>
</template>

<script>
export default {
    props: {
    hideDash: {
      type: Boolean,
      default: true
    }
  }
}
</script>