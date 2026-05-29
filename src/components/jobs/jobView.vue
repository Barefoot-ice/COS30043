<template>
    <div class="job-app">
        <!-- Search Box -->
        <div class="search-box">
            <input v-model="searchQuery" type="text" class="form-control" placeholder="Search for jobs..." />
        </div>

        <div class="tag-filter">
            <span class="tag" :class="{ active: selectedTag === '' }" @click="selectedTag = ''">
                All
            </span>

            <span v-for="tag in allTags" :key="tag" class="tag" :class="{ active: selectedTag === tag }"
                @click="selectedTag = tag">
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

    async mounted() {

        try {

            this.jobs = await api.getJobs();

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
    
    // Allows search term to be passed from front page
    created() {
    const savedQuery = this.$store.state.homeSearch;

    if (savedQuery) {
      this.searchQuery = savedQuery;

      this.$store.commit('clearHomeSearch');
    }
    },

    components: {
        JobList
    }
};
</script>
