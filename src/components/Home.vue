<script>
import { api } from "../lib/api";
export default {
    data: function() {
      return {
        currentPage: 1,
        searchQuery: '',
        jobs: [],
        posts: []
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
        },
        totalPages() {
        return Math.ceil(this.posts.length / 2);
        },
        
        paginatedPosts() {
            const start = this.currentPage;
            const end = start + 2;
            return this.posts.slice(start, end);
        },

        visiblePages() {
            const pages = [];    
            for (let page = this.currentPage; page <= this.currentPage + 1; page++) {
            pages.push(page);
            }
            return pages;
        }
    },
    async mounted () {
        
    try {
        this.jobs = await api.getJobs();
    } catch (err) {
        console.error("Failed to load jobs:", err);
    }
    try {
        this.posts = await api.getPosts();
    } catch (err) {
        console.error("Failed to load posts:", err);
    }

    this.$nextTick(() => {
      const carouselEx = document.getElementById('carouselExample');
      if (carouselEx) {
        const carousel = new bootstrap.Carousel(carouselEx, {
          interval: 5000,
          ride: 'carousel'
        });
        carousel.cycle();
      }
    });

    }
    }
</script>

<template>
  
<div class="container">
    <div class="row p-3">
        <div class="col-lg-8 p-3">
            <div class="card">
                <div class="card-header">Job Spotlight</div>
                <div id="carouselExample" class="carousel slide">
                    <div class="carousel-inner">
                        <div
                        v-for="(j, index) in jobs"
                        :key="j.job_id" 
                        :class="['carousel-item',
                        { active: index === 0 }]"
                        >
                        <div class="card-body text-start">
                        <h5 class="card-title">{{j.job_title}}</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">{{j.salary_range}}</h6>
                        <p class="card-text">{{j.job_description}}</p>
                        <div class="text-center">
                            <router-link :to="{ name: 'jobDetail', params: { id: j.job_id } }"> See More </router-link></div>
                        </div>
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
                    <div class="row p-3">
                        <div class="col">
                        <div class="card mb-4">
                            <div class="card-header">User Posts</div>
                            <!-- Blog post-->
                            <div v-for="p in paginatedPosts" class="card m-2" :key="p.post_id" >
                                <div class="card-body">
                                    <div class="small text-muted">{{p.created_at}}</div>
                                    <h2 class="card-title h4">{{p.post_content.title}}</h2>
                                    <p class="card-text">{{p.post_content.body}}</p>
                                    <!-- <div class="card-group">
                                    <div v-for="t in p.post_content.tags" class="card">
                                    <div class="card-body">
                                        <p class="card-text">{{ t }}</p>
                                    </div>    
                                    </div>
                                    </div> -->
                                    <!-- <a class="btn btn-primary" href="#!">Read more →</a> -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <nav>
                    <div class="row">
                        <div class="col-md-6 px-0 ">
                        <ul class="pagination justify-content-center justify-content-md-end">
                            <li :class="['page-item', { disabled: currentPage === 1 }]">
                            <button @click="currentPage=1" class="page-link">First</button>
                            </li>
                            <li :class="['page-item', { disabled: currentPage === 1 }]">
                            <button @click="currentPage--" class="page-link">Previous</button>
                            </li>
                            <template v-if="currentPage === 1"></template>
                            <template v-else>
                                <li class="page-item">
                                    <button @click="currentPage = 1" class="page-link">1</button>
                                </li>
                                <li v-if="currentPage > 2" class="page-item">
                                    <span class="page-link">&hellip;</span>
                                </li>
                            </template>
                            <li class="page-item active">
                            <span class="page-link rounded-0">{{ currentPage }}</span>
                            </li>
                            </ul>
</div>
<div class="col-md-6 px-0 ">
<ul class="pagination justify-content-center justify-content-md-start">
                            <li class="page-item active ">
                            <span class="page-link rounded-0">{{ currentPage + 1 }}</span>
                            </li>
                            <li v-if="currentPage < posts.length - 3" class="page-item">
                                <span class="page-link">&hellip;</span>
                            </li>

                            <li v-if="currentPage < posts.length - 2" class="page-item">
                                <button @click="currentPage = posts.length-2" class="page-link">
                                    {{ posts.length-1 }}
                                </button>
                            </li>
                            <li :class="['page-item', { disabled: currentPage === this.posts.length-2 }]">
                            <button @click="currentPage++" class="page-link">Next</button>
                            </li>
                            <li :class="['page-item', { disabled: currentPage === this.posts.length-2 }]">
                            <button @click="currentPage=this.posts.length-2" class="page-link">Last</button>
                            </li>
                        </ul>
                        </div>
                    </div>
                        </nav>
                        </div>
                    </div>
                    </div>
<br/>
</template>