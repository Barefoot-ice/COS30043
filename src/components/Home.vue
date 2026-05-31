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
    },
    formatDate(timestamp) {
      if (!timestamp) return "";

      return new Date(timestamp).toLocaleDateString("en-AU", {
        day: "numeric",
        month: "short",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      });
    }
    },
    computed: {       
        paginatedPosts() {
            const start = this.currentPage-1;
            const end = start + 2;
            return this.posts.slice(start, end);
        }
    },
    async mounted () {
        
    try {
            this.jobs = (await api.getJobs()).filter((job) => job.approved === true);
            
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
    </div>
    <div class="row p-3">
        <div class="col">
            <div class="card mb-4">
                <div class="card-header">User Posts</div>
                    <div
                    v-for="post in paginatedPosts"
                    :key="post.post_id"
                    class="card shadow-sm"
                    >
                        <div class="card-body">
                            <!-- User profile display -->
                                <div class="d-flex align-items-center mb-2">
                                    <!-- User profile image (get first letter of name and make a fake username)  -->
                                    <div 
                                        class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2"
                                        style="width: 40px; height: 40px;"
                                    >
                                        {{ post.username?.charAt(0)?.toUpperCase() }}
                                    </div>
                                        <div>
                                            <div class="fw-semibold">{{ post.username }}</div>
                                            <div class="text-muted small">
                                            {{ formatDate(post.created_at) }}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Content -->
                                    <h6 class="fw-bold mb-2">
                                        {{ post.post_content?.title || "Untitled" }}
                                    </h6>
                                    <p class="mb-2 text-dark">
                                    {{ post.post_content?.body || "" }}
                                    </p>
                                    <!-- Tags -->
                                    <div v-if="post.post_content?.tags?.length" class="d-flex flex-wrap gap-1">
                                    <span
                                        v-for="tag in post.post_content.tags"
                                        :key="tag"
                                        class="badge bg-light text-dark border"
                                    >
                                        #{{ tag }}
                                    </span>
                                    </div>
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
                                    <li v-if="currentPage < posts.length - 2" class="page-item">
                                        <span class="page-link">&hellip;</span>
                                    </li>
                                    <li v-if="currentPage < posts.length - 1" class="page-item">
                                        <button @click="currentPage = posts.length-1" class="page-link"> {{ posts.length }} </button>
                                    </li>
                                    <li :class="['page-item', { disabled: currentPage === this.posts.length-1 }]">
                                        <button @click="currentPage++" class="page-link">Next</button>
                                    </li>
                                    <li :class="['page-item', { disabled: currentPage === this.posts.length-1 }]">
                                        <button @click="currentPage=this.posts.length-1" class="page-link">Last</button>
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