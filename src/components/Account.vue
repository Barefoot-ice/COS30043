<template>
<div class='container mt-4'>

 <!-- Page when dets loaded-->
 <!-- View Mode -->
<div v-if="details.username && !isEditing">
    <h3 class="text-center mb-4 fw-bold">Account Details</h3>
    <div class="row g-3">
    <div class="col-12 col-md-6 col-lg-4">
        <label class="form-label fw-bold">Account Username</label>
        <input type="text" class="form-control" v-model="details.username" readonly>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
        <label class="form-label fw-bold">Account Email Address</label>
        <input type="email" class="form-control" v-model="details.email" readonly>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
        <label class="form-label fw-bold">Account Password</label>
        <input type="password" class="form-control" v-model="details.password" readonly>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
        <label class="form-label fw-bold">Time of Account creation</label>
        <input type="text" class="form-control" v-model="details.created_at" readonly>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
        <label class="form-label fw-bold">Account permissions</label>
        <input type="text" class="form-control" v-model="details.role" readonly>
    </div>
    <div class="col-12 text-end mt-4">
        <button type="button" class="btn btn-primary" @click="startEdit">Change Details</button>
    </div>
    </div>
</div>

 <!-- Edit Mode -->
<div v-if="details.username && isEditing">
    <h3 class="text-center mb-4 fw-bold">Account Details</h3>
    <div class="row g-3">
    <div class="col-12 col-md-6 col-lg-4">
        <label class="form-label fw-bold">Account Username</label>
        <input type="text" class="form-control" v-model="editedDetails.username">
    </div>
    <div class="col-12 col-md-6 col-lg-4">
        <label class="form-label fw-bold">Account Email Address</label>
        <input type="email" class="form-control" v-model="editedDetails.email">
    </div>
    <div class="col-12 col-md-6 col-lg-4">
        <label class="form-label fw-bold">Account Password</label>
        <input type="password" class="form-control" v-model="editedDetails.password">
    </div>
    <div class="col-12 col-md-6 col-lg-4">
        <label class="form-label fw-bold">Confirm Password</label>
        <input type="password" class="form-control" v-model="confirmationPassword">
    </div>
    <div class="col-12 col-md-6 col-lg-4">
        <label class="form-label fw-bold">Time of Account creation</label>
        <input type="text" class="form-control" v-model="details.doc" readonly>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
        <label class="form-label fw-bold">Account permissions</label>
        <input type="text" class="form-control" v-model="details.role" readonly>
    </div>
    <div class="col-12 d-flex justify-content-between mt-4">
        <button type="button" class="btn btn-warning" @click="cancelEdit">Revert changes</button>
        <button type="button" class="btn btn-success" @click="saveDetails">Success</button>
    </div>
    </div>
</div>
 <!-- Page when dets unloaded-->
<div v-if="!details.username">
    <h3 class="text-center mb-4 fw-bold">Account Details</h3>
  <p>Account details currently not available, please refresh page</p>
</div>
</div>
</template>

<script>
import { api } from "../lib/api";

export default {

    data() {
        return {
            details: {}, 
            editedDetails: {}, 
            confirmationPassword: "",
            isEditing: false,
        };
    },
    computed: {
        currentUserId() {
            return this.$store.getters.userId;
        }
    },
    async mounted() {
        try {
            if (this.currentUserId) {
                this.details = await api.getAccount(this.currentUserId);
                console.log(this.details.created_at)
            } else {
                console.warn("No user is currently logged in.");
                this.$router.push('/'); 
            }
        } catch (err) {
            console.error("Failed to load user:", err);
        }
    },
    methods: {
        startEdit() {

            this.editedDetails = { ...this.details };
            this.confirmationPassword = this.details.password;
            this.isEditing = true;
        },
        cancelEdit() {
            this.isEditing = false;
        },
        saveDetails() {
            if (this.editedDetails.password !== this.confirmationPassword) {
                alert("Passwords do not match!");
                return;
            }
            //call api and update vuex
            this.details = { ...this.editedDetails }; 
            this.isEditing = false;
        },
    }

    
};
</script>
