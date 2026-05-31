<template>
  <v-container v-if="job" class="mt-4">
    <v-form>
    <p>Please note: some fields cannot be changed after listing Creation</p>
    <v-text-field
        label="Listing ID"
        v-model="job.job_id"
        readonly
        variant="outlined"
    ></v-text-field>

    <v-text-field
        label="Job Title"
        v-model="job.job_title"
        readonly
        variant="outlined"
    ></v-text-field>
    <v-select
        v-model="job.category"
        label="Category"
        variant="outlined"
        :items="['AI', 'Data Science', 'DevOps', 'Software Development', 'Cybersecurity']"
    ></v-select>
    <v-select
        v-model="job.location"
        label="Location"
        variant="outlined"
        :items="['Remote', 'Hybrid', 'Brisbane', 'Sydney', 'Melbourne', 'Canberra', 'Perth']"
    ></v-select>
    <v-select
        v-model="job.employment_type"
        label="Employment Type"
        variant="outlined"
        :items="['Full-time', 'Part-time', 'Contract', 'Internship']"
    ></v-select>

    <v-text-field
      label="Salary Range"
      v-model="job.salary_range"
      readonly
      variant="outlined"
    ></v-text-field>


    <v-select
        v-model="job.job_level"
        label="Job Level"
        variant="outlined"
        :items="['Entry-Level', 'Mid-Level', 'Senior']"
    ></v-select>


    <v-text-field
      label="Required Skills"
      v-model="job.required_skills"
      readonly
      variant="outlined"
    ></v-text-field>

    <v-text-field
      label="Preferred Qualifications"
      v-model="job.preferred_qualifications"
      readonly
      variant="outlined"
    ></v-text-field>

    <v-textarea
      label="Job Description"
      v-model="job.job_description"
      variant="outlined"
      auto-grow
    ></v-textarea>

    <v-text-field
      type="date"
      label="Application Deadline"
      v-model="job.application_deadline"
      variant="outlined"
    ></v-text-field>

    <v-text-field
      label="Posted Date"
      v-model="job.posted_date"
      readonly
      variant="outlined"
    ></v-text-field>

    <v-text-field
      label="Company"
      v-model="job.company"
      readonly
      variant="outlined"
    ></v-text-field>

    <v-text-field
      label="Supervisor"
      v-model="job.supervisor"
      variant="outlined"
    ></v-text-field>

    <v-text-field
      label="Positions Available"
      type="number"
      v-model="job.positions_available"
      variant="outlined"
    ></v-text-field>

    <v-text-field
      type="date"
      label="Start Date"
      v-model="job.start_date"
      variant="outlined"
    ></v-text-field>
        <v-col cols="12" class="d-flex justify-content-between mt-4">
          <v-btn type="button" color="red" class="px-6" @click="jobdelete">Delete listing</v-btn>
          <v-btn type="submit" color="success" class="px-6" @click="submit">Save</v-btn>
        </v-col>
    </v-form>
  </v-container>
</template>

<script>
import { api } from "../../lib/api";
export default {
  data() {
    return {
      job: null,

    };
  },
  methods: {
    async loadJob() {
      const jobId = this.$route.query.id;
      this.job = await api.getJobDetail(jobId);
    },
    async jobdelete() {
        const response = await api.deleteJob(this.job.job_id);
        if (response.ok) {
          alert("Job deleted successfully.");
          this.$router.push('/jobs');
        } else {
          alert("Failed to delete the job listing.");
        }
    },
    async submit() {
        const response = await api.editJob( 
          this.job.job_id,
          this.job.category,
          this.job.location,
          this.job.employment_type,
          this.job.job_level,
          this.job.job_description,
          this.job.application_deadline,
          this.job.supervisor,
          this.job.positions_available,
          this.job.start_date
        );
        
        if (response.ok) {
          alert("Job updates saved successfully.");
        } else {
          const errData = await response.json();
          alert(`Error saving updates: ${errData.error || 'Unknown error'}`);
        }
    }
  },
  mounted() {
    this.loadJob();
  }
};
</script>
<style scoped>
.v-container {
  padding-left: 24px !important;
  padding-right: 24px !important;
  max-width: 1200px !important; 
  margin-left: auto !important;
  margin-right: auto !important;
}

.v-col {
  padding-left: 12px !important;
  padding-right: 12px !important;
}
</style>
