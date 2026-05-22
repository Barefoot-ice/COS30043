
<template>
<div class="job-detail">
      <div v-if="job">
        <h2>{{ job.job_id }}: {{ job.job_title }}</h2>
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
      <div v-else>
        <p>No job selected. Select a job from the list.</p>
      </div>
    </div>
</template>


<script>
    export default {
        data() {
            return {
            jobs: [{
    "job_id": "MLA101",
    "job_title": "Machine Learning Intern",
    "category": "AI",
    "location": "Remote",
    "employment_type": "Internship",
    "salary_range": "$25/hr",
    "job_level": "Entry-Level",
    "required_skills": ["Python", "Scikit-learn", "Git"],
    "preferred_qualifications": ["Pandas", "Jupyter Notebooks"],
    "job_description": "Join our AI team to assist with model training, evaluation, and data preprocessing. You will contribute to real-world projects and gain hands-on experience in machine learning pipelines and automation tools.",
    "application_deadline": "2025-04-15",
    "posted_date": "2025-03-29",
    "company": "Swinburne AI Lab",
    "supervisor": "Dr. Jane Doe",
    "positions_available": 2,
    "start_date": "2025-05-01",
    "tags": ["machine learning", "internship", "AI"]
  },
  {
    "job_id": "DSC202",
    "job_title": "Data Science Assistant",
    "category": "Data Science",
    "location": "Melbourne",
    "employment_type": "Part-time",
    "salary_range": "$35/hr",
    "job_level": "Mid-Level",
    "required_skills": ["SQL", "Python", "PowerBI"],
    "preferred_qualifications": ["Time series experience"],
    "job_description": "Support the analytics team by preparing datasets, generating dashboards, and assisting with predictive modeling. This role is ideal for someone passionate about data storytelling and visualization.",
    "application_deadline": "2025-04-10",
    "posted_date": "2025-03-25",
    "company": "DataLab Inc.",
    "supervisor": "Ms. Ana Lee",
    "positions_available": 1,
    "start_date": "2025-04-20",
    "tags": ["data", "analytics", "visualization"]
  },
  {
    "job_id": "AIP303",
    "job_title": "AI Research Assistant",
    "category": "AI",
    "location": "Hybrid",
    "employment_type": "Full-time",
    "salary_range": "$65,000 - $75,000",
    "job_level": "Entry-Level",
    "required_skills": ["Python", "PyTorch", "NLP"],
    "preferred_qualifications": ["Transformers", "BERT", "Academic writing"],
    "job_description": "Work closely with researchers to build and evaluate AI models. Responsibilities include literature reviews, experimentation, and documenting findings for publication or internal reports.",
    "application_deadline": "2025-04-22",
    "posted_date": "2025-03-28",
    "company": "DeepThink Labs",
    "supervisor": "Prof. Richard Lin",
    "positions_available": 1,
    "start_date": "2025-05-15",
    "tags": ["research", "AI", "NLP"]
  }
],
            job: null
            };
        },
        methods: {
            loadJob() {
                const jobId = this.$route.params.id;
                this.job = this.jobs.find(j => j.job_id === jobId) || null;
            }
        },
        watch: {
            '$route.params.id': "loadJob"
        },
        mounted() {
            this.loadJob();
        }
            }
</script>