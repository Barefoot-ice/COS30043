<template>
  <div class="job-list-container">
    <h3>Job Listings</h3>

    <ul class="job-list">
      <li v-for="job in filteredJobs" :key="job.job_id" class="job-item">
        <router-link :to="`/jobs/${job.job_id}`">
          {{ job.job_id }} - {{ job.job_title }}
        </router-link>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
    props: ['searchQuery', 'selectedTag', 'jobs'],

    computed: {
        filteredJobs() {
          let result = this.jobs;

              if (this.selectedTag) {
                result = result.filter(job =>
                  job.tags.includes(this.selectedTag)
                );
              }

              if (this.searchQuery) {
                const query = this.searchQuery.toLowerCase();

                result = result.filter(job =>
                  job.job_title.toLowerCase().includes(query)
                );
              }

              return result;

    },
  }
}
</script>