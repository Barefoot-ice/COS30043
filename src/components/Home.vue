<script>
import { api } from "../lib/api";
export default {
  name: 'Read',

    data: function() {
      return {
        searchQuery: '',
        jobs: []
      }},
      methods: {
      handleSearch: function () {
      if (!this.searchQuery.trim()) return;
        this.$store.commit('setHomeSearch', this.searchQuery);
        this.$router.push({ name: 'jobBlank' });
        this.searchQuery = '';
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
    }
    }
</script>

<template>
  
<div class="container">
     
<div class="row p-3"><div class="col-lg-8 p-3">
  <div class="card">
  <div class="card-header">Job Spotlight</div>
    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div
            v-for="(j, index) in jobs"
            :key="j.job_id" 
            :class="['carousel-item',
            { active: index === 0 }]"
            data-bs-interval="5000">
                <!-- <div class="card"> -->
                    <div class="card-body text-start">
                        <h5 class="card-title">{{j.job_title}}</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">{{j.salary_range}}</h6>
                        <p class="card-text">{{j.job_description}}</p>
                        <div class="text-center"><router-link :to="{ name: 'jobDetail', params: { id: j.job_id } }"> See More </router-link></div>
                    </div>
                <!-- </div> -->
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    </div>
</div>
<div class="col-lg-4 p-3">
                    <div class="card mb-4">
                        <div class="card-header">Quick Search</div>
                        <div class="card-body">
                            <form class="d-flex">
                              <input
                                v-model="searchQuery" 
                                class="form-control"
                                type="text" 
                                placeholder="Enter search term..."
                                @keyup.enter="handleSearch"
                              />
                              <button class="btn btn-primary" @click="handleSearch">Search</button>
                            </form>
                        </div>
                    </div>
                    <!-- <div class="card mb-4">
                        <div class="card-header">Search by Tag</div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6" v-for="tag in allTags">
                                    <ul class="list-unstyled mb-0">
                                        <li><a href="#!">{{tag}}</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    </div>
                    </div>
<br/>
</div>
</template>