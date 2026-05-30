<template>
  <div class="container py-4">


    <div class="d-flex flex-column gap-4 mx-auto" style="max-width: 720px;">

      <!-- Header -->
      <div class="text-center">
        <h2 class="fw-bold">Social Feed</h2>
        <p class="text-muted mb-0">Latest posts from the community</p>
      </div>

      <!-- Create Post (only displays if logged in) -->
      <div v-if="loggedIn" class="card shadow-sm border-0">
        <div class="card-body">

          <h5 class="mb-3 fw-semibold">Create Post</h5>

          <input
            v-model="newPost.title"
            class="form-control mb-2"
            placeholder="Title"
          />

          <textarea
            v-model="newPost.body"
            class="form-control mb-2"
            placeholder="What's on your mind?"
            rows="3"
          ></textarea>

          <input
            v-model="newPost.tags"
            class="form-control mb-3"
            placeholder="Tags (comma separated)"
          />

          <div class="text-end">
            <button class="btn btn-primary px-4" @click="submitPost">
              Post
            </button>
          </div>

        </div>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="text-center py-5">
        <div class="spinner-border text-primary"></div>
      </div>

      <!-- Error warning display -->
      <div v-else-if="error" class="alert alert-danger">
        {{ error }}
      </div>

      <!-- If theres no posts -->
      <div v-else-if="posts.length === 0" class="alert alert-info text-center">
        No posts found.
      </div>

      <!-- Posts Feed -->
      <div v-else class="d-flex flex-column gap-3">

        <div
          v-for="post in posts"
          :key="post.post_id"
          class="card border-0 shadow-sm"
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
  </div>
</template>

<script>
import { api } from "../lib/api";

export default {
  name: "Social",

  data() {
    return {
      posts: [],
      loading: false,
      error: null,

      newPost: {
        title: "",
        body: "",
        tags: ""
      },
    };
  },

  computed: {
    loggedIn() {
      return this.$store.state.loggedIn;
    },

    user() {
      return this.$store.state.user;
    }
  },

  async created() {
    await this.fetchPosts();
  },

  methods: {
    async fetchPosts() {
      this.loading = true;
      this.error = null;

      try {
        const raw = await api.getPosts();

        //this.posts = raw.map(post => ({
        //  post_id: post.post_id,
        //  username: post.username,
        //  post_content: post.post_content,
        //  created_at: post.created_at,
        //}));

        this.posts = raw; //Straight outta JSON

      } catch (err) {
        this.error = `Failed to load posts: ${err.message}`;
      } finally {
        this.loading = false;
      }
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
    },

    async submitPost() {
      try {
        const payload = {
          account_id: this.user.account_id,
          post_content: {
            title: this.newPost.title,
            body: this.newPost.body,
            tags: this.newPost.tags
              ? this.newPost.tags.split(",").map(t => t.trim())
              : []
          }
        };

        await api.createPost(payload);

        this.newPost.title = "";
        this.newPost.body = "";
        this.newPost.tags = "";

        await this.fetchPosts();

      } catch (err) {
        console.error("Failed to create post:", err);
      }
    }
  }
};
</script>