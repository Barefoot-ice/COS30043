<template>
  <div class="container py-4">

    <h2 class="mb-4">Social Feed</h2>

    <!-- Create Post -->
    <div class="card mb-4">
      <div class="card-body">
        <h5 class="card-title">Create Post</h5>

        <form @submit.prevent="submitPost">
          <div class="mb-3">
            <input
              v-model="newPost.title"
              type="text"
              class="form-control"
              placeholder="Post title"
              required
            />
          </div>

          <div class="mb-3">
            <textarea
              v-model="newPost.body"
              class="form-control"
              placeholder="What's on your mind?"
              rows="3"
              required
            ></textarea>
          </div>

          <div class="mb-3">
            <input
              v-model="newPost.tags"
              type="text"
              class="form-control"
              placeholder="Tags (comma separated: api, dev)"
            />
          </div>

          <button class="btn btn-primary" type="submit" :disabled="loading">
            Post
          </button>
        </form>
      </div>
    </div>

    <!-- Loading -->
    <div v-if="loading && posts.length === 0" class="alert alert-info">
      Loading posts...
    </div>

    <!-- Posts -->
    <div v-for="post in posts" :key="post.post_ID" class="card mb-3">
      <div class="card-body">

        <h5 class="card-title">
          {{ post.post_content?.title }}
        </h5>

        <p class="card-text">
          {{ post.post_content?.body }}
        </p>

        <!-- Tags -->
        <div v-if="post.post_content?.tags?.length" class="mb-2">
          <span
            v-for="tag in post.post_content.tags"
            :key="tag"
            class="badge bg-secondary me-1"
          >
            #{{ tag }}
          </span>
        </div>

        <small class="text-muted">
          Posted: {{ formatDate(post.created_at) }}
        </small>

      </div>
    </div>

  </div>
</template>

<script>
import { api } from "../lib/api.js";

export default {
  name: "Social",

  data() {
    return {
      posts: [],
      loading: false,

      newPost: {
        title: "",
        body: "",
        tags: ""
      }
    };
  },

  mounted() {
    this.fetchPosts();
  },

  methods: {
    async fetchPosts() {
      this.loading = true;
      try {
        const data = await api.getPosts();
        this.posts = Array.isArray(data) ? data : [];
      } catch (err) {
        console.error("Failed to load posts:", err);
      } finally {
        this.loading = false;
      }
    },

    async submitPost() {
      const account_id = localStorage.getItem("account_id");

      if (!account_id) {
        alert("No account_id found in localStorage.");
        return;
      }

      this.loading = true;

      try {
        const payload = {
          account_id: parseInt(account_id),
          title: this.newPost.title,
          body: this.newPost.body,
          tags: this.newPost.tags
            ? this.newPost.tags.split(",").map(t => t.trim()).filter(Boolean)
            : []
        };

        const response = await fetch(
          "https://mercury.swin.edu.au/cos30043/s105338913/assignment/api/posts.php",
          {
            method: "POST",
            headers: {
              "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
          }
        );

        const result = await response.json();

        if (!response.ok) {
          throw new Error(result.message || "Failed to create post");
        }

        // Prepend new post to feed
        this.posts.unshift(result);

        // Reset form
        this.newPost.title = "";
        this.newPost.body = "";
        this.newPost.tags = "";

      } catch (err) {
        console.error(err);
        alert(err.message);
      } finally {
        this.loading = false;
      }
    },

    formatDate(timestamp) {
      if (!timestamp) return "";
      return new Date(timestamp).toLocaleString();
    }
  }
};
</script>