<template>
  <div class = "job-app">
    <div class="job-explorer-section">
      <div class="container">
        <JobList />

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
  components: {
    JobList
  }
};
</script>
