<script>
</script>

<template>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <router-link class="navbar-brand" to="/">COS30043 Group Project</router-link>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><router-link class="nav-link" to="/">Home</router-link></li>
                <li class="nav-item"><router-link class="nav-link" to="/FAQ">FAQ</router-link></li>
                <li class="nav-item"><router-link class="nav-link" to="/signup">Sign Up</router-link></li>
            </ul>
        </div>
    </div>
  </nav>
  <router-view />
    <footer class="py-5 bg-dark">
      <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Tuesday 11.30 - Group 1</p></div>
  </footer>
</template>
