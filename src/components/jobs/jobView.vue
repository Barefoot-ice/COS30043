<template>
  <div class = "job-app">
    <!-- Search Box -->
    <div class="search-box">
      <input 
        v-model="searchQuery" 
        type="text" 
        class="form-control" 
        placeholder="Search for jobs..."
      />
    </div>

    <div class="job-explorer-section">
      <div class="container">
        <JobList :searchQuery="searchQuery" />

        <div class="detail-view">
          <router-view />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import JobList from "./jobList.vue";

export default {
    data() {
        return {
            searchQuery: ""
        };
    },  

    components: {
        JobList
    }
};
</script>
