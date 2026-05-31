<template>
  <v-container class="mt-4">
    <v-form ref="form" @submit.prevent="submit">
      <h3>Job Listing Request</h3>
      <v-text-field
          label="Listing ID"
          v-model="job.job_id"
          variant="outlined"
          :rules="[rules.required]"
          required
      ></v-text-field>

      <v-text-field
          label="Job Title"
          v-model="job.job_title"
          variant="outlined"
          :rules="[rules.required]"
          required
      ></v-text-field>
      
      <v-select
          v-model="job.category"
          label="Category"
          variant="outlined"
          :items="['AI', 'Data Science', 'DevOps', 'Software Development', 'Cybersecurity']"
          :rules="[rules.required]"
          required

      ></v-select>
      
      <v-select
          v-model="job.location"
          label="Location"
          variant="outlined"
          :items="['Remote', 'Hybrid', 'Brisbane', 'Sydney', 'Melbourne', 'Canberra', 'Perth']"
          :rules="[rules.required]"
          required
      ></v-select>
      
      <v-select
          v-model="job.employment_type"
          label="Employment Type"
          variant="outlined"
          :items="['Full-time', 'Part-time', 'Contract', 'Internship']"
          :rules="[rules.required]"
          required
      ></v-select>

      <v-text-field
        label="Salary Range"
        v-model="job.salary_range"
        variant="outlined"
        :rules="[rules.required]"
        required
      ></v-text-field>

      <v-select
          v-model="job.job_level"
          label="Job Level"
          variant="outlined"
          :items="['Entry-Level', 'Mid-Level', 'Senior']"
          :rules="[rules.required]"
          required
      ></v-select>

      <v-text-field
        label="Required Skills"
        v-model="job.required_skills"
        variant="outlined"
        :rules="[rules.required]"
        required
      ></v-text-field>

      <v-text-field
        label="Preferred Qualifications"
        v-model="job.preferred_qualifications"
        variant="outlined"
        :rules="[rules.required]"
        required
      ></v-text-field>

      <v-textarea
        label="Job Description"
        v-model="job.job_description"
        variant="outlined"
        auto-grow
        :rules="[rules.required]"
        required
      ></v-textarea>

      <v-text-field
        type="date"
        label="Application Deadline"
        v-model="job.application_deadline"
        variant="outlined"
        :rules="[rules.required]"
        required
      ></v-text-field>

      <v-text-field
        type="date"
        label="Posted Date"
        v-model="job.posted_date"
        readonly
        variant="outlined"
      ></v-text-field>

      <v-text-field
        label="Company"
        v-model="job.company"
        variant="outlined"
        :rules="[rules.required]"
        required
      ></v-text-field>

      <v-text-field
        label="Supervisor"
        v-model="job.supervisor"
        variant="outlined"
        :rules="[rules.required]"
        required
      ></v-text-field>

      <v-text-field
        label="Positions Available"
        type="number"
        v-model="job.positions_available"
        variant="outlined"
        :rules="[rules.required]"
        required
      ></v-text-field>

      <v-text-field
        type="date"
        label="Start Date"
        v-model="job.start_date"
        variant="outlined"
        :rules="[rules.required]"
        required
      ></v-text-field>
      <v-text-field
        label="Tags"
        v-model="job.tags"
        variant="outlined"
        :rules="[rules.required]"
        required
      ></v-text-field>


      <v-col cols="12" class="d-flex justify-content-between mt-4">
        <v-btn type="submit" color="success" class="px-6">Send for approval</v-btn>
      </v-col>
    </v-form>
  </v-container>
</template>
<script>
import { api } from "../../lib/api";
export default {
  data() {
    return {
        rules: {
            required: value => !!value || 'This field is required.'
        },
        job: {
            job_id: '',
            job_title: '',
            category: '',
            location: '',
            employment_type: '',
            job_level: '',
            job_description: '',
            application_deadline: '',
            supervisor: '',
            positions_available: 1,
            start_date: '',
            salary_range: '',
            required_skills: '',
            preferred_qualifications: '',
            posted_date: '',
            company: '',
            tags: '',
        },
    };
  },
  mounted() {
    const today = new Date().toISOString().split('T')[0];
    this.job.posted_date = today;
  },
  methods: {
    async checkId() {
      try {
        const jobId = this.job.job_id;
        if (!jobId) return false; 

        const details = await api.getJobDetail(jobId);
        return details !== null && details !== undefined;
      } catch (error) {
        return false; 
      }
    },
    formatToArrayString(inputStr) {
      if (!inputStr) return '[]';
      const itemsArray = inputStr.trim().split(/\s+/).filter(Boolean);
      const quotedArray = itemsArray.map(item => `'${item}'`);
      return JSON.stringify(quotedArray);
    },
    async submit() {
      const { valid } = await this.$refs.form.validate();
      if (!valid) {
        alert("Please correct the validation errors on the form before submitting.");
        return;
      }

      const idExists = await this.checkId(); 
      if (idExists) {
        alert("This Listing ID already exists. Please pick a unique identifier.");
        return;
      }

      const formattedSkills = this.formatToArrayString(this.job.required_skills);
      const formattedQualifications = this.formatToArrayString(this.job.preferred_qualifications);
      const formattedTags = this.formatToArrayString(this.job.tags);

      try {
        const response = await api.addJob( 
          this.job.job_id,
          this.job.job_title,
          this.job.category,
          this.job.location,
          this.job.employment_type,
          this.job.job_level,
          this.job.job_description,
          this.job.application_deadline,
          this.job.supervisor,
          this.job.positions_available,
          this.job.start_date,
          this.job.salary_range,
          formattedSkills,          
          formattedQualifications,  
          this.job.posted_date,
          this.job.company,
          formattedTags             
        );
        
        if (response.ok) {
          alert("Job request saved successfully.");
          this.$router.push('/jobs');
        } else {
          const errData = await response.json();
          alert(`Error saving updates: ${errData.error || 'Unknown error'}`);
        }
      } catch (error) {
        console.error("Submission error encountered:", error);
        alert("An error occurred during communication with the server.");
      }
    }
  },
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

/* Adds horizontal padding buffer spacing within columns */
.v-col {
  padding-left: 12px !important;
  padding-right: 12px !important;
}
</style>
