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
// PLACEHOLDER JOBS 
export default {
    props: ['searchQuery'],

    computed: {
        filteredJobs() {
            const query = this.searchQuery.toLowerCase();
            if (!query) {
                return this.jobs;
            }
            else return this.jobs.filter(job => 
                job.job_title.toLowerCase().includes(query)
            );
        }
    },

    data: function() {
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
]
      }
    }
}
</script>