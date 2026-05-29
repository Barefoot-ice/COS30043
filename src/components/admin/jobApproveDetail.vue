<script setup>
import { useRoute, useRouter } from "vue-router"
import { api } from "../../lib/api";
import { ref, watch } from "vue";

const route = useRoute()
const router = useRouter()


const job = ref({})

async function approve() {
    await api.setJobApproved(jobId, true)
    job.value = undefined
    router.push("/admin")
}

async function deny() {
    await api.setJobApproved(jobId, false)
    job.value = undefined
    router.push("/admin")
}

async function updateFetch(jobId) {
    job.value = await api.getJobDetail(jobId)
}

const jobId = route.params.id;
updateFetch(jobId)
watch(() => route.params.id, (newId) => updateFetch(newId))
</script>

<template>
    <div class="job-detail">
        <div v-if="job">
            <h2>{{ job.job_id }}: {{ job.job_title }}</h2>
            <div>
                <button type="button" class="btn btn-success" @click="approve">Approve</button>
                <button type="button" class="mx-1 btn btn-danger" @click="deny">Deny</button>
            </div>
            <div class="detail-content">
                <p><strong>Company:</strong> {{ job.company }}</p>
                <p><strong>Supervisor:</strong> {{ job.supervisor }}</p>

                <h3>Position Details</h3>
                <p><strong>Category:</strong> {{ job.category }}</p>
                <p><strong>Location:</strong> {{ job.location }}</p>
                <p><strong>Employment Type:</strong> {{ job.employment_type }}</p>
                <p><strong>Job Level:</strong> {{ job.job_level }}</p>
                <p><strong>Salary Range:</strong> {{ job.salary_range }}</p>
                <p><strong>Positions Available:</strong> {{ job.positions_available }}</p>

                <h3>Timeline</h3>
                <p><strong>Posted Date:</strong> {{ job.posted_date }}</p>
                <p><strong>Start Date:</strong> {{ job.start_date }}</p>
                <p><strong>Application Deadline:</strong> {{ job.application_deadline }}</p>

                <h3>Skills & Qualifications</h3>
                <p><strong>Required Skills:</strong></p>
                <ul>
                    <li v-for="skill in job.required_skills" :key="skill">{{ skill }}</li>
                </ul>
                <p><strong>Preferred Qualifications:</strong></p>
                <ul>
                    <li v-for="qual in job.preferred_qualifications" :key="qual">{{ qual }}</li>
                </ul>

                <h3>Description</h3>
                <p>{{ job.job_description }}</p>

                <h3>Tags</h3>
                <div class="tags">
                    <span v-for="tag in job.tags" :key="tag" class="tag">{{ tag }}</span>
                </div>
            </div>
        </div>
    </div>
</template>