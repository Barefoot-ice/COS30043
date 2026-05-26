<template>
  <div class="job-list-container">
    <h3>Job Listings</h3>

    <ul class="job-list">
      <li v-for="job in paginatedJobs" :key="job.job_id" class="job-item">
        <router-link :to="`/jobs/${job.job_id}`">
          {{ job.job_id }} - {{ job.job_title }}
        </router-link>
      </li>
    </ul>

    <nav>
      <ul class="pagination">
        <li :class="['page-item', { disabled: currentPage === 1 }]">
          <button @click="currentPage--" class="page-link">Previous</button>
        </li>
        
        <li v-for="page in visiblePages" :key="page" :class="['page-item', { active: page === currentPage }]">
          <button @click="currentPage = page" class="page-link">{{ page }}</button>
        </li>

        <li :class="['page-item', { disabled: currentPage === totalPages }]">
          <button @click="currentPage++" class="page-link">Next</button>
        </li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
    props: ['searchQuery', 'selectedTag', 'jobs'],

    data() {
        return {
            currentPage: 1,
        };
    },

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

      totalPages() {
        return Math.ceil(this.filteredJobs.length / 8);
      },
    
      paginatedJobs() {
        const start = (this.currentPage - 1) * 8;
        const end = start + 8;
        return this.filteredJobs.slice(start, end);
      },

      visiblePages() {
        const pages = [];    
        for (let page = 1; page <= this.totalPages; page++) {
          pages.push(page);
        }
        return pages;
      }
  }
}
</script>