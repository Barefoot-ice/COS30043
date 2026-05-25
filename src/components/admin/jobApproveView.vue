<script setup>
import { ref } from "vue"
import { api } from "../../lib/api"
let jobs = await api.getJobs()

let currentPage = ref(1)
function paginatedJobs() {
    const start = (currentPage.value - 1) * 8;
    const end = start + 8;
    return jobs.slice(start, end);
}

function totalPages() {
    return Math.ceil(jobs.length / 8);
}

function visiblePages() {
    const pages = [];
    for (let page = 1; page <= totalPages(); page++) {
        pages.push(page);
    }
    return pages;
}

console.log(paginatedJobs())

</script>

<template>
    <div class="job-list-container">
        <h3>Job Listings</h3>

        <ul class="job-list">
            <li v-for="job in paginatedJobs()" :key="job.job_id" class="job-item">
                <router-link :to="`/admin/${job.job_id}`">
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