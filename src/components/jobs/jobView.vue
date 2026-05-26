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

    <div class="tag-filter">
    <span
        class="tag"
        :class="{ active: selectedTag === '' }"
        @click="selectedTag = ''"
    >
        All
    </span>

    <span
        v-for="tag in allTags"
        :key="tag"
        class="tag"
        :class="{ active: selectedTag === tag }"
        @click="selectedTag = tag"
    >
        {{ tag }}
    </span>
    </div>


    <div class="job-explorer-section">
      <div class="container">
        <JobList :searchQuery="searchQuery" :selected-tag="selectedTag" :jobs="jobs" />

        <div class="detail-view">
          <router-view :jobs="jobs" />
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import JobList from "./jobList.vue";
import { api } from "../../lib/api";

export default {
    data() {
        return {
            searchQuery: "",
            selectedTag: "",
            jobs: [],
        };
    },  
    
    async mounted () {
        
    try {
        const rawData = await api.getJobs();

        this.jobs = rawData.map(row => ({
        job_id: row[0],
        job_title: row[1],
        category: row[2],
        location: row[3],
        employment_type: row[4],
        salary_range: row[5],
        job_level: row[6],

        required_skills: JSON.parse(row[7]),
        preferred_qualifications: JSON.parse(row[8]),

        job_description: row[9],
        application_deadline: row[10],
        posted_date: row[11],
        company: row[12],
        supervisor: row[13],
        positions_available: row[14],
        start_date: row[15],

        tags: JSON.parse(row[16])
        }));

    } catch (err) {
        console.error("Failed to load jobs:", err);
    }
    },

    computed: {
        allTags() {
        const tags = new Set();

        this.jobs.forEach(job => {
            job.tags.forEach(tag => tags.add(tag));
        });

        return Array.from(tags);
        }
    },

    components: {
        JobList
    }
};
</script>
