<template>
    <div class="page-wrapper">
    <h1>My Profile</h1>
    <p>Welcome back Staff, here you can edit your details!</p>
    <div class="main-page">
      <div class="box-cont">
        <div class="personal-box">

        <div class="profile-pic">
        <svg height='200px'fill="#b0b0b0" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 45.53 45.53" xml:space="preserve" stroke="#b0b0b0" stroke-width="0.00045531999999999994"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M22.766,0.001C10.194,0.001,0,10.193,0,22.766s10.193,22.765,22.766,22.765c12.574,0,22.766-10.192,22.766-22.765 S35.34,0.001,22.766,0.001z M22.766,6.808c4.16,0,7.531,3.372,7.531,7.53c0,4.159-3.371,7.53-7.531,7.53 c-4.158,0-7.529-3.371-7.529-7.53C15.237,10.18,18.608,6.808,22.766,6.808z M22.761,39.579c-4.149,0-7.949-1.511-10.88-4.012 c-0.714-0.609-1.126-1.502-1.126-2.439c0-4.217,3.413-7.592,7.631-7.592h8.762c4.219,0,7.619,3.375,7.619,7.592 c0,0.938-0.41,1.829-1.125,2.438C30.712,38.068,26.911,39.579,22.761,39.579z"></path> </g> </g></svg>
        <br>
        <br>
        <h2>Luvo Gangca</h2>
      </div>
      

      <div class="details">

         <h5><i class="bi bi-briefcase-fill"></i> Role</h5>
        <p>Front End Developer</p>

        <h5><i class="bi bi-building"></i> Department</h5>
        <p>IT Department</p>

        <h5><i class="bi bi-calendar-check-fill"> </i>Date Hired</h5>
        <p>22 July 2025</p>

      </div>
      
    </div>
    <div class="job-box">
      
      <h4><i class="bi bi-info-circle"></i>Basic Information</h4>
      <div class="details">

      
      <h5><i class="bi bi-cake-fill"></i> DOB</h5>
      <p>03 January 1889</p>
      
      <h5><i class="bi bi-gender-ambiguous"></i> Gender</h5>
      <p>Male</p>
      
      <h5><i class="bi bi-person-heart"></i> Marital Status</h5>
      <p>Married to the game</p>
      
      <h5><i class="bi bi-envelope-fill"></i> Email</h5>
      <p>luvogangca@gmail.com</p>
      
      <h5><i class="bi bi-telephone-fill"></i> Phone Number</h5>
      <p>0987654321</p>
      
      <h5><i class="bi bi-geo-alt-fill"></i> Address</h5>
      <p>7 de Laan Cape Town 7750</p>

      <button class="btn btn-outline-secondary" @click="openEditModal">Edit <i class="bi bi-pencil-fill"></i></button>

      </div>
      
      
    </div>
  </div>
  
  
</div>
</div>
</template>
<script>
export default {
  
}
</script>
<style scoped>

.box-cont{
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 18px;
  padding: 10px 50px;
}
.personal-box, .job-box {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  border: 1px solid rgb(182, 180, 180, 0.2);
  border-radius: 12px;
  box-shadow: 1px 1px 8px rgba(0, 0, 0, 0.13);
  background: #fff;
  transition: transform 0.2s, box-shadow 0.2s;
  padding: 20px;
}

.details {
  display: flex;
  flex-direction: column;
  width: 100%;
  background-color: #f3f3f3;
  border: 1px solid #dadada;
  border-radius: 8px;
  padding: 10px;

}

.profile-pic {
  margin-bottom: 20px;
}

/* p {
  font-size: 1.1rem;
} */

i {
  color:#c8c8c8;
}

button:hover {
  color:#f7f7f7
}



</style>